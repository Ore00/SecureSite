<?php
/**
* User: create, Update(password), Yiew, Generate User password, Email user password
*
* Profile: create(first name, last name, email, mobile), Update, view
*
*Roles:
*/
if(!class_exists("DBQuery")){
  require_once(Base_Path .'/vendor/DBQuery.php');
  }
class User{

  private $userId;
  private $userName;
  private $password;
  private $key;
  private $dateCreated;
  private $dateUpdated;
  private $revoked;

  function User($userId = NULL){
    if($userId != NULL){
      self::lookupUser($userId);
    }
  }
  function set_userId($value){
    $this->userId = $value;
  }
  function get_userId(){
    return $this->userId;
  }
  function set_userName($value){
    $this->userName = trim($value);
  }
  function get_userName(){
    return $this->userName;
  }
  private function set_key(){
    $this->key = self::generateKey();
  }
  private function get_key(){
    return $this->key;
  }
  function email_key(){// update to send key vial email
    echo self::get_key();
  }
  function set_password($value = NULL){
    if($value == NULL){
      self::set_key();
      $value = self::get_key();
    }
    $this->password = md5($value);
  }
  function get_password(){
    return $this->password;
  }

  private function set_dateCreated($value = NULL){
    $this->dateCreated = ($value == NULL) ? 'CURRENT_TIMESTAMP' : $value;
  }
  function get_dateCreated(){
    return $this->dateCreated;
  }
  private function set_dateUpdated($value = NULL){
    $this->dateUpdated = ($value == NULL) ? 'CURRENT_TIMESTAMP' : $value;
  }
  function get_dateUpdated(){
    return $this->dateUpdated;
  }
  function set_revoked($value=0){
    $this->revoked = $value;
  }
  function get_revoked(){
    return $this->revoked;
  }
  private static function set_User($data){
    self::set_userId($data['userId']);
    self::set_userName($data['userName']);
    self::set_password($data['password']);
    self::set_dateCreated($data['dateCreated']);
    self::set_dateUpdated($data['dateUpdated']);
    self::set_revoked($data['revoked']);
  }
  function create_User(){
        /*create a new user within the user's table
        * if an error occurs, the Error variable is set and return
        * if no error, user id is returned with data array
        */
    $error = NULL;
    $insertId = NULL;
    $userName = self::get_userName();
    $password = self::get_password();
    self::set_dateCreated();
    $created = self::get_dateCreated();
    self::set_dateUpdated();
    $updated = self::get_dateUpdated();
    self::set_revoked();
    $revoked = self::get_revoked();

    $check = self::lookup_User(self::get_userId());
    if($check['Success'] == False){

        if( $userName != NULL && $password != NULL)
        {
            $connection = new DBQuery();
            if($connection->sql_error()  == false){
                $labelArray = array("userName", "password", "dateCreated", "dateUpdated", "revoked");

                $valueArray = array("'$userName'",
                " '$password' ",
                $created,
                $updated,
                $revoked);
                $col = implode(",", $labelArray) ;
                $val = implode(", ", $valueArray);
              $sql = "INSERT INTO ss_users ( $col ) values ( $val )";
              $connection->query($sql);
            
              $error = $connection->sql_error();
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
             $error = "Username is not set. Set the user and password" . $userName . " then try again.";
        }
    }
    $resultArray = array( "Error" => $error, "Success" => $insertId);
    return $resultArray;
  }
  function update_User(){

  }
  function validate_User($userName, $Password){

  }
  function lookup_User($userId=NULL){
    /*if user id is located, the user class variables are set
    * if an error occurs, the Error variable is set and return within the user results
    */
    $connection = new DBQuery();
    $userFound = False;
    $error = NULL;

    if($userId != NULL || $userId != "")
    {
        $connection = new DBQuery;
        if($connection->sql_error() == false){
          $sql = "SELECT * FROM `ss_users` where userId = $userId";
          $result = $connection->query($sql);
          if($connection->sql_error() == false){
             if( $connection->numRows($result) > 0)
             {
               $data = $connection->fetchAssoc($result);
               self::set_User($data);
               $userFound = True;
             }else{
               $error = "User id " . $userId . " not found.";
             }

          }else{
             $error = $connection->sql_error();
          }
        }
        $connection->freeResult($result);
        $connection->close();
    }else {
      $error = "Search incomplete: user id is missing.";
    }
    $resultArray = array("Error" => $error, "Success" => $userFound);

    return $resultArray;
  }
  function revoke_User($userId=NULL){

  }
  private static function generateKey() {
    $length = 10;
    $chars='1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $len = strlen($chars)-1;
    $key = '';
    while (strlen($key) < $length) {
      $key .= $chars[ rand(0, $len) ];
    }
    return $key;
  }

}

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

 ?>
