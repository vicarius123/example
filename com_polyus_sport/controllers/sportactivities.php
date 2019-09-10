<?php
/**
* @version    CVS: 1.0.0
* @package    Com_Polyus_sport
* @author     Cristopher Chong <cris_chong2@hotmail.com>
* @copyright  2019 Cristopher Chong
* @license    GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
*/

// No direct access.
defined('_JEXEC') or die;

/**
* Sportactivities list controller class.
*
* @since  1.6
*/
class Polyus_sportControllerSportactivities extends Polyus_sportController
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
	public function &getModel($name = 'Sportactivities', $prefix = 'Polyus_sportModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
	public function addActivity(){
		$app = JFactory::getApplication();
		$get = (object)JRequest::get();
		if($get->delete_a == 1){

			$date = date('Y-m-d 00:00:00', strtotime($get->date));
			$date2 = date('Y-m-d 00:00:00', strtotime("+1 day", strtotime($date)));

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			// delete all custom keys for user.

			$fields = array(
				$db->quoteName('state') . ' = 0'
			);

			$conditions = array(
				$db->quoteName('date') . ' >= '.$db->quote($date),
				$db->quoteName('date') . ' < '.$db->quote($date2),
				$db->quoteName('type') . ' = '.$db->quote($get->type),
				$db->quoteName('email') . ' = '.$db->quote($get->email2),
			);

			$query->update($db->quoteName('#__polyus_sport_activity'))->set($fields)->where($conditions);



			$db->setQuery($query);

			$result = $db->execute();

			$db->execute();

			$app->redirect(JRoute::_('/profile'), false);

		}else{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$date = date('Y-m-d H:i:s', strtotime($get->date));

			$get->activity = str_replace(',', '.', $get->activity);

			$columns = array('state', 'date', 'type', 'activity', 'email', 'subdivision');
			$values = array(1, $db->quote($date),  $db->quote($get->type), $db->quote($get->activity), $db->quote($get->email2), $db->quote($get->subdivision));
			$query
			->insert($db->quoteName('#__polyus_sport_activity'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));
			$db->setQuery($query);
			$db->execute();

			$app->redirect(JRoute::_('/profile'), false);
		}
		die(print_r($get));

	}
}
