<?php
Try{
//error_reporting('E_NONE');
require "vendor/autoload.php";
require_once("env.inc");
require_once("vendor/apiConnector.php");
require_once("Model/Profile.php");
/*s
//Setps to create a user that has profile information
//First set the user values and create the user
 global $user;
 $user = new Profile();

  $user->set_userName("ttbrooks");
  //set user password to key
  $user->set_password();
  //create user
  $userCreated = $user->create_User();

  if($userCreated["Error"] == NULL){
      echo"User id " . $user->get_userId() . " successfully created" . PHP_EOL;

      //Next set user profile information name, email, phone
      $user->set_firstName("Ted");
      $user->set_lastName("Brooks");
      $user->set_email("ttbrooks@fakeemail.com");
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
  //set a random password
  $user->set_password();
  $userUpdated = $user->update_User();
  if($userUpdated["Success"] != False){
    echo"User  " . $user->get_userName() ." password successfully updated" . PHP_EOL;
  }else{
    echo $userUpdated["Error"] . PHP_EOL;
  }
 }

 //Check if the user's email address is valid
 $eStatus = $user->validate_email_smtp();
  echo "Email " . $user->get_email() . " valid: " . $eStatus . PHP_EOL;
  //if user email has a valid smtp send the user a temporary access key
 if($eStatus == true){
   echo"Start email temp key." . PHP_EOL;
   $sendKey = $user->email_temporaryKey("MyCustomPassword");
 }
*/
 //Validate a user after they have submitted a form with username & Password
 global $currentUser;
 $currentUser  = new User();
 $isUserValid = $currentUser->validate_User("tbrooks", "MyCustomPassword");
 echo "User valid: " . $currentUser->get_loggedIn() . PHP_EOL;

//with a global user or validate whether the user is loggedIn Validated
 if($currentUser->get_loggedIn() != false){
   echo"Redirect user " . $currentUser->get_userName() . " to protected webpage" . PHP_EOL;
 }else{
   echo"Problem with username and password combination." . PHP_EOL;
 }

 //logout
 $currentUser->log_out();
 if($currentUser->get_loggedIn() !== true){
 echo "User " . $currentUser->get_userName()  .  " not logged in" . PHP_EOL;
 }else{
   echo "User " . $currentUser->get_userName()  .  " logged in" . PHP_EOL;
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
