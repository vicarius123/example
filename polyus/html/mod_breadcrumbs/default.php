<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<div class="breadcrumbs<?php echo $moduleclass_sfx; ?>">
<?php if ($params->get('showHere', 1))
	{
		echo '<span class="showHere">' .JText::_('MOD_BREADCRUMBS_HERE').'</span>';
	}
?>
<?php for ($i = 0; $i < $count; $i ++) :
	// Workaround for duplicate Home when using multilanguage

	// If not the last item in the breadcrumbs add the separator


	if ($i < $count)
	{
		if (!empty($list[$i]->link)) {
			echo '<a href="'.$list[$i]->link.'" class="pathway">'.$list[$i]->name.'</a>';
		} else {
			$chars = strlen($list[$i]->name);
			if($chars <= 50){
				echo '<span>';
				echo $list[$i]->name;
				echo '</span>';

			}else{

			}

		}
		if ($i < $count - 1)
		{
			echo ' <span class="bread-sep">'.$separator.'</span> ';
		}
	}  elseif ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
		if ($i > 0)
		{
			echo ' '.$separator.' ';
		}
		echo '<span>';
		echo $list[$i]->name;
		echo '</span>';
	}
endfor; ?>
</div>
