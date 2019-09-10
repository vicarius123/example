<?
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
$get = (object)JRequest::get();
$app = JFactory::getApplication();
$model = $this->getModel();
$date = date('Y-m-d H:i:s', strtotime($get->date));

$update = $model->addActivity($get, $date);

exit(($date));
