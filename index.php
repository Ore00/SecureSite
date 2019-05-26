<?php
Try{
error_reporting('E_NONE');
require_once("env.inc");
require_once("vendor/apiConnector.php");
require_once("Model/Profile.php");


//Setps to create a user that has profile information
//First set the user values and create the user
 global $user;
 $user = new Profile();
  $user->set_userName("jsmith");
  //generate a default password
  $user->set_key();
  //set user password to key
  $user->set_password($user->get_key());
  //create user
  $userCreated = $user->create_User();

  if($userCreated["error"] = NULL){
      //Next set user profile information name, email, phone
      $user->set_firstName("Jack");
      $user->set_lastName("Smith");
      $user->set_email("jack.smith@fakeemail.com");
      $user->set_mobile( $user->strip_phone("(546) 123-6785"));
      //create user's profile
      $profileCreated = $user->create_profile($user->get_userId());
    }else{
      echo $userCreated["error"];
    }
///$isUpdated = $user->update_profile();

//$eStatus = $user->validate_email_smtp();
//echo "Email Valid: " . $eStatus . "\n";


print_r($isCreated, true);

}
catch(Exception $e)
{
  $emsg[] = $e->getMessage();

  foreach ($emsg as $key => $value) {
    echo "Error: " . $value . "\n";
  }
}

?>
