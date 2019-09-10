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
jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');
use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;
/**
* Polyus_users model.
*
* @since  1.6
*/
class Polyus_usersModelUser extends JModelItem
{
  public $_item;
  /**
  * Method to auto-populate the model state.
  *
  * Note. Calling getState in this method will result in recursion.
  *
  * @return void
  *
  * @since    1.6
  *
  */
  protected function populateState()
  {
    $app  = Factory::getApplication('com_polyus_users');
    $user = Factory::getUser();
    // Check published state
    if ((!$user->authorise('core.edit.state', 'com_polyus_users')) && (!$user->authorise('core.edit', 'com_polyus_users')))
    {
      $this->setState('filter.published', 1);
      $this->setState('filter.archived', 2);
    }
    // Load state from the request userState on edit or from the passed variable on default
    if (Factory::getApplication()->input->get('layout') == 'edit')
    {
      $id = Factory::getApplication()->getUserState('com_polyus_users.edit.user.id');
    }
    else
    {
      $id = Factory::getApplication()->input->get('id');
      Factory::getApplication()->setUserState('com_polyus_users.edit.user.id', $id);
    }
    $this->setState('user.id', $id);
    // Load the parameters.
    $params       = $app->getParams();
    $params_array = $params->toArray();
    if (isset($params_array['item_id']))
    {
      $this->setState('user.id', $params_array['item_id']);
    }
    $this->setState('params', $params);
  }
  /**
  * Method to get an object.
  *
  * @param   integer $id The id of the object to get.
  *
  * @return  mixed    Object on success, false on failure.
  *
  * @throws Exception
  */
  public function getItem($id = null)
  {
    if ($this->_item === null)
    {
      $this->_item = false;
      if (empty($id))
      {
        $id = $this->getState('user.id');
      }
      // Get a level row instance.
      $table = $this->getTable();
      // Attempt to load the row.
      if ($table->load($id))
      {
        // Check published state.
        if ($published = $this->getState('filter.published'))
        {
          if (isset($table->state) && $table->state != $published)
          {
            throw new Exception(JText::_('COM_POLYUS_USERS_ITEM_NOT_LOADED'), 403);
          }
        }
        // Convert the JTable to a clean JObject.
        $properties  = $table->getProperties(1);
        $this->_item = ArrayHelper::toObject($properties, 'JObject');
      }
    }
    if (isset($this->_item->created_by))
    {
      $this->_item->created_by_name = Factory::getUser($this->_item->created_by)->name;
    }
    if (isset($this->_item->modified_by))
    {
      $this->_item->modified_by_name = Factory::getUser($this->_item->modified_by)->name;
    }
    if (!empty($this->_item->subdivision))
    {
      $this->_item->subdivision = JText::_('COM_POLYUS_USERS_USERS_SUBDIVISION_OPTION_' . $this->_item->subdivision);
    }
    return $this->_item;
  }
  /**
  * Get an instance of JTable class
  *
  * @param   string $type   Name of the JTable class to get an instance of.
  * @param   string $prefix Prefix for the table class name. Optional.
  * @param   array  $config Array of configuration values for the JTable object. Optional.
  *
  * @return  JTable|bool JTable if success, false on failure.
  */
  public function getTable($type = 'User', $prefix = 'Polyus_usersTable', $config = array())
  {
    $this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_polyus_users/tables');
    return JTable::getInstance($type, $prefix, $config);
  }
  /**
  * Get the id of an item by alias
  *
  * @param   string $alias Item alias
  *
  * @return  mixed
  */
  public function getItemIdByAlias($alias)
  {
    $table      = $this->getTable();
    $properties = $table->getProperties();
    $result     = null;
    if (key_exists('alias', $properties))
    {
      $table->load(array('alias' => $alias));
      $result = $table->id;
    }
    return $result;
  }
  /**
  * Method to check in an item.
  *
  * @param   integer $id The id of the row to check out.
  *
  * @return  boolean True on success, false on failure.
  *
  * @since    1.6
  */
  public function checkin($id = null)
  {
    // Get the id.
    $id = (!empty($id)) ? $id : (int) $this->getState('user.id');
    if ($id)
    {
      // Initialise the table
      $table = $this->getTable();
      // Attempt to check the row in.
      if (method_exists($table, 'checkin'))
      {
        if (!$table->checkin($id))
        {
          return false;
        }
      }
    }
    return true;
  }
  /**
  * Method to check out an item for editing.
  *
  * @param   integer $id The id of the row to check out.
  *
  * @return  boolean True on success, false on failure.
  *
  * @since    1.6
  */
  public function checkout($id = null)
  {
    // Get the user id.
    $id = (!empty($id)) ? $id : (int) $this->getState('user.id');
    if ($id)
    {
      // Initialise the table
      $table = $this->getTable();
      // Get the current user object.
      $user = Factory::getUser();
      // Attempt to check the row out.
      if (method_exists($table, 'checkout'))
      {
        if (!$table->checkout($user->get('id'), $id))
        {
          return false;
        }
      }
    }
    return true;
  }
  /**
  * Publish the element
  *
  * @param   int $id    Item id
  * @param   int $state Publish state
  *
  * @return  boolean
  */
  public function publish($id, $state)
  {
    $table = $this->getTable();
    $table->load($id);
    $table->state = $state;
    return $table->store();
  }
  /**
  * Method to delete an item
  *
  * @param   int $id Element id
  *
  * @return  bool
  */
  public function delete($id)
  {
    $table = $this->getTable();
    return $table->delete($id);
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
    $result = $db->execute();

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
    if($be == 'Полюс Алдан'){
      $subdivision = 10;
    }
    if($be == 'СЛ Золото'){
      $subdivision = 11;
    }

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $fields = array(
      $db->quoteName('subdivision') . ' = '.$subdivision,
    );
    $conditions = array(
      $db->quoteName('email') . ' = ' . $db->quote($email)
    );
    $query->update($db->quoteName('#__polyus_sport_activity'))->set($fields)->where($conditions);
    $db->setQuery($query);
    $result = $db->execute();

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
    $query->where($db->quoteName('state') . ' = 1');
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
    $query->where($db->quoteName('state') . ' = 1');
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
    $query->where($db->quoteName('state') . ' = 1');
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
    $query->where($db->quoteName('state') . ' = 1');
    $db->setQuery($query);
    $results = $db->loadObject();
    return $results;
  }
}
