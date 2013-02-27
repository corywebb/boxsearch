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
	protected     $api_key       = '';
     protected     $client_id     = '';
     protected     $auth_secret   = '';
	protected     $results       = '';
     
     public function display($tpl = null)
     {    
     	$this->results = $this->get('search');
     	$this->getKeys();
          parent::display();
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