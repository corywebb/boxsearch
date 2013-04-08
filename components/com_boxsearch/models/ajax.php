<?php
defined( '_JEXEC' ) or die;

JLoader::register('BoxsearchModelBoxsearch', 'components/com_boxsearch/models/boxsearch.php');

class BoxsearchModelAjax extends BoxsearchModelBoxsearch
{
	public function getPagedItems($query, $offset)
	{
		// app and params
          $app = JFactory::getApplication();
          $params = JComponentHelper::getParams('com_boxsearch');

          // use box api
          $box_api = new Rest_Client;
          // search url with query
          $url = "https://api.box.com/2.0/search?query=".$query."&offset=".$offset;
          echo $url;
          // get token
          $token = $this->getToken();

          // curl header
          $header =  array('Authorization: Bearer '.$token);
          // results
          $results = json_decode($box_api->get($url, $header));
               
          if ($app->input->get('filter_id') && $query)
          {
               //filter results
               $pattern = $app->input->get('filter_id');
               $results = $this->filterResults($results, $pattern);
          }
               
          if ($params->get('hide_unshared'))
          {
               //echo "hiding unshared";
               $results = $this->hideUnsharedLinks($results);
          }
        
          $results = $this->replaceCreatedBy($results);

          return json_encode($results);
	}
}