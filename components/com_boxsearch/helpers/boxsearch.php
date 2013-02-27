<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */



class BoxsearchHelper {
	
	/*
	 * function authenticates the application to box.com using the box api
	 * returns the output from box
	 */
	
     public static function authenticateBox()
     {    
     	echo 'authenticating';
          $auth_app =     new Rest_Client;
          $com_boxsearch_params   = JComponentHelper::getParams('com_boxsearch');
          
          $url = 'https://api.box.com/oauth2/authorize';
          // auth params
          $params = array('response_type'=>'code',
                           'client_id'=>$com_boxsearch_params->get('client_id'),
                           'state'=>'authenticated');
                    
          // authenticate the app
          $auth = $auth_app->post($url,  $params);
          return $auth;
     }
     
     /*
      * gets the secret tokens from the box.com api
      * returns the result from box.com api
      */
     
     public static function getClientSecret()
     {
     	$auth_app = new Rest_Client();
     	$com_boxsearch_params   = JComponentHelper::getParams('com_boxsearch');
     	$url      =    'https://api.box.com/oauth2/token';
          $params   =    array('grant_type'=>'authorization_code',
                               'code'=>JFactory::getApplication()->input->get('code'),
                               'client_id'=> $com_boxsearch_params->get('client_id'),
                               'client_secret'=>$com_boxsearch_params->get('client_secret')
                              );
          
          $token = json_decode($auth_app->post($url,  $params));
          return $token;
     }
     
     /*
      * runs the refresh command to the box.com api and returns the result from box.com api
      */
     
     public static function refreshAccess($refreshToken)
     {
     	$auth_app = new Rest_Client();
          $com_boxsearch_params   = JComponentHelper::getParams('com_boxsearch');
          $url      =    'https://api.box.com/oauth2/token';
          $params   =    array('grant_type'=>'refresh_token',
                               'refresh_token'=>$refreshToken,
                               'client_id'=> $com_boxsearch_params->get('client_id'),
                               'client_secret'=>$com_boxsearch_params->get('client_secret')
                              );
          
          return json_decode($auth_app->post($url,  $params));
     }
     
     /*
      * returns the file icon based on the type provided
      * switches based on 'image', 'document', 'video', or 'audio'
      */
     
     public static function getFileIcon($filename)
     {
     	$type = self::getFileType($filename);
     	$iconpath = 'media/com_boxsearch/icons/';
     	switch ($type)
     	{
     		case 'image':
                    $file_icon = 'image_icon.png';
                    break;
     		case 'document':
                    $file_icon = 'document_icon.png';
                    break;
     		case 'audio':
     			$file_icon = 'audio_icon.png';
                    break;
     		case 'video':
     			$file_icon = 'video_icon.png';
     		     break;
     		case 'pdf':
     			$file_icon = 'pdf_icon.png';
     			break;
     		default:
     			$file_icon = 'default_icon.png';
     	}
          return $iconpath.$file_icon;
     }
     
     /*
      * compares the file name's extension and returns either
      * video, image, audio, or document based on the extension
      */
     
     public static function getFileType($filename)
     {
     	$file = pathinfo($filename);
     	$ext = strtolower($file['extension']);
     	switch($ext)
     	{
     		case 'txt':
     		case 'doc':
     		case 'docx':
     		case 'rtf':
     		   $filetype = 'document';
     		   break;
     		case 'jpeg':
     		case 'jpeg':
     		case 'gif':
     		case 'png':
     		case 'bmp':
     		case 'psd':
     		   $filetype = 'image';
     		   break;
     		case 'mp3':
     		case 'wma':
     		case 'wav':
     		case 'm4a':
     		case 'ogg':
     		case 'flac':
     		   $filetype = 'audio';
     		   break;
     		case 'mp4':
     		case 'wmv':
     		case 'avi':
     		case 'fla':
     		case 'swf':
     		case 'mpeg':
     		   $filetype = 'video';
     		   break;
     		case 'pdf':
     		   $filetype = 'pdf';
     		   break;
     		default:
     		   $filetype = 'other';
     	}
     	return $filetype;
     }
}