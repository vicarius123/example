<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<form action="<?php echo JRoute::_('index.php');?>" class="search" method="post">
	<div class="search<?php echo $moduleclass_sfx ?>">
		<?php
			$output = '<input name="searchword" id="mod-search-searchword"   class="inputbox'.$moduleclass_sfx.'" type="text" value=""   />';
			if ($button) {
				if ($imagebutton) {
					if ($img) {
						$img = 'type="image" src="' . $img . '"';
					} else {
						$img = 'type="submit"';
					}
					$button = '<input class="button search-button '.$moduleclass_sfx.'" ' . $img .'/>';
				}
				else {
					$button = '<input  type="submit" class="button search-button '.$moduleclass_sfx.'" />';
				}

                switch ($button_pos) :
                    case 'top' :
                        $button = $button.'<br />';
                        $output = $button.$output;
                        break;

                    case 'bottom' :
                        $button = '<br />'.$button;
                        $output = $output.$button;
                        break;

                    case 'right' :
                        $output = $output.$button;
                        break;

                    case 'left' :
                    default :
                        $output = $button.$output;
                        break;
                endswitch;
            }
			echo $output;
		?>
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
	</div>
</form>
