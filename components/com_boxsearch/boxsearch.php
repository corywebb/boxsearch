<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

defined('_JEXEC') or die;

JLoader::register('Box_Rest_Client_Auth', __DIR__ . '/helpers/boxsearch_api.php');
JLoader::register('Rest_Client', __DIR__ . '/helpers/boxsearch_api.php');
JLoader::register('Box_Rest_Client', __DIR__ . '/helpers/boxsearch_api.php');
JLoader::register('BoxsearchHelper', __DIR__ . '/helpers/boxsearch.php');

$doc = JFactory::getDocument();
$doc->addStyleSheet('media/com_boxsearch/css/com_boxsearch.css');
$doc->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
$doc->addScript('media/com_boxsearch/js/com_boxsearch.js');


$controller = JControllerLegacy::getInstance('Boxsearch');	
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();