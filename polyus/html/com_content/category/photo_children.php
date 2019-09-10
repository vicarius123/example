<?php
/**
* @package     Joomla.Site
* @subpackage  com_content
*
* @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$class  = ' class="first"';
$lang   = JFactory::getLanguage();
$user   = JFactory::getUser();
$groups = $user->getAuthorisedViewLevels();
?>
<div class="gallery-album">
  <div class="row">
    <?php if (count($this->children[$this->category->id]) > 0) : ?>

      <?php foreach ($this->children[$this->category->id] as $id => $child) : $pic = json_decode($child->params)->image;
      $title = explode('|', $child->title);?>

      <div class="col-sm-6">
        <a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>">
          <div class="gall-ctn">
            <div class="gall-pic">
              <img src="<?=$pic;?>">
            </div>
            <div class="gall-text">
              <h2><?=$title[0];?><br /><small><?=$title[1];?></small></h2>
            </div>
          </div>
        </a>
      </div>

    <?php endforeach; ?>

  <?php endif; ?>
</div>
</div>
