<?php
require_once("User.php");
/**
* Profile: create(first name, last name, email, mobile), Update, view
*
*/
class Profile extends User{
  protected $profileId;
  protected $firstName;
  protected $lastName;
  protected $email;
  protected $mobile;

  function Profile($userId = NULL){
    if($userId != NULL){
      // parent::lookupUser($userId);
      self::lookup_profile($userId);
    }

  }
  function set_profileId($value){
    $this->profileId = $value;
  }
  function get_profileId(){
    return $this->profileId;
  }
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
 private function set_Profile($data){
   parent::set_user($data);
   self::set_profileId($data['profileId']);
   self::set_firstName($data['firstName']);
   self::set_lastName($data['lastName']);
   self::set_email($data['email']);
   self::set_mobile($data['mobile']);
 }
 function create_profile(){
   //save user profile in the database
   /*create a new profile within the profile's table
   * if an error occurs, the Error variable is set and return within the results array
   * if no error, user id is returned within the results array
   */
      $error = NULL;
      $insertId = NULL;
      $userId = parent::get_userId();
      $firstName = self::get_firstName();
      $lastName = self::get_lastName();
      $email = self::get_email();
      $mobile = self::get_mobile();

      $check = parent::lookup_User(parent::get_userId());

      if($check['Success'] != False){

         if($userId != NULL || $firstName != NULL ||  $lastName != NULL || $email != NULL)
         {
             $connection = new DBQuery();
             if($connection->sql_error()  == false){
                 $labelArray = array("userId", "firstName", "lastName", "email", "mobile");

                 $valueArray = array($userId, "'$firstName'",
                 "'$lastName'",
                 "'$email'",
                 "'$mobile'");
                 $col = implode(",", $labelArray) ;
                 $val = implode(", ", $valueArray);
               $sql = "INSERT INTO ss_profile ( $col ) values ( $val )";
               $connection->query($sql);

               //$error = $connection->sql_error();
               if($connection->sql_error() == false){
                   $insertId = $connection->lastInsertedID();
               }else{
                  $error = $connection->sql_error();
               }
               $connection->close();
             }else{
               $error = $connection->sql_error();
             }
         }else{
              $error = "The first name, last name and/or email is missing. Ensure the each value is set then try again.";
         }
       }else{
         $error = "User ID not found. The user ID must exist before a profile can be created.";
       }
        $resultArray = array( "Error" => $error, "Success" => $insertId);
        return $resultArray;
 }
 function update_profile(){
   //update user profile in the database
   /*update profile within the profile's table
   * if an error occurs, the Error variable is set and return within the results array
   * if no error, user id is returned within the results array
   */
      $error = NULL;
      $affectedRows = NULL;
      $profileId = self:::get_profileId();
      $firstName = self::get_firstName();
      $lastName = self::get_lastName();
      $email = self::get_email();
      $mobile = self::get_mobile();


          if( $profileId != NULL){
            $connection = new DBQuery();
            if($connection->sql_error()  == false){
                $sql = "UPDATE `ss_profile` SET `firstName` = '" . $firstName  .  "', `lastName` = '" . $lastName  .  "',  `email` = '" . $email  .  "' ,  `mobile` = '" . $mobile  .  "'
                WHERE `profileId` = $profileId";

                  $connection->link->query($sql);
                  //check to see if the sql error
                  if($connection->sql_error() == false){
                        $affectedRows = $connection->affectedRows();
                  }else{
                    $error = $connection->sql_error();
                  }

            }else{
                $error = $connection->sql_error();
            }
          }else{
            $error = "Error: profile id is NULL.";
          }
          $resultArray = array( "Error" => $error, "Success" => $affectedRows);
          return $resultArray;

 }
 function lookup_profile($userId=NULL){
   /*if user id is located, the user class variables are set to the database values
   * if an error occurs, the Error variable is set and return within result array
   */
   $connection = new DBQuery();
   $userFound = False;
   $error = NULL;

   if($userId != NULL || $userId != "")
   {
       $connection = new DBQuery;
       if($connection->sql_error() == false){
         $sql = "SELECT  *, `a`.`userId` as `userId` FROM `ss_users` `a` left join `ss_profile` `b`  on `a`.`userId` = `b`.`userId` where `a`.`userId` = $userId";

         $result = $connection->query($sql);
         if($connection->sql_error() == false){
            if( $connection->numRows($result) > 0)
            {
              $data = $connection->fetchAssoc($result);

              self::set_Profile($data);
              $userFound = True;
              $connection->freeResult($result);
            }else{
              $error = "User id " . $userId . " not found.";
            }

         }else{
            $error = $connection->sql_error();
         }
       }

       $connection->close();
   }else {
     $error = "Search incomplete: user id is missing.";
   }
   $resultArray = array("Error" => $error, "Success" => $userFound);

   return $resultArray;
 }
}

?>
