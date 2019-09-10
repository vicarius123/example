<?
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
$get = (object)JRequest::get();
$app = JFactory::getApplication();
$model = $this->getModel();
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
  $path = JURI::base() . 'images/users/' . $filename;
  $fileTemp = $singleFile;

  if (!JFile::exists($uploadPath))
  {
    if (!JFile::copy($fileTemp, $uploadPath))
    {

    }
    $model->changePic($path, $get->email);
    $response['pic'] = $path;
    unlink($fileTemp);
  }
}
if($get->oldpass && $get->userpass){
  $changePass = $model->checkPass($get->id, $get->oldpass);
  if($changePass == 1){
    $model->updatePass($get->id, $get->userpass);
    $response['password'] = '1';
  }else{
    $response['password'] = '0';
  }
}
if($get->phone){
  $model->updatePhone($get->email, $get->phone);
}
if($get->email){
  $model->updateEmail($get->email, $get->currentmail);
  $response['email'] = '1';
}
if($get->subdivision){
  $model->updateBe($get->email, $get->subdivision);
  $response['be'] = '1';
}

exit(json_encode($response));
