<?php
class BoxsearchModelRefresh extends JModelList
{
     public function getRefreshToken()
     {
          $db = JFactory::getDbo();
          $query = $db->getQuery(true);
          $query->select('value');
          $query->from('#__boxsearch_keys');
          $query->where('name=\'refresh_token\'');
          $db->setQuery($query);

          return ($db->loadObject()->value);
     }
     
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
               $result = $db->execute();
          } catch (Exception $e) {
              // Catch the error.
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
    			$result = $db->query(); // Use $db->execute() for Joomla 3.0.
			} catch (Exception $e) {
    		// Catch the error.
          }
      }
}