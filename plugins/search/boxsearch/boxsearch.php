<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Content Search plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Search.content
 * @since		1.6
 */
class plgSearchBoxsearch extends JPlugin
{
	/**
	 * @return array An array of search areas
	 */
	function onContentSearchAreas()
	{
		static $areas = array(
			'boxsearch' => 'Boxsearch'
			);
			return $areas;
	}

	/**
	 * Content Search method
	 * The sql must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav
	 * @param string Target search string
	 * @param string mathcing option, exact|any|all
	 * @param string ordering option, newest|oldest|popular|alpha|category
	 * @param mixed An array if the search it to be restricted to areas, null if search all
	 */
	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
		$rows[] = (object) array(
                        'href'        => 'index.php?option=com_newsfeeds&view=newsfeed&catid=',
                        'title'       => 'extension',
                        'section'     => 'Boxsearch',
                        'created'     => '2013-01-10',
                        'text'        => 'extension',
                        'browsernav'  => '1'
                );
		

		$box = self::getBoxResults($text);
		
		return $box;
	}
	
	/**
	 * calls to the com_boxsearch component model to run a search and get the results. 	 
	 * @param string Target search string
	 */
	function getBoxResults($text)
	{
		JLoader::import('joomla.application.component.model');
		JLoader::register('Rest_Client', 'components/com_boxsearch/helpers/boxsearch_api.php');
		require_once 'components/com_boxsearch/models/boxsearch.php';
		
		$model = JModel::getInstance('Boxsearch', 'BoxsearchModel');
		$results = $model->getSearch($text);
		
		return self::formatBoxResults($results);
	}
	
	/**
	 * formats the results as a result for Joomla. 	 
	 * @param string Target search string
	 */
	function formatBoxResults($results)
	{
		$rows = array();
		
		$download_link = $this->params->get('download_type', 'share');
		
		// check xml option for the download type
		if ($download_link=='direct') {
				$url = 'download_url';
		}
		else {
			$url = 'url';
		}
		
		foreach ($results->entries as $result) {	
			$download_url = '';
			
			if (isset($result->shared_link->$url)) {
				$download_url = $result->shared_link->$url;
			}

			$rows[] = (object) array(
                        'href'        => $download_url,
                        'title'       => $result->name,
                        'section'     => 'Boxsearch',
                        'created'     => $result->created_at,
                        'text'        => $result->name,
                        'browsernav'  => '1'
                );
		}
		
		return $rows;
	}
}
