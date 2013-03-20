<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

?>

<h5><?php echo JText::_('COM_BOXSEARCH_UPLOAD_LABEL');?></h5>
<form action="<?php echo JRoute::_('index.php?option=com_boxsearch'); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="upload_file">
		
		<label>Select File: </label><input type="file" name="file"> 
		<button type="submit">Upload</button>
</form>