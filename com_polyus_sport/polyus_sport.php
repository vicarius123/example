<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Polyus_sport
 * @author     Cristopher Chong <cris_chong2@hotmail.com>
 * @copyright  2019 Cristopher Chong
 * @license    GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Polyus_sport', JPATH_COMPONENT);
JLoader::register('Polyus_sportController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Polyus_sport');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
