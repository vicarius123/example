<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Polyus_users
 * @author     Cristopher Chong <cris_chong2@hotmail.com>
 * @copyright  2019 Cristopher Chong
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Logins list controller class.
 *
 * @since  1.6
 */
class Polyus_usersControllerLogins extends Polyus_usersController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Logins', $prefix = 'Polyus_usersModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}
