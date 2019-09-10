<?
header('Access-Control-Allow-Origin: *');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
$model = $this->getModel();
$AllActivity = $model->getGlobalActivity();

$users = [];
$table = [];
$type = [];
foreach($AllActivity as $activity){
  $users[] = $activity->email;
}
$users = array_values(array_unique($users));
$run = 0;
$n = 0;
$i = 0;
foreach($users as $user){
  $n++;
  $i++;
  foreach($AllActivity as $activity){
    if($user == $activity->email){

      $userName = $model->getUserName($activity->email);
      $table[$n]['count'] = $i;
      $table[$n]['user'] = $userName->name.' '.$userName->lastname;
      $table[$n]['pic'] = $userName->pic;
      $table[$n]['email'] = $activity->email;
      $table[$n]['be'] = $userName->subdivision;
      if( $activity->type == 'Бег'){
        $table[$n]['Бег']+= (int)$activity->activity;
      }else{
        $table[$n]['Бег']+= 0;
      }
      if( $activity->type == 'Велосипед'){
        $table[$n]['Велосипед']+= (int)$activity->activity;
      }else{
        $table[$n]['Велосипед']+= 0;
      }
      if( $activity->type == 'Плавание'){
        $table[$n]['Плавание']+= (int)$activity->activity;
      }else{
        $table[$n]['Плавание']+= 0;
      }

      if( $activity->type == 'Ходьба'){
        $table[$n]['Ходьба']+= (int)$activity->activity;
      }else{
        $table[$n]['Ходьба']+= 0;
      }

      if( $activity->type == 'Лыжи'){
        $table[$n]['Лыжи']+= (int)$activity->activity;
      }else{
        $table[$n]['Лыжи']+= 0;
      }

      $table[$n]['total']+= (int)$activity->activity;
    }


  }
}
$table = json_encode(array_values($table));
exit($table);
?>
