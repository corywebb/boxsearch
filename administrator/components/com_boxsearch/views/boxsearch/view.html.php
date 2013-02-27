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
	protected $client_secret     = '';
	
     public function display($tpl = null)
     {    
     	$this->addToolbar();
     	BoxsearchHelper::addSubmenu('boxsearch');
     	$this->sidebar = JHtmlSidebar::render();
     	$this->getKeys();
     	
     	parent::display($tpl);
     }
     
     protected function addToolbar()
     {
     	JToolbarHelper::title(JText::_('COM_BOXSEARCH_COMPONENT_TITLE'), 'contact.png');
     	JToolbarHelper::preferences('com_boxsearch');
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
          
          if ($params->get('client_secret'))
          {
          	$this->client_secret = $params->get('client_secret');
          }
     }
}   