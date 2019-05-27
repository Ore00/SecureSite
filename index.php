<?php
Try{
//error_reporting('E_NONE');
require "vendor/autoload.php";
require_once("env.inc");
require_once("vendor/apiConnector.php");
require_once("Model/Profile.php");

//Setps to create a user that has profile information
//First set the user values and create the user
 global $user;
 $user = new Profile();

  $user->set_userName("nbird");
  //set user password to key
  $user->set_password();
  //create user
  $userCreated = $user->create_User();

  if($userCreated["Error"] == NULL){
      echo"User id " . $user->get_userId() . " successfully created" . PHP_EOL;

      //Next set user profile information name, email, phone
      $user->set_firstName("Nancy");
      $user->set_lastName("Bird");
      $user->set_email("nbird@fakeemail.com");
      $user->set_mobile( $user->strip_phone("(123) 123-4567"));

      //create user's profile
      $profileCreated = $user->create_profile($user->get_userId());
      if($profileCreated['Error'] == NULL){
        echo"Profile id " . $profileCreated["Success"] . " successfully created" . PHP_EOL;
      }else{
        echo $profileCreated["Error"] . PHP_EOL;
      }
    }else{
       echo $userCreated["Error"]  . PHP_EOL;
    }

//update user's profile
 if($user->get_profileId() != NULL){
  $user->set_email("linda_mcgraw@hotmail.com");
  $profileUpdated = $user->update_profile($user->get_userId());
  if($profileUpdated["Error"] == NULL){
    echo"Profile id " . $user->get_profileId() ." successfully updated" . PHP_EOL;
  }else{
    echo $profileUpdated["Error"] . PHP_EOL;
  }
}

 //Check if the user's email address is valid
 $eStatus = $user->validate_email_smtp();
  echo "Email " . $user->get_email() . " valid: " . $eStatus . PHP_EOL;
  //if user email has a valid smtp send the user a temporary access key
 if($eStatus == true){
   echo"Start send temp keys." . PHP_EOL;
   $sendKey = $user->email_temporaryKey();
   print_r($sendKey);
   echo PHP_EOL;
 }

}
catch(Exception $e)
{
  $emsg[] = $e->getMessage();

  foreach ($emsg as $key => $value) {
    echo "Error: " . $value  . PHP_EOL;
  }
}


?>
