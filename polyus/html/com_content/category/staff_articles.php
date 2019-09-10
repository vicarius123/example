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

?>
<div class="staff-list header-separation">
	<?foreach($items as $item): $image = json_decode($item->images)->image_intro; $title = explode(' ', $item->title);?>
	<div class="row staff-each">
		<div class="col-sm-4">
			<img src="<?=$image;?>" class="img-staff"/>
		</div>
		<div class="col-sm-8">
			<h2 class="uppercase"><?foreach($title as $k=>$ttl):
				if($k == 0):
					echo $title[0].'<br />';
				else:
					echo $ttl.' ';
				endif;
			endforeach;?></h2>
			<p><?=$item->text;?></p>
		</div>
	</div>

	<?endforeach;?>
</div>
