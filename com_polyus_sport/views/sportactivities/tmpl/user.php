<?
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$error = 'Error';

$error=preg_replace('/\s+/', '', $error);
if($_GET['email']){
  $model = $this->getModel();
  $total_activity = $model->getAllActivity();
  $userInfo = (object)[];
  $activity = $model->getActivity($_GET['email']);
  $addInfo = $model->getAddInfo($_GET['email']);
  $userInfo->activity = $activity;
  $userInfo->total = $total_activity;
  $userInfo = json_encode($userInfo);
  exit($userInfo);
}else{
  exit($error);
}
?>
