<?
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
$get = (object)JRequest::get();
$pass = 'kfmA31SF1';

if($get->pass === $pass){
  $model = $this->getModel();

  $allActivities = $model->getGlobalActivity();


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
  foreach($allActivities as $activity){

    if($activity->subdivision == '1'){
      $s1+=(int)$activity->activity;
    }
    if($activity->subdivision == '2'){
      $s2+=(int)$activity->activity;
    }
    if($activity->subdivision == '3'){
      $s3+=(int)$activity->activity;
    }
    if($activity->subdivision == '4'){
      $s4+=(int)$activity->activity;
    }
    if($activity->subdivision == '5'){
      $s5+=(int)$activity->activity;
    }
    if($activity->subdivision == '6'){
      $s6+=(int)$activity->activity;
    }
    if($activity->subdivision == '7'){
      $s7+=(int)$activity->activity;
    }
    if($activity->subdivision == '8'){
      $s8+=(int)$activity->activity;
    }
    if($activity->subdivision == '9'){
      $s9+=(int)$activity->activity;
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


  $activities = json_encode($activities);
  exit($activities);
}

?>
