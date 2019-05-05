<?php
//error_reporting('E_NONE');error_reporting('E_NONE');
require_once("env.inc");

require_once("Model/User.php");
$value = "(546) 345-6785";
$phone = preg_split("/[\D]+/", $value);
$sPhone = trim(implode($phone));
//echo $sPhone . "\n";
//echo substr($sPhone, 0, 1) . " (" . substr($sPhone, 1, 3) . ") " . substr($sPhone, 4, 3) . "-". substr($sPhone, 7, 4)  . "\n";
//$value = $sPhone;
//echo substr($value, 0, 3) . "-". substr($value, 3, 4);escapeString(

global $user;
$user = new User;
$valid = $user->validate_User("tester10", "A5gRjyvq7C");
var_dump($valid);
var_dump($user);
//$user->set_userName("tester10");
//$user->set_password();
//$result = $user->create_User();
//$user->lookup_User($result['Success']);
//var_dump($user);


?>
