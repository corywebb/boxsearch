<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */
 $app = JFactory::getApplication();
 $menu = $app->getMenu()->getActive();
 $menuParams   = new JRegistry;
 $menuParams->loadString($menu->params);
?>

<h5><?php echo JText::_('COM_BOXSEARCH_UPLOAD_LABEL');?></h5>
<form action="<?php echo JRoute::_('index.php?option=com_boxsearch'); ?>" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="action" value="upload_file">
		
		<label for="file">
		   <?php echo JText::_('COM_BOXSEARCH_SELECT_FILE_LABEL'); ?>
		</label>
		<input type="file" name="file" class="upload-choice">
		   <?php if ($this->subfolders): ?>
                   <label for="subfolders">
                         <?php echo JText::_('COM_BOXSEARCH_UPLOAD_FOLDER_LABEL'); ?>
                   </label>
                   <select name="subfolders">
                       <option value="<?php echo $menuParams->get('filter_id'); ?>">
                         <?php echo $menuParams->get('filter_label'); ?>
                       </option>
                       <?php foreach($this->subfolders as $folder): ?>
                           <option value="<?php echo $folder->id; ?>"><?php echo "-" . $folder->name; ?></option>
                       <?php endforeach; ?>
                   </select>
               <?php else: ?>
                   <input name="subfolders" type="hidden" value="<?php echo $menuParams->get('filter_id'); ?>" />
               <?php endif;?>
		<button type="submit" class="btn btn-primary">Upload</button>
</form>