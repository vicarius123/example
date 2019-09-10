<pre>
  <?
  header('Access-Control-Allow-Origin: *'); 
  require 'libraries/phpass/PasswordHash.php';
  $t_hasher = new PasswordHash(10, TRUE);

  $correct = $_POST['pass'];


  $user = JFactory::getUser();
  if($user->id != 0){
    print_r(($user));
  }else{
    die('Error');
  }
  $hash = $user->password;
  print 'Hash: ' . $hash . "\n";

  $v = $t_hasher->CheckPassword($correct, $hash, $user->id);

  print_r($v);
  ?>
</pre>
