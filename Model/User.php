<?php
/**
* User: create, Update(password), Yiew, Generate User password, Email user password
*
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
  private $loggedIn;

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
  function set_revoked($value = 0){
    //0 false 1 true
    $this->revoked = $value;
  }
  function get_revoked(){
    return $this->revoked;
  }
  private static function set_loggedIn($value = False){
    $this->loggedIn =$value;
  }
  function get_loggedIn($value = False){
    return $this->loggedIn;
  }
  protected function set_User($data){

    self::set_userId($data['userId']);
    self::set_userName($data['userName']);
    self::set_password($data['password']);
    self::set_dateCreated($data['dateCreated']);
    self::set_dateUpdated($data['dateUpdated']);
    self::set_revoked($data['revoked']);
  }
  function create_User(){
        /*create a new user within the user's table
        * if an error occurs, the Error variable is set and return within the results array
        * if no error, user id is returned within the results array
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
    $error = NULL;
    $affectedRows = NULL;
    $userId = self::get_userId();
    $userName = self::get_userName();
    $password = self::get_password();
    self::set_dateUpdated();
    $updated = self::get_dateUpdated();
    $revoked = self::get_revoked();

    if( $userName != "" && $password != ""){
      $connection = new DBQuery();
      if($connection->sql_error()  == false){
          $sql = "UPDATE `ss_users` SET `userName` = '" . $userName  .  "',  `password` = '" . $password  .  "' ,  `dateUpdated` = '" . $updated  .  "',  `revoked` = '" . $revoked  .  "'
            WHERE `userId` = $userId";

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
      $error = "username and/or password must not be NULL";
    }
    $resultArray = array( "Error" => $error, "Success" => $affectedRows);
    return $resultArray;
  }
  function validate_User($userName, $password){
    /*if user name and password are located, the user class variables are set to the database values & results in userValid = true
    /* else results in userValid = false
    * if an error occurs, the Error variable is set and return within result array
    */
    $connection = new DBQuery();
    $userValid = False;
    $error = NULL;

    if(trim($userName) != "" || trim($Password) != "")
    {
        $pwd = md5($password);
        $connection = new DBQuery;
        if($connection->sql_error() == false){
          $sql = "SELECT * FROM `ss_users` where `userName` = '$userName' and `password` = '$pwd' and `revoked` = 0";
          $result = $connection->query($sql);
          if($connection->sql_error() == false){
             if( $connection->numRows($result) == 1)
             {
               $data = $connection->fetchAssoc($result);
               //set user variables
               self::set_User($data);
               $userValid = True;
               self::set_loggedIn($userValid);
             }else{
               $error = "User name or password is invalid.";
               self::set_loggedIn($userValid);
             }
             $connection->freeResult($result);
          }else{
             $error = $connection->sql_error();
          }
        }

        $connection->close();
    }else {
      $error = "user name and password are required.";
    }
    $resultArray = array("Error" => $error, "Success" => $userValid);

    return $resultArray;
  }
  function lookup_User($userId=NULL){
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

 ?>
