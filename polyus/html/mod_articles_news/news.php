<?php
/**
* @package     Joomla.Site
* @subpackage  mod_articles_news
*
* @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;
$lang = JFactory::getLanguage();
$tag = $lang->getTag();
$i = 0;
$count = count($list);

?>
<div class="news__ctn wrapper">

	<h2 class="h2Title">Новости</h2>
	<div class="row">
		<? foreach($list as $k=>$item):?>
		<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_news'); ?>
	<? endforeach;?>
</div>
<? if($count > 3):?>
<div class="text-center">
	<button type="button" class="btn-new btn__inv more__news">все новости</button>
</div>
<? endif;?>
</div>
