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
          	$tmp->entries = $files;
          	$filtered = $com_model->filterResults($tmp, $folder);
          	$files = $com_model->hideUnsharedLinks($filtered)->entries;
          }
			$files = self::canDelete($files);
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
	public function deleteFile($file_id, $etag)
	{
		$box_api = new Rest_Client;
		$url = "https://api.box.com/2.0/files/".$file_id;
		$com_model = new BoxsearchModelBoxsearch;
		$token = $com_model->getToken();
		$header =  array('Authorization: Bearer '.$token,'If-Match: '.$etag);
          // results
          $delete = json_decode($box_api->delete($url, array(), $header));
          
          $db = JFactory::getDbo();
          $query = $db->getQuery(true);
		$conditions = array(
	                   'file_id='.$file_id);
		$query->delete($db->quoteName('#__boxsearch_uploads'));
		$query->where($conditions);
		$db->setQuery($query);
		 
		try
		{
			$result = $db->query(); // $db->execute(); for Joomla 3.0.
		}
		catch (Exception $e)
		{
		   
		}
          
          if ($delete->type == 'error')
          {
          	return $delete;
          }
          else
          {
          	return true;
          }
	}
	
	public function canDelete($files)
	{
		$userid = JFactory::getUser()->get('id');
		foreach($files as $file)
		{
			$db = JFactory::getDbo();
          	$query = $db->getQuery(true);
			$query->select('user_id');
			$query->select('file_id');
			$query->from('#__boxsearch_uploads');
			$query->where('file_id='.$file->id);
			$db->setQuery($query);
			// Load the results as a list of stdClass objects.
			$results = $db->loadObject();

			if ($file->id == $results->file_id && $results->user_id == $userid)
			{
				$file->canDelete = 1;
			}
			else {
				$file->canDelete = 0;
			}
		}
		
		return $files;
	}
}