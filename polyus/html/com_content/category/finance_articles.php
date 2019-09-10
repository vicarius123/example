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

$items = $this->items;
$model = $this->getModel();
//Getting years//
$years = [];
foreach($items as $item){
	$years[] = date('Y', strtotime($item->created));
}
$years = array_unique($years);
rsort($years);

$active = JFactory::getApplication()->getMenu()->getActive();
$menuname = $active->params->get('page_heading');
?>

<h1><?=$active->title;?></h1><br />
<? if($this->category->description):?>

<?=$this->category->description;?>

<? endif;?>
<ul class="nav nav-pills new-pills" id="pills-tab" role="tablist">
	<? foreach($years as $k=>$year):?>
	<li class="nav-item">
		<a class="nav-link <?=($k==0)?'active':'';?>" data-toggle="pill" href="#pills-<?=$k;?>" role="tab" aria-selected="true"><?=$year;?></a>
	</li>

<? endforeach;?>
</ul>
<div class="tab-content" id="pills-tabContent">
	<? foreach($years as $k=>$year):?>
	<div class="tab-pane fade <?=($k==0)?'show active':'';?>" id="pills-<?=$k;?>" role="tabpanel">
		<div class="finance-list">
			<?foreach($items as $item): $image = json_decode($item->images)->image_intro; $date = date('d', strtotime($item->created)).' '.JText::_(date('F', strtotime($item->created))).' '.date('Y', strtotime($item->created));?>
			<?if(date('Y', strtotime($item->created)) == $year):?>
			<div class="row align-items-center">
				<div class="col-sm-8">
					<div>
						<?if($item->catid == 9) :?>
						<span class="date-finance"><?=$date;?></span>
						<?endif;?>
						<a class="pdf_file" href="<?=$item->jcfields[1]->rawvalue;?>" target="_blank"><h2><?=$item->title;?></h2></a>
					</div>
				</div>
				<div class="col-sm-4">
					<div>
						<a class="pdf_file" href="<?=$item->jcfields[1]->rawvalue;?>" target="_blank">
							<img src="/images/pdf-icn.svg" alt="PDF" />
							<span><?=$model->FileSizeConvert(filesize($item->jcfields[1]->rawvalue));?></span>
						</a>
					</div>
				</div>
			</div>

			<?endif;?>


			<?endforeach;?>
		</div>

	</div>
<? endforeach;?>
</div>
