<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$items = $list;
?>
<? foreach($items as $k=>$item):
	if($k == 0): $images = json_decode($item->images)->image_intro;?>
	<div class="main-new">
		<div class="wrapper">
			<div class="row main-new-ctn">
				<div class="col-sm-6">
					<? if (!empty($images)):?>

						<div class="row inner-main-new" style="background:url('<?=$images;?>')no-repeat top right;background-size: contain;">
							<div class="col-8">
								<p class="main-new-date">
									<?=date('d.m.y', strtotime($item->created));?>
								</p>
								<h2 class="news-title"><?=$item->title;?></h2>
								<p class="news-intro">
									<?=$item->introtext;?>
								</p>
								<a href="<?=$item->link;?>" class="read-more">Подробнее</a>
							</div>

						</div>

					<? else: ?>
					<div class='inner-main-new'>
						<p class="main-new-date">
							<?=date('d.m.y', strtotime($item->created));?>
						</p>
						<h2 class="news-title"><?=$item->title;?></h2>
						<p class="news-intro">
							<?=$item->introtext;?>
						</p>
						<a href="<?=$item->link;?>" class="read-more">Подробнее</a>
					</div>

					<? endif;?>
				</div>
				<div class="col-sm-6 arrow-left news-right-txt">
					<div>
						<span>|</span> <p class="nomargin">НОВОСТИ</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<? endif;

 endforeach;?>

<div class="news-ctn">
	<div class="wrapper">
		<div class="row">
			<? foreach($items as $k=>$item):
				if($k != 0):?>
				<div class="col-sm-4">
					<h3 class="news-title"><?=$item->title;?></h3>
					<p class="news-desc">
						<?=$item->introtext;?>
					</p>
					<div class="row align-center">
						<div class="col-6">
							<p class="news-date nomargin">
								<?=date('d.m.y', strtotime($item->created));?>
							</p>
						</div>
						<div class="col-6 text-right">
							<a href="<?=$item->link;?>" class="read-more">Подробнее</a>
						</div>
					</div>
				</div>

		 <? endif;
		 endforeach;?>
		</div>
	</div>
</div>
