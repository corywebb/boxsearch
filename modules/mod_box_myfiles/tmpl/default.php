<?php
/**
 * @package		Box.com MyFiles by FolderID
 * @author          Philip Locke - www.joostrap.com & www.fastnetwebdesign.co.uk
 * @subpackage	     mod_box_myfiles
 * @copyright	     Copyright (C) 2011 - 2012 Joostrap.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

global $_CB_framework;

$user = JFactory::getUser();
$user_id = $_CB_framework->displayedUser();
$folderid = $params->get('folderid');

$box_files = BoxsearchModuleHelper::getUserUploads($user_id,$folderid);

?>

<div><!-- Box files from folderid for Joomla user ~ foreach below -->
     <?php foreach ($box_files as $file) : ?>
          <?php if (isset($file->shared_link)): ?>
               <p><a href="<?php echo $file->shared_link->url;?>" target="_blank"><?php echo $file->name?></a>
          <?php else: ?>
               <p><?php echo $file->name?></p>
          <?php endif; ?>
          <?php echo JText::sprintf('MOD_BOX_MYFILES_CREATE_DATE', JHtml::_('date', $file->created_at, JText::_('DATE_FORMAT_LC3'))); ?> <input type="checkbox" name="delete" value="delete"> <a href "#" class="btn-mini btn-primary">Delete</a></p>
     <?php endforeach; ?>
</div>
