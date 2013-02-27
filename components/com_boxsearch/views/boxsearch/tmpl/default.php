<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */
?>

<div class="span9">
     <p>Use the search box  below to search the box account.</p>
     <form name="boxsearch" id="boxsearch" method="post">
          <fieldset>
               <label><?php echo JText::_('COM_BOXSEARCH_FORM_LABEL')?></label>
               <input type="text" name="query" size="20" class="input" placeholder="Search Query" /> 
               
          </fieldset>
          <input type="submit" class="btn" />
     </form>
</div>
<div class="clearfix"></div>
<?php if (isset($this->results->entries)): ?>
<?php foreach ($this->results->entries as $entry):?>
    <div class="item">
          <h4>
               <?php if(isset($entry->shared_link->download_url)):?>
                    <a href="<?php echo $entry->shared_link->download_url; ?>"><?php echo $entry->name; ?></a>
               <?php else: ?>
                    <?php echo $entry->name; ?>
               <?php endif; ?>
          </h4>
          <?php if ($entry->description): ?>
               <small>
                    <?php echo $entry->description; ?>
               </small>
          <?php endif; ?>
          <p><?php echo JText::_('COM_BOXSEARCH_CREATED_AT_LABEL'); ?><?php echo ": ". $entry->created_at; ?></p>
          <p><?php echo JText::_('COM_BOXSEARCH_CREATED_BY_LABEL'); ?><?php echo ": ". $entry->created_by->name; ?></p>
          <p>
               <?php if(isset($entry->shared_link->download_url)): ?>
                    <a href="<?php echo $entry->shared_link->download_url;?>">
                         <?php echo JText::_('COM_BOXSEARCH_DOWNLOAD_LINK');?>
                    </a>
               <?php endif; ?>
               <?php if(isset($entry->shared_link->url)): ?>
                    <a href="<?php echo $entry->shared_link->url;?>">
                         <?php echo JText::_('COM_BOXSEARCH_VIEW_LINK');?>
                    </a>
               <?php endif; ?>
          </p>
    </div>
    <hr />
<?php endforeach; ?>
<?php endif; ?>
<div class="clearfix"></div>