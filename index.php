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

$user = new User;
$user->set_userName("tester2");

$user->set_password();

echo "User: " . $user->get_userName() . "\n";
echo "Password: " . $user->get_password() . "\n";
echo "Key: ";
 $user->email_key();
echo "\n";
$newUser = $user->create_User();
var_dump($newUser); ($value == NULL) ? 'CURRENT_TIMESTAMP' : $value;
//var_dump($user->lookupUser(1));


?>
