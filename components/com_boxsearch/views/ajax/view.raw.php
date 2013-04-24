<?php

class BoxsearchViewAjax extends JViewLegacy
{    
	 public $results;
     public function display($tpl = null)
     {    
     	$app = JFactory::getApplication();
     	$model =  new BoxsearchModelAjax;
     	$boxModel = new BoxsearchModelBoxsearch();
     	$query = $app->input->get('query');
     	$offset = $app->input->get('offset');
     	$app->input->set('filter_id', $app->input->get('filter'));
     	if (isset($query) && isset($offset))
     	{   
     	     $unfiltered = $model->getPagedItems($query, $offset);
     	     $unshared = $boxModel->hideUnsharedLinks($unfiltered);
     		$this->results = $unshared;
     	}
     	
     	    
          parent::display();
     }
}