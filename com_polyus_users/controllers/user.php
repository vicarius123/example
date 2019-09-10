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
use Strava\API\OAuth;
use Strava\API\Exception;
use Strava\API\Client;
use Strava\API\Service\REST;
/**
* User controller class.
*
* @since  1.6
*/
class Polyus_usersControllerUser extends JControllerLegacy
{
	const Polyus_sport_activity_run = 'run';
	const Polyus_sport_activity_swim = 'swim';
	const Polyus_sport_activity_ride = 'ride';
	const Polyus_sport_activity_walk = 'walk';
	const Polyus_sport_activity_nordicSki = 'nordicski';
	public $_polyusActivities = [
		self::Polyus_sport_activity_run => 'Бег',
		self::Polyus_sport_activity_swim => 'Плавание',
		self::Polyus_sport_activity_ride => 'Велосипед',
		self::Polyus_sport_activity_walk => 'Ходьба',
		self::Polyus_sport_activity_nordicSki => 'Лыжи',
	];
	/**
	* Method to check out an item for editing and redirect to the edit form.
	*
	* @return void
	*
	* @since    1.6
	*/
	public function edit()
	{
		$app = JFactory::getApplication();
		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_polyus_users.edit.user.id');
		$editId     = $app->input->getInt('id', 0);
		// Set the user id for the user to edit in the session.
		$app->setUserState('com_polyus_users.edit.user.id', $editId);
		// Get the model.
		$model = $this->getModel('User', 'Polyus_usersModel');
		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}
		// Check in the previous user.
		if ($previousId && $previousId !== $editId)
		{
			$model->checkin($previousId);
		}
		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_polyus_users&view=userform&layout=edit', false));
	}
	/**
	* Method to save a user's profile data.
	*
	* @return    void
	*
	* @throws Exception
	* @since    1.6
	*/
	public function publish()
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		// Checking if the user can remove object
		$user = JFactory::getUser();
		if ($user->authorise('core.edit', 'com_polyus_users') || $user->authorise('core.edit.state', 'com_polyus_users'))
		{
			$model = $this->getModel('User', 'Polyus_usersModel');
			// Get the user data.
			$id    = $app->input->getInt('id');
			$state = $app->input->getInt('state');
			// Attempt to save the data.
			$return = $model->publish($id, $state);
			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(JText::sprintf('Save failed: %s', $model->getError()), 'warning');
			}
			// Clear the profile id from the session.
			$app->setUserState('com_polyus_users.edit.user.id', null);
			// Flush the data from the session.
			$app->setUserState('com_polyus_users.edit.user.data', null);
			// Redirect to the list screen.
			$this->setMessage(JText::_('COM_POLYUS_USERS_ITEM_SAVED_SUCCESSFULLY'));
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getActive();
			if (!$item)
			{
				// If there isn't any menu item active, redirect to list view
				$this->setRedirect(JRoute::_('index.php?option=com_polyus_users&view=users', false));
			}
			else
			{
				$this->setRedirect(JRoute::_('index.php?Itemid='. $item->id, false));
			}
		}
		else
		{
			throw new Exception(500);
		}
	}
	/**
	* Remove data
	*
	* @return void
	*
	* @throws Exception
	*/
	public function remove()
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		// Checking if the user can remove object
		$user = JFactory::getUser();
		if ($user->authorise('core.delete', 'com_polyus_users'))
		{
			$model = $this->getModel('User', 'Polyus_usersModel');
			// Get the user data.
			$id = $app->input->getInt('id', 0);
			// Attempt to save the data.
			$return = $model->delete($id);
			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			}
			else
			{
				// Check in the profile.
				if ($return)
				{
					$model->checkin($return);
				}
				$app->setUserState('com_polyus_users.edit.inventory.id', null);
				$app->setUserState('com_polyus_users.edit.inventory.data', null);
				$app->enqueueMessage(JText::_('COM_POLYUS_USERS_ITEM_DELETED_SUCCESSFULLY'), 'success');
				$app->redirect(JRoute::_('index.php?option=com_polyus_users&view=users', false));
			}
			// Redirect to the list screen.
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getActive();
			$this->setRedirect(JRoute::_($item->link, false));
		}
		else
		{
			throw new Exception(500);
		}
	}
	public function updateUser(){
		$get = (object)JRequest::get();
		$app = JFactory::getApplication();
		$model = $this->getModel('User', 'Polyus_usersModel');
		require 'libraries/phpass/PasswordHash.php';
		$response = [];
		if($get->pic){
			$singleFile = $model->base64_to_pic($get->pic, 'user__'.rand().'.png');
			jimport('joomla.filesystem.file');
			$filename = JFile::stripExt($singleFile);
			$extension = JFile::getExt($singleFile);
			$filename = preg_replace('/[^\w_]+/u', "-", $filename);
			$filename = $filename . '.' . $extension;
			$uploadPath = JPATH_ROOT . '/images/users/' . $filename;
			$path = '/images/users/' . $filename;
			$fileTemp = $singleFile;
			if (!JFile::exists($uploadPath))
			{
				if (!JFile::copy($fileTemp, $uploadPath))
				{
				}
				$model->changePic($path, $get->email2);
				$response['pic'] = $path;
			}
		}
		if($get->old_pass && $get->repeat_pass){
			$changePass = $model->checkPass($get->id, $get->old_pass);
			if($changePass == 1){
				$model->updatePass($get->id, $get->repeat_pass);
				$response['password'] = '1';
			}else{
				$response['password'] = '0';
			}
		}
		if($get->phone){
			$model->updatePhone($get->email2, $get->phone);
		}
		if($get->email2){
			$model->updateEmail($get->email2, $get->currentmail);
			$response['email'] = '1';
		}
		if($get->subdivision){
			$model->updateBe($get->email2, $get->subdivision);
			$response['be'] = '1';
		}
		$message = 'Данные успешно изменены!';

		$app->redirect(JRoute::_('/profile'), $message);
	}
	public function auth(){
		$get = (object)JRequest::get();
		try {
			$options = [
				'clientId'     => 33747,
				'clientSecret' => '0d3c315484add0dea31e72c8e10b189c5b2f3434',
				'redirectUri'  => 'http://sport.polyus.com/index.php?option=com_polyus_users&view=user&task=user.auth&email='.$get->email2.'&date='.$get->date.'&sub='.$get->subdivision
			];
			$oauth = new OAuth($options);
			if (!isset($_GET['code'])) {
				header(sprintf("Location: %s", $oauth->getAuthorizationUrl([
					// Uncomment required scopes.
					'scope' => [
						'read',
						'activity:read_all'
					]
				])));
			} else {
				$token = $oauth->getAccessToken('authorization_code', [
					'code' => $_GET['code']
				]);
				Polyus_usersControllerUser::returnURL($token->getToken(), $get);
			}
		} catch(Exception $e) {
			print $e->getMessage();
		}
	}
	public function returnURL($token, $get){
		try {
			$adapter = new \GuzzleHttp\Client(['base_uri' => 'https://www.strava.com/api/v3/']);
			$service = new REST($token, $adapter);  // Define your user token here.
			$client = new Client($service);
			$activities = $client->getAthleteActivities();
			Polyus_usersControllerUser::parseActivity($activities, $get);
		} catch(Exception $e) {
			print $e->getMessage();
		}
	}
	public function parseActivity($activities, $get) {
		$date = strtotime($get->date);
		$email = $get->email;
		$app = JFactory::getApplication();
		$flag = true;
		foreach($activities as $activity) {
			$lowerActivityString = strtolower($activity['type']);
			//var_dump($this->_polyusActivities[$lowerActivityString]);
			$date2 = strtotime(Date('Y-m-d', strtotime($activity['start_date_local'])));
			if(strtotime($get->date) == $date2){
				print_r($activity);
				$distance = $activity['distance'];
				$distance = (float) $distance / 1000;
				$a_id= $activity['id'];
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('*');
				$query->from($db->quoteName('#__polyus_sport_activity'));
				$query->where($db->quoteName('sid') . ' = '. $a_id);
				$db->setQuery($query);
				$results = $db->loadObject();
				if($results->sid != $a_id){
					$date = date('Y-m-d H:i:s', $date2);
					$type = ucfirst($this->_polyusActivities[$lowerActivityString]);
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$columns = array('state', 'date', 'type', 'activity', 'email', 'subdivision', 'sid');
					$values = array(1, $db->quote($date),  $db->quote($type), $db->quote($distance), $db->quote($email), $db->quote($get->sub), $a_id);
					$query
					->insert($db->quoteName('#__polyus_sport_activity'))
					->columns($db->quoteName($columns))
					->values(implode(',', $values));
					$db->setQuery($query);
					if(!$db->execute()) $flag = false;
				}
			}
		}
		if($flag) $app->redirect(JRoute::_('/profile'), false);
	}
}
