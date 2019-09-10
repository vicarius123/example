<?
$get = (object)JRequest::get();

if($get->email){

  $user = new JUser;

  $data['email'] = JStringPunycode::emailToPunycode($get->email);
  $data['password'] = rand(0, 10);
  $data['name'] = $get->name;
  $data['username'] = $get->email;
  $data['groups'][] = 2;

  $model = $this->getModel();


  if (!$user->bind($data))
  {
    die('error');
  }

  if (!$user->save())
  {
    die('error');
  }else{
    $pathh = '';
    if($get->pic){

      $singleFile = $model->base64_to_pic($get->pic, 'user__'.rand().'.png');
      jimport('joomla.filesystem.file');
      $filename = JFile::stripExt($singleFile);
      $extension = JFile::getExt($singleFile);
      $filename = preg_replace('/[^\w_]+/u', "-", $filename);
      $filename = $filename . '.' . $extension;
      $uploadPath = JPATH_ROOT . '/images/users/' . $filename;
      $path = JURI::base() . 'images/users/' . $filename;
      $fileTemp = $singleFile;

      if (!JFile::exists($uploadPath))
      {
        if (!JFile::copy($fileTemp, $uploadPath))
        {

        }

        $pathh = $path;
        unlink($fileTemp);
      }
    }

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $columns = array('name', 'lastname', 'email', 'phone', 'subdivision', 'pic');
    $values = array($db->quote($get->name),  $db->quote($get->lastname), $db->quote($get->email), $db->quote($get->phone), $db->quote($get->be), $db->quote($pathh));
    $query
    ->insert($db->quoteName('#__polyus_users'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));
    $db->setQuery($query);
    $db->execute();

    $activity = $model->getActivity($get->email);
    $addInfo = $model->getAddInfo($get->email);
    $total_activity = $model->getAllActivity();

    $logged_user = $user;

    $addInfo = $model->getAddInfo($logged_user->email);

    $logged_user->lastname = $addInfo->lastname;
    $logged_user->phone = $addInfo->phone;
    $logged_user->company = $addInfo->company;
    $logged_user->subdivision = $addInfo->subdivision;
    $logged_user->pic = $addInfo->pic;
    $logged_user->password = '';

    $logged_user->lastname = $addInfo->lastname;

    $logged_user->email = $addInfo->email;
    $logged_user->currentmail = $addInfo->email;

    $logged_user->phone = $addInfo->phone;
    $logged_user->company = $addInfo->company;
    $logged_user->subdivision = $addInfo->subdivision;
    $logged_user->pic = $addInfo->pic;

    $logged_user->activity = $activity;

    $logged_user->total = $total_activity;

    die(json_encode($logged_user));

  }

}
?>
