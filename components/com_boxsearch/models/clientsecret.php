<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class BoxsearchModelClientsecret extends JModelList
{
     
     public function setSecret($token)
     {
          $db = JFactory::getDbo();
          $query = $db->getQuery(true);

          // set access token
	     $fields = array(
	         'value=\''.$token->access_token.'\'',
	         'date=\''.JFactory::getDate()->toSql().'\''
	         );
		$conditions = array(
		    'name=\'access_token\'', 
		    );
		 
		$query->update($db->quoteName('#__boxsearch_keys'))->set($fields)->where($conditions);
		$db->setQuery($query);
		try {
			    // Execute the query in Joomla 2.5.
			    $result = $db->query();
		  }
		  catch (Exception $e) {
			    // catch any database errors.
		  }
		
		$query = $db->getQuery(true);
          // set access token
          $fields = array(
              'value=\''.$token->refresh_token.'\'',
              'date=\''.JFactory::getDate()->toSql().'\''
              );
          $conditions = array(
              'name=\'refresh_token\'', 
              );
          $query->update($db->quoteName('#__boxsearch_keys'))->set($fields)->where($conditions);
          $db->setQuery($query);
          
          try {
			    // Execute the query in Joomla 2.5.
			    $result = $db->query();
		  }
		  catch (Exception $e) {
			    // catch any database errors.
		  }
          
          //print_r($query->__toString());
          //echo "setting secrets";
          //exit ();
     	
     }
     public function refresh()
     {
     	$params = JComponentHelper::getParams('com_boxsearch');
     	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
		    ->select('value, date')
		    ->from('#__boxsearch_keys')
		    ->where('name=\'refresh_token\'');
		 
		$db->setQuery($query);
		$result = $db->loadObject();
		
		
		
		// no result so we need to auth
		if (!isset($result->value) || $result->value == '')
		{
			return true;
		}
          
		// result is valid, so check expiration
		$current_date = JFactory::getDate();
		$saved_date = $result->date;
		$expire_date = date('Y-m-d', strtotime($saved_date. ' + '.$params->get('refresh_token_expire', '14').' days'));
		
		if (strtotime($current_date) > strtotime($expire_date))
		{
			// if the current date is greater
			// than expired, we want to refresh!
			return true;
		}
		else
		{
			// if the current date is less than expired
			// we don't need to refresh
			return false;
		}
     }
}