<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

defined('_JEXEC') or die;

/**
 * Category table
 *
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 * @since       1.6
 */
class BoxsearchUploadsKeys extends JTable
{    
     /**
      * Constructor
      *
      * @since 1.5
      */
     public function __construct(&$db)
     {    
          parent::__construct('#__boxsearch_uploads', 'id', $db);
     }
}
