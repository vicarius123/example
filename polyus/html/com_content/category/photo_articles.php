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

$years = [];
foreach($items as $item){
	$years[] = date('Y', strtotime($item->created));
}
$years = array_unique($years);
rsort($years);
$lang = JFactory::getLanguage();
$tag = $lang->getTag();
?>
<h1><?=$active->title;?></h1><br />
