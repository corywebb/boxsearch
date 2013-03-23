<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 *
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

class BoxsearchModuleHelper
{
	
	public function getUserUploads($user_id, $folder='')
	{
		$db = JFactory::getDbo();
          $query = $db->getQuery(true);
          $query->select('user_id');
          $query->select('file_id');
          $query->from('#__boxsearch_uploads');
          $query->where('user_id='.$user_id);
          $db->setQuery($query);
          // Load the results as a list of stdClass objects.
          $results = $db->loadObjectList();
          $com_model = new BoxsearchModelBoxsearch;
          
          $files = array();
          foreach ($results as $result)
          {
          	$files[] = self::getBoxFile($result->file_id);
          }
          
          if (isset($folder))
          {
          	$tmp->entries = $com_model->filterResults($files, $folder);
          	$files = $com_model->hideUnsharedLinks($tmp)->entries;
          }
          
         return $files;
	}
	
	public function getBoxFile($file_id)
	{
		// use box api
          $box_api = new Rest_Client;
          // search url with query
          $url = "https://api.box.com/2.0/files/".$file_id;
          // get token
          $com_model = new BoxsearchModelBoxsearch;
          
          $token = $com_model->getToken();
          
          // curl header
          $header =  array('Authorization: Bearer '.$token);
          // results
          $file = json_decode($box_api->get($url, $header));
          return $file;
	}
}