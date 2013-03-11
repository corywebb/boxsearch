<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

defined('_JEXEC') or die;

?>

<form action="<?php echo JRoute::_('index.php?option=com_boxsearch'); ?>" method="post" name="adminForm" id="adminForm">
     <div id="j-sidebar-container" class="span3">
          <?php // echo $this->sidebar; ?>
     </div>
     <div id="j-main-container" class="span9">
          <p>This extension must be configured before use. You must create a new app on box.com, create an API key, and client id, and client secret.</p>
          <table class="table table-striped">
               <tr>
                    <th><?php echo JText::_('COM_BOXSEARCH_KEY_NAME_LABEL'); ?></th>
                    <th><?php echo JText::_('COM_BOXSEARCH_KEY_VALUE_LABEL'); ?></th>
               </tr>
               <tr>
                    <td><?php echo JText::_('COM_BOXSEARCH_API_KEY_LABEL'); ?></td>
                    <td>
                         <?php if($this->api_key != ''): ?>
                              <span class="label label-success"><?php echo $this->api_key; ?></span>
                          <?php else: ?>
                              <span class="label label-warning"><?php echo JText::_('COM_BOXSEARCH_ERROR_KEY_NOT_SET')?></span>
                          <?php endif; ?>
                    </td>
               </tr>
               <tr>
                    <td><?php echo JText::_('COM_BOXSEARCH_CLIENT_ID_LABEL'); ?></td>
                    <td>
                         <?php if($this->client_id != ''): ?>
                              <span class="label label-success"><?php echo $this->client_id; ?></span>
                          <?php else: ?>
                              <span class="label label-warning"><?php echo JText::_('COM_BOXSEARCH_ERROR_KEY_NOT_SET')?></span>
                          <?php endif; ?>
                    </td>
               </tr>
               <tr>
                    <td><?php echo JText::_('COM_BOXSEARCH_AUTH_SECRET_LABEL'); ?></td>
                    <td>
                         <?php if($this->client_secret != ''): ?>
                              <span class="label label-success"><?php echo $this->client_secret; ?></span>
                          <?php else: ?>
                              <span class="label label-warning"><?php echo JText::_('COM_BOXSEARCH_ERROR_KEY_NOT_SET')?></span>
                          <?php endif; ?>
                    </td>
               </tr>
          </table>
          <?php  ?>
     </div>
</form>