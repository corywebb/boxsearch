<?php
/**
 * @package		Joostrap Google Maps Module
 * @author Philip Locke - www.joostrap.com & www.fastnetwebdesign.co.uk 
 * @subpackage	mod_bootstrap_google_maps
 * @copyright	Copyright (C) 2011 - 2012 Joostrap.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;


$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// register the helper
JLoader::register('BoxsearchModuleHelper', __DIR__ . '/helpers/boxsearch.php');
JLoader::register('Rest_Client', 'components/com_boxsearch/helpers/boxsearch_api.php');
JLoader::register('BoxsearchModelBoxsearch', 'components/com_boxsearch/models/boxsearch.php');

$input = JFactory::getApplication()->input;

if ($input->get('delete'))
{
	$file_id = $input->getInt('file_id');
	$etag = $input->getInt('etag');
	$delete = BoxsearchModuleHelper::deleteFile($file_id, $etag);
	if (isset($delete->type))
	{   
		JFactory::getApplication()->enqueueMessage($delete->status . " " .$delete->code, 'error');
		
	}
	else
	{
		JFactory::getApplication()->enqueueMessage(JText::_('MOD_BOX_MYFILES_DELETE_SUCCESS'), 'success');
	}
}

require JModuleHelper::getLayoutPath('mod_box_myfiles', $params->get('layout', 'default'));
