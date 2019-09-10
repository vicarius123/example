<?
header('Access-Control-Allow-Origin: *');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Access-Control-Allow-Headers: *');
$get = (object)JRequest::get();
$pass = 'kfmA31SF1';
header('Content-Type: application/json');
if($get->pass === $pass){
  $model = $this->getModel();

  $allActivities = $model->getGlobalActivity();
  $run = 0;
  $swim = 0;
  $bike = 0;
  $walk = 0;
  $ski = 0;

  $activities = [];

  foreach($allActivities as $activity){
    if($activity->type == 'Бег'){
      $run+=(int)$activity->activity;
    }
    if($activity->type == 'Плавание'){
      $swim+=(int)$activity->activity;
    }
    if($activity->type == 'Велосипед'){
      $bike+=(int)$activity->activity;
    }
    if($activity->type == 'Ходьба'){
      $walk+=(int)$activity->activity;
    }
    if($activity->type == 'Лыжи'){
      $ski+=(int)$activity->activity;
    }
  }

  $activities['run'] = $run;
  $activities['swim'] = $swim;
  $activities['bike'] = $bike;
  $activities['walk'] = $walk;
  $activities['ski'] = $ski;

  $activities = json_encode($activities);

  exit($activities);
}

?>
