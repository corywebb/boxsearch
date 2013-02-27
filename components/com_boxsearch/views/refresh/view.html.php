<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

class BoxsearchViewRefresh extends JViewLegacy
{    
     public function display($tpl = null)
     {    
     	$model = $this->getModel('refresh');
     	$refresh_token = $model->getRefreshToken();
     	
     	echo "Refesh Token";
          print_r($refresh_token);
     	
          $new_token = BoxsearchHelper::refreshAccess($refresh_token);
       
          $model->setSecret($new_token);
          

          
          echo "new token";
          print_r($new_token);
          parent::display();
          
     }
     
}