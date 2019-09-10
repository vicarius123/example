<?
header('Content-Type: application/json');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
$get = (object)JRequest::get();
$pass = 'kfmA31SF1';
if($get->pass === $pass){
  $model = $this->getModel();
  $activity = $model->getActivity($_GET['email']);
  die(json_encode($activity));
}
