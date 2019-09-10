<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Create some shortcuts.
$params    = &$this->item->params;
$n         = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$items = $this->items;
$model = $this->getModel();

$active = JFactory::getApplication()->getMenu()->getActive();
$menuname = $active->params->get('page_heading');

$lang = JFactory::getLanguage();
$tag = $lang->getTag();
?>

<div class="item-page-text <?=($this->pageclass_sfx !='reserve')? 'header-separation':'reserve-separation';?> <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
	<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
	<?foreach($items as $item):?>
	<h1><?=$item->title;?></h1>

  <?=$item->text;?>

	<?endforeach;?>
</div>
