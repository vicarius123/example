<?
header('Access-Control-Allow-Origin: *');
$user = JFactory::getUser();
$error = 'Error';
$error=preg_replace('/\s+/', '', $error);
if($user->id != 0){
  $model = $this->getModel();
  $total_activity = $model->getAllActivity();
  $userInfo = (object)[];
  $activity = $model->getActivity($user->email);
  $addInfo = $model->getAddInfo($user->email);
  $userInfo->id = $user->id;
  $userInfo->block = $user->block;
  $userInfo->name = $user->name;
  $userInfo->lastname = $addInfo->lastname;
  $userInfo->username = $user->username;
  $userInfo->email = $user->email;
  $userInfo->currentmail = $user->email;
  $userInfo->phone = $addInfo->phone;
  $userInfo->company = $addInfo->company;
  $userInfo->subdivision = $addInfo->subdivision;
  $userInfo->pic = $addInfo->pic;
  $userInfo->groups = $user->groups;
  $userInfo->activity = $activity;
  $userInfo->total = $total_activity;
  $userInfo = json_encode($userInfo);
  exit($userInfo);
}else{
  exit($error);
}
?>
