<?php
/**
* @version    CVS: 1.0.0
* @package    Com_Polyus_users
* @author     Cristopher Chong <cris_chong2@hotmail.com>
* @copyright  2019 Cristopher Chong
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
jimport('joomla.application.component.modellist');
/**
* Methods supporting a list of Polyus_users records.
*
* @since  1.6
*/
class Polyus_usersModelStatistics extends JModelList
{
	/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
			);
		}
		parent::__construct($config);
	}
	/**
	* Method to auto-populate the model state.
	*
	* Note. Calling getState in this method will result in recursion.
	*
	* @param   string  $ordering   Elements order
	* @param   string  $direction  Order direction
	*
	* @return void
	*
	* @throws Exception
	*
	* @since    1.6
	*/
	protected function populateState($ordering = null, $direction = null)
	{
		$app  = Factory::getApplication();
		$list = $app->getUserState($this->context . '.list');
		$ordering  = isset($list['filter_order'])     ? $list['filter_order']     : null;
		$direction = isset($list['filter_order_Dir']) ? $list['filter_order_Dir'] : null;
		$list['limit']     = (int) Factory::getConfig()->get('list_limit', 20);
		$list['start']     = $app->input->getInt('start', 0);
		$list['ordering']  = $ordering;
		$list['direction'] = $direction;
		$app->setUserState($this->context . '.list', $list);
		$app->input->set('list', null);
		// List state information.
		parent::populateState('a.ordering', 'asc');
		$context = $this->getUserStateFromRequest($this->context . '.context', 'context', 'com_content.article', 'CMD');
		$this->setState('filter.context', $context);
		// Split context into component and optional section
		$parts = FieldsHelper::extract($context);
		if ($parts)
		{
			$this->setState('filter.component', $parts[0]);
			$this->setState('filter.section', $parts[1]);
		}
	}
	/**
	* Build an SQL query to load the list data.
	*
	* @return   JDatabaseQuery
	*
	* @since    1.6
	*/
	protected function getListQuery()
	{
		$db	= $this->getDbo();
		$query	= $db->getQuery(true);
		return $query;
	}
	/**
	* Method to get an array of data items
	*
	* @return  mixed An array of data on success, false on failure.
	*/
	public function getItems()
	{
		$items = parent::getItems();
		foreach ($items as $item)
		{
			$item->subdivision = JText::_('COM_POLYUS_USERS_USERS_SUBDIVISION_OPTION_' . strtoupper($item->subdivision));
		}
		return $items;
	}
	/**
	* Overrides the default function to check Date fields format, identified by
	* "_dateformat" suffix, and erases the field if it's not correct.
	*
	* @return void
	*/
	protected function loadFormData()
	{
		$app              = Factory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;
		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && $this->isValidDate($value) == null)
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}
		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_POLYUS_USERS_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}
		return parent::loadFormData();
	}
	/**
	* Checks if a given date is valid and in a specified format (YYYY-MM-DD)
	*
	* @param   string  $date  Date to be checked
	*
	* @return bool
	*/
	private function isValidDate($date)
	{
		$date = str_replace('/', '-', $date);
		return (date_create($date)) ? Factory::getDate($date)->format("Y-m-d") : null;
	}
	public function getGlobalActivity(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__polyus_sport_activity'));
		$query->where($db->quoteName('state') . ' = 1');
		$query->order('date DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		$run = 0;
		$swim = 0;
		$bike = 0;
		$walk = 0;
		$ski = 0;
		$activities = [];
		foreach($results as $activity){
			if($activity->type == 'Бег'){
				$run+=round($activity->activity, 1);
			}
			if($activity->type == 'Плавание'){
				$swim+=round($activity->activity*3, 1);
			}
			if($activity->type == 'Велосипед'){
				$bike+=round($activity->activity*0.5, 1);
			}
			if($activity->type == 'Ходьба'){
				$walk+=round($activity->activity, 1);
			}
			if($activity->type == 'Лыжи'){
				$ski+=round($activity->activity*0.5, 1);
			}
		}
		$activities['run'] = $run;
		$activities['swim'] = $swim;
		$activities['bike'] = $bike;
		$activities['walk'] = $walk;
		$activities['ski'] = $ski;
		$activities = json_encode($activities);
		return $activities;
	}
	public function getGlobalActivity2(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__polyus_sport_activity'));
		$query->where($db->quoteName('state') . ' = 1');
		$query->order('date DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();
		$activities = [];
		$s1 = 0;
		$s2 = 0;
		$s3 = 0;
		$s4 = 0;
		$s5 = 0;
		$s6 = 0;
		$s7 = 0;
		$s8 = 0;
		$s9 = 0;
		$s10 = 0;
		$s11 = 0;
		foreach($results as $activity){
			if($activity->subdivision == '1'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s1+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s1+=round($activity->activity*3, 1);
				}else{
					$s1+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '2'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s2+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s2+=round($activity->activity*3, 1);
				}else{
					$s2+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '3'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s3+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s3+=round($activity->activity*3, 1);
				}else{
					$s3+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '4'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s4+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s4+=round($activity->activity*3, 1);
				}else{
					$s4+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '5'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s5+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s5+=round($activity->activity*3, 1);
				}else{
					$s5+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '6'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s6+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s6+=round($activity->activity*3, 1);
				}else{
					$s6+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '7'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s7+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s7+=round($activity->activity*3, 1);
				}else{
					$s7+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '8'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s8+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s8+=round($activity->activity*3, 1);
				}else{
					$s8+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '9'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s9+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s9+=round($activity->activity*3, 1);
				}else{
					$s9+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '10'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s10+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s10+=round($activity->activity*3, 1);
				}
				else{
					$s10+=round($activity->activity, 1);
				}
			}
			if($activity->subdivision == '11'){
				if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
					$s11+=round($activity->activity*0.5, 1);
				}elseif($activity->type == 'Плавание'){
					$s11+=round($activity->activity*3, 1);
				}
				else{
					$s11+=round($activity->activity, 1);
				}
			}
		}
		$activities['s1'] = $s1;
		$activities['s2'] = $s2;
		$activities['s3'] = $s3;
		$activities['s4'] = $s4;
		$activities['s5'] = $s5;
		$activities['s6'] = $s6;
		$activities['s7'] = $s7;
		$activities['s8'] = $s8;
		$activities['s9'] = $s9;
		$activities['s10'] = $s10;
		$activities['s11'] = $s11;
		$activities = json_encode($activities);
		return $activities;
	}
	public function getUserName($email){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__polyus_users'));
		$query->where($db->quoteName('email') . ' = '. $db->quote($email));
		$db->setQuery($query);
		$results = $db->loadObject();
		return $results;
	}
	public function getGlobalActivity3(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__polyus_sport_activity'));
		$query->where($db->quoteName('state') . ' = 1');
		$query->order('date DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();
		$users = [];
		$table = [];
		$type = [];
		foreach($results as $activity){
			$users[] = $activity->email;
		}
		$users = array_values(array_unique($users));
		$run = 0;
		$n = 0;
		$i = 0;
		foreach($users as $user){
			$n++;
			$i++;

			foreach($results as $activity){
				if($user == $activity->email){
					$userName = Polyus_usersModelStatistics::getUserName($activity->email);
					$table[$n]['count'] = $i;
					$table[$n]['user'] = $userName->name.' '.$userName->lastname;
					$table[$n]['pic'] = $userName->pic;
					$table[$n]['email'] = $activity->email;
					$table[$n]['be'] = $userName->subdivision;
					if( $activity->type == 'Бег'){
						$table[$n]['Бег']+= round($activity->activity, 1);
					}else{
						$table[$n]['Бег']+= 0;
					}
					if( $activity->type == 'Велосипед'){
						$table[$n]['Велосипед']+= round($activity->activity, 1);
					}else{
						$table[$n]['Велосипед']+= 0;
					}
					if( $activity->type == 'Плавание'){
						$table[$n]['Плавание']+= round($activity->activity, 1);
					}else{
						$table[$n]['Плавание']+= 0;
					}
					if( $activity->type == 'Ходьба'){
						$table[$n]['Ходьба']+= round($activity->activity, 1);
					}else{
						$table[$n]['Ходьба']+= 0;
					}
					if( $activity->type == 'Лыжи'){
						$table[$n]['Лыжи']+= round($activity->activity, 1);
					}else{
						$table[$n]['Лыжи']+= 0;
					}
					if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
						$table[$n]['total']+= round($activity->activity*0.5, 1);
					}elseif($activity->type == 'Плавание'){
						$table[$n]['total']+= round($activity->activity*3, 1);
					}
					else{
						$table[$n]['total']+= round($activity->activity, 1);
					}

				}
			}
		}
		$table = json_encode(array_values($table));
		return $table;
	}
	public function getGlobalActivity4(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__polyus_sport_activity'));
		$query->where('date >= CURDATE() - INTERVAL 7 DAY AND date < CURDATE()');
		$query->where($db->quoteName('state') . ' = 1');
		$query->order('date DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();
		$users = [];
		$table = [];
		$type = [];
		foreach($results as $activity){
			$users[] = $activity->email;
		}
		$users = array_values(array_unique($users));
		$run = 0;
		$n = 0;
		$i = 0;
		foreach($users as $user){
			$n++;
			$i++;
			foreach($results as $activity){
				if($user == $activity->email){
					$userName = Polyus_usersModelStatistics::getUserName($activity->email);
					$table[$n]['count'] = $i;
					$table[$n]['user'] = $userName->name.' '.$userName->lastname;
					$table[$n]['pic'] = $userName->pic;
					$table[$n]['email'] = $activity->email;
					$table[$n]['be'] = $userName->subdivision;
					if( $activity->type == 'Бег'){
						$table[$n]['Бег']+= round($activity->activity, 1);
					}else{
						$table[$n]['Бег']+= 0;
					}
					if( $activity->type == 'Велосипед'){
						$table[$n]['Велосипед']+= round($activity->activity, 1);
					}else{
						$table[$n]['Велосипед']+= 0;
					}
					if( $activity->type == 'Плавание'){
						$table[$n]['Плавание']+= round($activity->activity, 1);
					}else{
						$table[$n]['Плавание']+= 0;
					}
					if( $activity->type == 'Ходьба'){
						$table[$n]['Ходьба']+= round($activity->activity, 1);
					}else{
						$table[$n]['Ходьба']+= 0;
					}
					if( $activity->type == 'Лыжи'){
						$table[$n]['Лыжи']+= round($activity->activity, 1);
					}else{
						$table[$n]['Лыжи']+= 0;
					}
					if($activity->type == 'Лыжи' || $activity->type == 'Велосипед'){
						$table[$n]['total']+= round($activity->activity*0.5, 1);
					}elseif($activity->type == 'Плавание'){
						$table[$n]['total']+= round($activity->activity*3, 1);
					}else{
						$table[$n]['total']+= round($activity->activity, 1);
					}
				}
			}
		}
		$table = json_encode(array_values($table));
		return $table;
	}
}
