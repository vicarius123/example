<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Polyus_users
 * @author     Cristopher Chong <cris_chong2@hotmail.com>
 * @copyright  2019 Cristopher Chong
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Class Polyus_usersController
 *
 * @since  1.6
 */
class Polyus_usersController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean $cachable  If true, the view output will be cached
	 * @param   mixed   $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController   This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
        $app  = JFactory::getApplication();
        $view = $app->input->getCmd('view', 'users');
		$app->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
