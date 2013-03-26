<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 * 
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

 // get app
 $app = JFactory::getApplication();
 $menu = $app->getMenu()->getActive();
 $menuParams   = new JRegistry;
 $menuParams->loadString($menu->params);
 $params = JComponentHelper::getParams('com_boxsearch');
?>

<div class="span9">
	<?php if ($menuParams->get('enable_search')): ?>
		<p>Use the search box  below to search the box account.</p>
		<form name="boxsearch" id="boxsearch" method="post">
          <fieldset>
               <label><?php echo JText::_('COM_BOXSEARCH_FORM_LABEL')?></label>
               <input type="text" name="query" size="20" class="input" placeholder="Search Query" />
               <?php if ($this->subfolders): ?>
                   <select name="subfolders">
                       <?php foreach($this->subfolders as $folder): ?>
                           <option value="<?php echo $folder->id; ?>"><?php echo $folder->name; ?></option>
                       <?php endforeach; ?>
                   </select>
               <?php endif; ?>
          </fieldset>
          <input type="submit" class="btn" />
     </form>
     <?php endif; ?>
     <?php if ($menuParams->get('enable_upload')): ?>
     	<?php echo $this->loadTemplate('upload'); ?>
     <?php endif; ?>
</div>
<div class="clearfix"></div>
<?php if (isset($this->results->entries)): ?>
<h5>
	<?php echo JText::_('COM_BOXSEARCH_RESULTS_LABEL'); ?>
	<?php if($app->input->get('filter_label')): ?>
		<?php echo JText::_('COM_BOXSEARCH_FILTER_LABEL'); ?><?php echo $app->input->get('filter_label'); ?>
	<?php endif; ?>
</h5>
<?php foreach ($this->results->entries as $entry):?>
    <div class="boxsearch-item">
          <?php if(isset($entry->shared_link->download_url)): ?>
          <div class="span1">
               <?php $icon =  BoxsearchHelper::getFileIcon($entry->shared_link->download_url); ?>
               <img src="<?php echo $icon; ?>" /> 
          </div>
          <?php endif; ?>
          <div class="span11">
	          <h4>
	               <?php if(isset($entry->shared_link->download_url)):?>
	                    <a target="blank" href="<?php echo $entry->shared_link->download_url; ?>" target="_blank"><?php echo $entry->name; ?></a>
	               <?php else: ?>
	                    <?php echo $entry->name; ?>
	               <?php endif; ?>
	          </h4>
	         
	          <ul class="boxsearch">
                    <li><?php echo JText::sprintf('COM_BOXSEARCH_CREATED_AT_LABEL', JHtml::_('date', $entry->created_at, JText::_('DATE_FORMAT_LC3'))); ?></li>
                    <li><?php echo JText::sprintf('COM_BOXSEARCH_MODIFIED_AT_LABEL', JHtml::_('date', $entry->modified_at, JText::_('DATE_FORMAT_LC3'))); ?></li>
                    <li><?php echo JText::_('COM_BOXSEARCH_CREATED_BY_LABEL'); ?><?php echo $entry->created_by->name; ?></li>
               </ul>
               <br />
               <ul class="boxsearch">
                    <?php if(isset($entry->shared_link->download_url)): ?>
                         <li>
                              <a target="blank" href="<?php echo $entry->shared_link->download_url;?>">
                                   <?php echo JText::_('COM_BOXSEARCH_DOWNLOAD_LINK');?>
                              </a>
                         </li>
                    <?php endif; ?>
                    <?php if(isset($entry->shared_link->url)): ?>
                         <li>
                              <a target="blank" href="<?php echo $entry->shared_link->url;?>">
                                   <?php echo JText::_('COM_BOXSEARCH_VIEW_LINK');?>
                              </a>
                         </li>
                    <?php endif; ?>
                    <li><?php echo BoxsearchHelper::formatBytes($entry->size); ?></li>
                    <li><?php echo JText::_('COM_BOXSEARCH_LOCATED_IN') .  $entry->parent->name; ?></li>
                    
               </ul>
               <?php if ($params->get('debug')): ?>
               		<pre><?php print_r($entry); ?></pre>
               <?php endif; ?>
               <?php if ($entry->description): ?>
                    <small>
                         <?php echo $entry->description; ?>
                    </small>
               <?php endif; ?>
           </div>
        <div class="clearfix"></div>
        <hr />
    </div>
   
<?php endforeach; ?>
<?php endif; ?>
<div class="clearfix"></div>