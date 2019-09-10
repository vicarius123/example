<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Polyus_users
 * @author     Cristopher Chong <cris_chong2@hotmail.com>
 * @copyright  2019 Cristopher Chong
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Polyus_users', JPATH_COMPONENT);
JLoader::register('Polyus_usersController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Polyus_users');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
