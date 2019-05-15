<?php
//error_reporting('E_NONE');error_reporting('E_NONE');
require_once("env.inc");

require_once("Model/Profile.php");
$value = "(546) 345-6785";
$phone = preg_split("/[\D]+/", $value);
$sPhone = trim(implode($phone));
//echo $sPhone . "\n";
//echo substr($sPhone, 0, 1) . " (" . substr($sPhone, 1, 3) . ") " . substr($sPhone, 4, 3) . "-". substr($sPhone, 7, 4)  . "\n";
//$value = $sPhone;
//echo substr($value, 0, 3) . "-". substr($value, 3, 4);escapeString(

global $user;
$user = new Profile(2);
$user->set_firstName("Don");
$user->set_lastName("Doe");
$user->set_email("don.doe@email.com");
$user->set_mobile( $user->strip_phone($value));
$isCreated = $user->create_profile();
var_dump($user);
var_dump($isCreated);



?>
