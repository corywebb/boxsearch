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
 	
      
        if ($app->input->get('filter') && $query) {
            //filter results
           $results = $this->filterResults($results);
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
         
         $app = JFactory::getApplication();
         $pattern = "/".$app->input->get('filter')."/i";
 
         // loop through results to remove unwanted results
         for ($i = 0; $i <= count($results); $i++)
         {
             // loop through path way to find matches and remove if not found.
             foreach ($results->entries[$i]->path_collection->entries as $result)
             {
                 $matches = array();
                 // check for matches. if not found add index to array
                 if (!preg_match($pattern, $result->name))
                 {
                     $matches[] = $i;
                 }
             }
             // if the index is in our array we remove it from the results array
             if (in_array($i, $matches))
             {
                 unset($results->entries[$i]);
             }
         }
         
         // return the modified results array to the model
         return $results;
     }
}