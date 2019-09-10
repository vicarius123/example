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
$n         = 0;
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$items = $this->items;
$nn = 0;
?>

<? foreach($items as $item): $n++;
$img1 = json_decode($item->images)->image_intro;
$data = $item->created;
  if($n == 1):?>
    <div class="first-new big-screen relative" style="background:url('<?=$img1;?>')  top center no-repeat;" >
      <div class="wrapper">
        <div class="big-news-txt white">
          <div class="date-news-big">
            <p>
              <?=date('d', strtotime($data)).' '.JText::_(date('F', strtotime($data))).' '.date('Y', strtotime($data));?>
            </p>
          </div>
          <h1 class="h1-new h1-news nomargin white"><?=$item->title;?></h1>
          <p>
            <?=$item->introtext;?>
          </p>
        </div>
      </div>
      <div class="bg-blur"></div>
    </div>
<?  endif;
endforeach;?>

<div class="wrapper">
  <div class="row news-list">
    <? foreach($items as $item): $nn++;
    $img1 = json_decode($item->images)->image_intro;
    $data = $item->created;
      if($nn != 1):?>
        <div class="col-sm-6 each-news-list">
          <div class="news-pic-list">
            <img src="<?=$img1;?>" width="100%"/>
          </div>
          <div class="news-txt-list">
            <p class="news-date-list nomargin">
              <?=date('d', strtotime($data)).' '.JText::_(date('F', strtotime($data))).' '.date('Y', strtotime($data));?>
            </p>
            <h2 class="news-title-list nomargin">
              <?=$item->title;?>
            </h2>
            <p class="news-desc-list nomargin">
              <?=$item->introtext;?>
            </p>
          </div>
        </div>
    <?  endif;
    endforeach;?>
  </div>

  <div class="text-center">
    <button class="show-more-news">Еще новости</button>
  </div>
</div>
