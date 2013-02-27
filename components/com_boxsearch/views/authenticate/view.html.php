<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

class BoxsearchViewAuthentiate extends JViewLegacy
{    
     public function display($tpl = null)
     {    
          $app = JFactory::getApplication();
          
          //$this->getKeys();
          //$this->authenticateBox();
          parent::display();
     }
}