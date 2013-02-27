<?php
class BoxsearchHelper {
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
     
}