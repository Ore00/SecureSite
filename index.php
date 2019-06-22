<?php
Try{
error_reporting('E_NONE');
require "vendor/autoload.php";
require_once("env.inc");
require_once("vendor/apiConnector.php");
require_once("Model/Profile.php");


//First set the user & profile values by user id
 global $user;
 $user = new Profile(4);

$user->set_email("linda_mcgraw@hotmail.com");
$result = $user->update_User();
print_r($result, true);
//if user email has a valid smtp send the user a temporary access key
 if($user->validate_email_smtp() == true){
   echo"Start emailing temp key." . PHP_EOL;
   $sendKey = $user->email_temporaryKey("MyCustomPassword");
 }
 print_r($sendKey);
}
catch(Exception $e)
{
  $emsg[] = $e->getMessage();

  foreach ($emsg as $key => $value) {
    echo "Error: " . $value  . PHP_EOL;
  }
}



?>
