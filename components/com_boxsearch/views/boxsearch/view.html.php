<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

class BoxsearchViewBoxsearch extends JViewLegacy
{    
	protected $api_key         = '';
     protected $client_id       = '';
     protected $auth_secret     = '';
	
     public function display($tpl = null)
     {    
     	$this->getKeys();
     	$this->authenticateBox();
          parent::display();
     }
     
     public function authenticateBox()
     {    
     	$auth_app     =    new Rest_Client;
     	
     	$url = 'https://api.box.com/oauth2/authorize';
          // auth params
          $params = array('response_type'=>'code',
                           'client_id'=>$this->client_id,
                           'state'=>'authenticated');
                    
                    // authenticate the app
          $auth = $auth_app->post($url,  $params);
          echo $auth;
     }
     
     protected function getKeys()
     {
          // get keys stored in parameters
          $params = JComponentHelper::getParams('com_boxsearch');
          $this->params = $params;
          // get api key
          if ($params->get('api_key'))
          {
               $this->api_key = $params->get('api_key');
          }
          
          // get client id
          if ($params->get('client_id'))
          {
               $this->client_id = $params->get('client_id');
          }
          
          if ($params->get('auth_secret'))
          {
               $this->auth_secret = $params->get('auth_secret');
          }
     }
}