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
			
		if ($app->input->get('filter_id') && $query)
		{
			//filter results
			$pattern = $app->input->get('filter_id');
			$results = $this->filterResults($results, $pattern);
		}
			
		if ($params->get('hide_unshared'))
		{
			//echo "hiding unshared";
			$results = $this->hideUnsharedLinks($results);
		}
        
          $results = $this->replaceCreatedBy($results);

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

	public function filterResults($results, $pattern)
	{
		$params = JComponentHelper::getParams('com_boxsearch');
		$app = JFactory::getApplication();
			
		// store copy here to delete from
		$resultsStore = $results;

		//keep matches
		$matches = array();

		// loop through results to remove unwanted results
		for ($i = 0; $i <= count($results->entries)+1; $i++)
		{

				// loop through path ids
				foreach ($results->entries[$i]->path_collection->entries as $result)
				{
					// if one in the path matches our search, store the index so it's not removed
					if ($result->id == $pattern)
					{
						$matches[] = $i;
						break 1;
					}
				}

		}

		// counter
		$x=0;
		// parse each entry and remove from our store if they aren't in our array
		foreach ($results->entries as $entry)
		{
			// remove any index not in our search
			if (!in_array($x, $matches))
			{
				unset($resultsStore->entries[$x]);
			}
			$x++;
		}

		// return the modified results array to the model
		return $resultsStore;
	}

	public function hideUnsharedLinks($results)
	{
		JLoader::register('BoxsearchHelper', 'components/com_boxsearch/helpers/boxsearch.php');
		$params = JComponentHelper::getParams('com_boxsearch');
		$app = JFactory::getApplication();
		$pattern = $app->input->get('filter_id');
			
		// store the object here so we can remove things.
		$results->entries = array_values($results->entries);
		$resultsStore = $results;

		// keep match indexes
		$matches = array();

		for ($i = 0; $i <= count($results->entries) +1; $i++)
		{
			if ($results->entries[$i]->shared_link == null || !($results->entries[$i]->shared_link->url))
			{
				unset($resultsStore->entries[$i]);
			}
		     else
               {
                    $resultsStore->entries[$i]->icon = BoxsearchHelper::getFileIcon($results->entries[$i]->shared_link->download_url);
               }
		}
			
		return $resultsStore;
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
		$post_vars['parent_id'] = $app->input->get('subfolders');
        

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = json_decode(curl_exec($ch));
		curl_close($ch);
		
		if (isset($data->type) && $data->type=='error')
		{
			JFactory::getApplication()->enqueueMessage($data->message, 'error');
		}
	     elseif (isset($data->entries))
	     {
               JFactory::getApplication()->enqueueMessage(JText::_('COM_BOXSEARCH_UPLOAD_SUCCESS'), 'success');
               $this->recordUploads($data->entries);
               $this->createShareLink($data->entries[0]->id);
          }

		return $data;
	}

	public function recordUploads($data)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$user = JFactory::getUser();
		$user_id = $user->get('id');

		// Insert columns.
		$columns = array('user_id', 'file_id');
		
		// Insert values.
		$values = array($db->quote($user_id), $db->quote($data[0]->id));
		
		// Prepare the insert query.
		$query
		->insert($db->quoteName('#__boxsearch_uploads'))
		->columns($db->quoteName($columns))
		->values(implode(',',$values));
		
		// Reset the query using our newly populated query object.
          $db->setQuery($query);
		try
		{  
			$result = $db->query();
			// Execute the query in Joomla 2.5.
		}
		catch (Exception $e)
		{
			// catch any database errors.
		}
	}
	
	public function createShareLink($file_id)
	{
		// box api
		$box_api =     new Rest_Client;
		// the url
          $url = 'https://api.box.com/2.0/files/'.$file_id;
          // get token
          $token = $this->getToken();
          // header
          $header_details = array('Authorization: Bearer '.$token);
          //  params
          //$params = array();
          $params = '{"shared_link": {"access": "open"}}';
     
          // authenticate the app
          $createShareLink = $box_api->put($url,  $params, $header_details);
          
          return $createShareLink;
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


		// if there's subfolders return them. If we didn't get any return false
		if (count($subfolders))
		{
		     return $subfolders;
		}
		else
		{
		     return false;
		}
		
		
	}
    
    public function replaceCreatedBy($results)
    {
       $db = JFactory::getDbo();
    	foreach ($results->entries as $result)
    	{
    		
         	$query = $db->getQuery(true);
		$query->select('user_id');
		$query->select('file_id');
		$query->from('#__boxsearch_uploads');
		$query->where('file_id='.$result->id);
		$db->setQuery($query);
		// Load the results as a list of stdClass objects.
		$db_file = $db->loadObject();

		if ($db_file && $result->id == $db_file->file_id)
		{	
               $createby = JFactory::getUser($db_file->user_id);
               // change the value of the name to a recorded alias
			$result->created_by->name = $createby->get('name');
		}
    	} 
    	return $results;
    }
}