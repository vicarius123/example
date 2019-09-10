<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Polyus_sport
 * @author     Cristopher Chong <cris_chong2@hotmail.com>
 * @copyright  2019 Cristopher Chong
 * @license    GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 *
 * @since  1.6
 */
class JFormFieldFileMultiple extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var        string
	 * @since    1.6
	 */
	protected $type = 'file';

	/**
	 * Method to get the field input markup.
	 *
	 * @return    string    The field input markup.
	 *
	 * @since    1.6
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = '<input type="file" name="' . $this->name . '[]" multiple >';

		return $html;
	}
}
