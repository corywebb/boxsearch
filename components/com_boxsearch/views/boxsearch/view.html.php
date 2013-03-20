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
     protected	   $upload		  = '';	
     public        $filter;
         
     public function display($tpl = null)
     {    
		
		$app = JFactory::getApplication();     
     	$query = $app->input->get('query');
     	$upload = $app->input->get('action');
     	$model = $this->getModel();
        
        if ($menu = $app->getMenu()->getActive()) {
              $menuParams   = new JRegistry;
        	  $menuParams->loadString($menu->params);
              $filter_id    =  $menuParams->get('filter_id');
              $filter_label =  $menuParams->get('filter_label');
              $app->input->set('filter_id', $filter_id);
              $app->input->set('filter_label', $filter_label);
              
        }
        
        
     	
     	// uploaded file
     	if (!empty($upload) && $upload == 'upload_file') {
     		$JFile = new JInputFiles;
     		$file = $JFile->get('file');
            $path = "tmp/" . JFile::makeSafe($file['name']);
            JFile::copy($file['tmp_name'], $path);
     		$upload = $model->uploadFile($path);
     		if (!empty($upload->type) && $upload->type == 'error') {
                
     		    echo $upload->code;
     		}
            else {
                echo "SUCCESS";
            }
            JFile::delete($path);
     	}
        
        // show search results
        if (!empty($query)) {
     		$this->results = $model->getSearch($query);
     	}
     	
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