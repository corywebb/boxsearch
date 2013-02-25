<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

defined('_JEXEC') or die;

class BoxsearchHelper
{
     /**
      * Configure the Linkbar.
      *
      * @param   string  The name of the active view.
      *
      * @return  void
      * @since   1.6
      */
     public static function addSubmenu($vName)
     {
         JHtmlSidebar::addEntry(
                    JText::_('COM_ROOTFLICK_SUBMENU_CP'),
                    'index.php?option=com_boxsearch',
                    $vName == 'boxsearch'
         );
     }
}
