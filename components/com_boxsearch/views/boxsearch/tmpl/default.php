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
<h5><?php echo JText::_('COM_BOXSEARCH_RESULTS_LABEL'); ?></h5>
<?php foreach ($this->results->entries as $entry):?>
    <div class="item">
          <?php if(isset($entry->shared_link->download_url)): ?>
          <div class="span2">
               <?php $icon =  BoxsearchHelper::getFileIcon($entry->shared_link->download_url); ?>
               <img src="<?php echo $icon; ?>" /> 
          </div>
          <?php endif; ?>
          <div class="span8">
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
	          <p><?php echo JText::sprintf('COM_BOXSEARCH_CREATED_AT_LABEL', JHtml::_('date', $entry->created_at, JText::_('DATE_FORMAT_LC3'))); ?></p>
	          <p><?php echo JText::_('COM_BOXSEARCH_CREATED_BY_LABEL'); ?><?php echo ": ". $entry->created_by->name; ?></p>
	          <p>
	               <?php if(isset($entry->shared_link->download_url)): ?>
	                    <a href="<?php echo $entry->shared_link->download_url;?>" class="btn btn-info" >
	                         <?php echo JText::_('COM_BOXSEARCH_DOWNLOAD_LINK');?>
	                    </a>
	               <?php endif; ?>
	               <?php if(isset($entry->shared_link->url)): ?>
	                    <a href="<?php echo $entry->shared_link->url;?>" class="btn btn-success">
	                         <?php echo JText::_('COM_BOXSEARCH_VIEW_LINK');?>
	                    </a>
	               <?php endif; ?>
	          </p>
           </div>
        <div class="clearfix"></div>
        <hr />
    </div>
   
<?php endforeach; ?>
<?php endif; ?>
<div class="clearfix"></div>