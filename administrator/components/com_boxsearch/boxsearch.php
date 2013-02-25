<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

defined('_JEXEC') or die;

JLoader::register('BoxsearchHelper', __DIR__ . '/helpers/boxsearch.php');

$controller    = JControllerLegacy::getInstance('Boxsearch');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
