<?php
require_once(User.php);
/**
* Profile: create(first name, last name, email, mobile), Update, view
*
*/
class Profile extends User{
  protected $userId;
  protected $firstName;
  protected $lastName;
  protected $email;
  protected $mobile;

  function set_firstName($value){
    $this->firstName = trim($value);
  }
  function get_firstName(){
    return $this->firstName;
  }
  function set_lastName($value){
    $this->lastName = trim($value);
  }
  function get_lastName(){
    return $this->lastName;
  }
  function set_email($value){
    $this->email = trim($value);
  }
  function get_email(){
   return $this->email;
  }
  function set_mobile($value){
   $this->mobile = trim($value);
 }
  function get_mobile(){
    return $this->mobile;
  }
 function validate_email(){
   //Verify STMP okay via api
   return $isValid;
 }
 function strip_phone($value){
   //return only the digits in the phone number
   $phone = preg_split("/[\D]+/", $value);
   return trim(implode($phone));
 }
 function format_phone($value){
   //Format the phone
   $value = $this->strip_phone(trim($value));
   $len = strlen($value);

   switch($len){
     case 11:
     $phone = substr($value, 0, 1) . " (" . substr($value, 1, 3) . ") " . substr($value, 4, 3) . "-". substr($value, 7, 4);
     break;
     case 10:
     $phone = "(" . substr($value, 0, 3) . ") " . substr($value, 3, 3) . "-". substr($value, 6, 4);
     break;
     case 7:
     $phone = substr($value, 0, 3) . "-". substr($value, 3, 4);
     break;
     default:
     $phone = $value;
   }
   return $phone;
 }

 function create_profile(){
   //save user profile in the database
 }
 function update_profile(){
   //update user profile in the database

 }

}
>?
