<?php
defined( '_JEXEC' ) or die;

class BoxsearchModelBoxsearch extends JModelLegacy
{
     public function getSearch($query)
     {
     	// app and params
     	$app = JFactory::getApplication();
     	$params = JComponentHelper::getParams('com_boxsearch');
     	
     	// use box api
     	$box_api = new Rest_Client;
     	// search url with query 
     	$url = "https://api.box.com/2.0/search?query=".$query;
        // get token
        $token = $this->getToken();

        // curl header
        $header =  array('Authorization: Bearer '.$token);
        // results
        $results = json_decode($box_api->get($url, $header));
        
        if ($params->get('debug'))
        {
        	echo "<pre>";
        	echo "<h4>"."Unfiltered Results"."</h4>";
        	print_r($results);
        	echo "</pre>";
        }
      
        if ($app->input->get('filter_id') && $query)
        {
           //filter results
           $results = $this->filterResults($results);
        }
        
        if ($params->get('debug'))
        {
        	echo "<pre>";
        	echo "<h4>"."After Filtering"."</h4>";
        	print_r($results);
        	echo "</pre>";
        }
        
        if ($params->get('hide_unshared'))
        {
            echo "hiding unshared";
            $results = $this->hideUnsharedLinks($results);
        }
        
        if ($params->get('debug'))
        {
        	echo "<pre>";
        	echo "<h4>"."After Unshared Removed"."</h4>";
        	print_r($results);
        	echo "</pre>";
        }
        
       return $results;
     }
     
     public function getToken()
     {
     	$db = JFactory::getDbo();
          $query = $db->getQuery(true);
          $query->select('value');
          $query->from('#__boxsearch_keys');
          $query->where('name=\'access_token\'');
          $db->setQuery($query);
          
          return ($db->loadObject()->value);
     }
     
     /*
      * loop through the results and filter out based on regex match from menu item.
      * essentially a filtered search
     */
     
     public function filterResults($results)
     {
         $params = JComponentHelper::getParams('com_boxsearch');
         $app = JFactory::getApplication();
         $pattern = $app->input->get('filter_id');
         // loop through results to remove unwanted results
         for ($i = 0; $i <= count($results->entries)+1; $i++)
         {
             if (isset($results->entries[$i]->path_collection->entries))
             {
                 // loop through path way to find matches and remove if not found.
                 foreach ($results->entries[$i]->path_collection->entries as $result)
                 {
                     $matches = array();
                     // check for matches. if not found add index to array
                     if ($pattern === $result->id)
                     {
                         $matches[] = $i;
                         break 1;
                     }
                 }
                 // if the index is in our array we remove it from the results array
                 if (!in_array($i, $matches))
                 {
                     unset($results->entries[$i]);
                 }
             }//end isset if
         }

         // return the modified results array to the model
         return $results;
     }
     
     public function hideUnsharedLinks($results)
     {
         $params = JComponentHelper::getParams('com_boxsearch');
         $app = JFactory::getApplication();
         $pattern = $app->input->get('filter_id');
         
         $matches = array();
         // loop through results to remove unwanted results
         $i = 0;
         foreach ($results->entries as $entries)
         {
             // if there's no share link, remove the entry
             if (!$entries->shared_link)
             {
                 unset($results->entries[$i]);
             }
             $i++;
         }
			
         return $results;
     }
     
     public function uploadFile($file)
     {
         $url = 'https://api.box.com/2.0/files/content';
         $app = JFactory::getApplication();
         
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");

            $token = $this->getToken();
            
            //this is my method to construct the Authorisation header
            $header_details = array('Authorization: Bearer '.$token);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_details);

            $post_vars = array();
            $post_vars['filename'] = "@".$file;
            $post_vars['parent_id'] = $app->input->get('filter_id');

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
            $data = curl_exec($ch);
            curl_close($ch);
            return json_decode($data);
     }
     
     public function uploadOlderFile($file)
     {
     	// app and params
     	$app = JFactory::getApplication();
     	$params = JComponentHelper::getParams('com_boxsearch');
     	
     	// use box api
     	$box_api = new Rest_Client;
     	// search url with query 
     	$url = "https://upload.box.com/api/2.0/files/content";
        // get token
        $token = $this->getToken();

		//echo $file['tmp_name'];
        // curl header
        $header =  array('Authorization: Bearer '.$token);
        $opt = array();
        $opt['filename'] = "\"@".$file['tmp_name']."\"";
        $opt['folder_id'] = "0";//$app->input->get('filter_id');
        print_r($opt);
        // results
        $results = $box_api->post($url, $header, $opt);
		
		print_r($results);
		
     }
     
     
     public function uploadFileOld($file)
     {
     	$app = JFactory::getApplication();
     	$params = JComponentHelper::getParams('com_boxsearch');
     	$box_api = new Box_Rest_Client($params->get('api_key'));
     	$box_api->auth_token = $this->getToken();

     	/*
     	$file = new Box_Client_File($file['tmp_name'], $file['name']);
     	$file->attr('folder_id', $app->input->get('filter_id'));
     	*/
     	echo ($box_api->upload($file));
     	
     	return $upload;
     }
     
     public function getSubFolders($folder_id)
     {
      	// app and params
      	$app = JFactory::getApplication();
      	$params = JComponentHelper::getParams('com_boxsearch');
     	
      	// use box api
      	$box_api = new Rest_Client;
      	// search url with query 
        $url = "https://api.box.com/2.0/folders/".$folder_id;
        // get token
        $token = $this->getToken();

        // curl header
        $header =  array('Authorization: Bearer '.$token);
        // results
        $folders = json_decode($box_api->get($url, $header));
        
        $subfolders = array();
        
        foreach($folders->item_collection->entries as $item)
        {
            if ($item->type == 'folder') {
                $subfolder = new stdClass;
                $subfolder->name = $item->name;
                $subfolder->id = $item->id;
                $subfolders[] = $subfolder;
            }

        }
        return $subfolders;
     }
}