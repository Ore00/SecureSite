<?php
Try{
error_reporting('E_NONE');
require_once("env.inc");
require_once("vendor/apiConnector.php");
require_once("Model/Profile.php");
$value = "(546) 345-6785";

 global $user;
 $user = new Profile(2);
 $user->set_firstName("Donald");
 $user->set_lastName("Smith");
 $user->set_email("linda_mcgraw@hotmail.com");
 $user->set_mobile( $user->strip_phone($value));

 //$isCreated = $user->create_profile(); // NEED TO ADD CHECK FOR EXISTING PROFILE
///$isUpdated = $user->update_profile();

//$eStatus = $user->validate_email_smtp();
//echo "Email Valid: " . $eStatus . "\n";
var_dump($user);
//var_dump($isCreated);

}
catch(Exception $e)
{
  $emsg[] = $e->getMessage();

  foreach ($emsg as $key => $value) {
    echo "Error: " . $value . "\n";
  }
}

?>
