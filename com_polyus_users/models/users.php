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
class Polyus_usersModelUsers extends JModelList
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
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'modified_by', 'a.modified_by',
				'name', 'a.name',
				'lastname', 'a.lastname',
				'email', 'a.email',
				'phone', 'a.phone',
				'company', 'a.company',
				'subdivision', 'a.subdivision',
				'pic', 'a.pic',
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
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
				)
			);
			$query->from('`#__polyus_users` AS a');
			// Join over the users for the checked out user.
			$query->select('uc.name AS uEditor');
			$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
			// Join over the created by field 'created_by'
			$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
			// Join over the created by field 'modified_by'
			$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
			if (!Factory::getUser()->authorise('core.edit', 'com_polyus_users'))
			{
				$query->where('a.state = 1');
			}
			// Filter by search in title
			$search = $this->getState('filter.search');
			if (!empty($search))
			{
				if (stripos($search, 'id:') === 0)
				{
					$query->where('a.id = ' . (int) substr($search, 3));
				}
				else
				{
					$search = $db->Quote('%' . $db->escape($search, true) . '%');
					$query->where('( a.name LIKE ' . $search . '  OR  a.lastname LIKE ' . $search . '  OR  a.email LIKE ' . $search . ' )');
				}
			}
			// Add the list ordering clause.
			$orderCol  = $this->state->get('list.ordering', 'id');
			$orderDirn = $this->state->get('list.direction', 'ASC');
			if ($orderCol && $orderDirn)
			{
				$query->order($db->escape($orderCol . ' ' . $orderDirn));
			}
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
		public function base64_to_pic($base64_string, $output_file) {
			$ifp = fopen($output_file, "wb");
			$data = explode(',', $base64_string);
			fwrite($ifp, base64_decode($data[1]));
			fclose($ifp);
			return $output_file;
		}
		public function checkPass($id, $old){
			$t_hasher = new PasswordHash(10, TRUE);
			$correct = $old;
			$user = JFactory::getUser($id);
			$hash = $user->password;
			$v = $t_hasher->CheckPassword($correct, $hash, $user->id);
			return $v;
		}
		public function updatePass($id, $pass){
			$userObj = JFactory::getUser($id);
			$password = array('password' => $pass, 'password2' => $pass);
			$userObj->bind($password);
			$userObj->save();
			return $userObj;
		}
		public function updatePhone($email, $phone){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('phone') . ' = ' . $db->quote($phone),
			);
			$conditions = array(
				$db->quoteName('email') . ' = ' . $db->quote($email)
			);
			$query->update($db->quoteName('#__polyus_users'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();
			$result = $db->execute();
			return $result;
		}
		public function updateEmail($email, $currentmail){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('username') . ' = ' . $db->quote($email),
				$db->quoteName('email') . ' = ' . $db->quote($email),
			);
			$conditions = array(
				$db->quoteName('email') . ' = ' . $db->quote($currentmail)
			);
			$query->update($db->quoteName('#__users'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();
			//change in avatars//
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('email') . ' = ' . $db->quote($email),
			);
			$conditions = array(
				$db->quoteName('email') . ' = ' . $db->quote($currentmail)
			);
			$query->update($db->quoteName('#__polyus_users'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();
			//change email activities//
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('email') . ' = ' . $db->quote($email),
			);
			$conditions = array(
				$db->quoteName('email') . ' = ' . $db->quote($currentmail)
			);
			$query->update($db->quoteName('#__polyus_sport_activity'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$result = $db->execute();
			return $result;
		}
		public function updateBe($email, $be){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('subdivision') . ' = ' . $db->quote($be),
			);
			$conditions = array(
				$db->quoteName('email') . ' = ' . $db->quote($email)
			);
			$query->update($db->quoteName('#__polyus_users'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->execute();

			$subdivision;

			if($be == 'Лензолото'){
				$subdivision = 1;
			}
			if($be == 'МФЦ Полюс'){
				$subdivision = 2;
			}
			if($be == 'Полюс Вернинское'){
				$subdivision = 3;
			}
			if($be == 'Полюс Красноярск'){
				$subdivision = 4;
			}
			if($be == 'Полюс Логистика'){
				$subdivision = 5;
			}
			if($be == 'Полюс Магадан'){
				$subdivision = 6;
			}
			if($be == 'Полюс Проект'){
				$subdivision = 7;
			}
			if($be == 'Полюс Строй'){
				$subdivision = 8;
			}
			if($be == 'УК Полюс'){
				$subdivision = 9;
			}

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('subdivision') . ' = 1',
			);
			$conditions = array(
				$db->quoteName('email') . ' = ' . $db->quote($email)
			);
			$query->update($db->quoteName('#__polyus_sport_activity'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$result = $db->execute();

			die($query);

			return $result;
		}
		public function changePic($path, $email){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('pic') . ' = ' . $db->quote($path),
			);
			$conditions = array(
				$db->quoteName('email') . ' = ' . $db->quote($email)
			);
			$query->update($db->quoteName('#__polyus_users'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$result = $db->execute();
			return $result;
		}
		public function getActivity($email){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__polyus_sport_activity'));
			$query->where($db->quoteName('email') . ' = '. $db->quote($email));
			$query->order('date DESC');
			$db->setQuery($query);
			$results = $db->loadAssocList();
			return $results;
		}
		public function getAllActivity(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__polyus_sport_activity'));
			$query->order('date DESC');
			$db->setQuery($query);
			$results = $db->loadAssocList();
			$total = 0;
			foreach($results as $result){
				$total+= (int)$result['activity'];
			}
			return $total;
		}
		public function getGlobalActivity(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__polyus_sport_activity'));
			$query->order('date DESC');
			$db->setQuery($query);
			$results = $db->loadObjectList();
			return $results;
		}
		public function getAddInfo($email){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__polyus_users'));
			$query->where($db->quoteName('email') . ' = '. $db->quote($email));
			$db->setQuery($query);
			$results = $db->loadObject();
			return $results;
		}
	}
