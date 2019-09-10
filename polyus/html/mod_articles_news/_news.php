<?php
/**
* @package     Joomla.Site
* @subpackage  mod_articles_news
*
* @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

$month = JText::_(date('F', strtotime($item->created)));
$day = date('d', strtotime($item->created));
$year = date('Y', strtotime($item->created));

$date = $day.' '.$month.' '.$year;

$image = json_decode($item->images)->image_intro;
?>
<div class="col-sm-12 col-md-4 col-12 margin-ctn news__list">
	<a href="<?=$item->link;?>" class="d-block each__news relative">
		<div class="news__pic">
			<img src="<?=$image;?>" alt="">
		</div>
		<div class="news__date">
			<span><?=$date;?></span>
			<p class="news__title"><?=$item->title;?></p>
		</div>
	</a>
</div>
