<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      mod_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

defined('_JEXEC') or die;
?>

<form name="boxsearch" id="boxsearch" method="post" action="index.php?option=com_boxsearch">
     <fieldset>
          <label><?php echo JText::_('COM_BOXSEARCH_FORM_LABEL')?></label>
          <input type="text" name="query" size="15" class="input input-small" placeholder="Search Query" />   
     </fieldset>
     <input type="submit" class="btn" />
</form>