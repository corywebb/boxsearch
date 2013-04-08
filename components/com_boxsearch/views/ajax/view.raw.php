<?php

class BoxsearchViewAjax extends JViewLegacy
{    
	public $results;
     public function display($tpl = null)
     {    
     	$app = JFactory::getApplication();
     	$model =  new BoxsearchModelAjax;
     	$query = $app->input->get('query');
     	$offset = $app->input->get('offset');
     	if (isset($query) && isset($offset))
     	{
     		print_r($model->getPagedItems($query, $offset));
     	}
     	
     	    
          parent::display();
     }
}