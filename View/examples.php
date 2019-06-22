<?php
Try{
//error_reporting('E_NONE');

require_once("../env.inc");
require Base_Path . "/vendor/autoload.php";
require_once(Base_Path . "/vendor/apiConnector.php");
require_once(Base_Path . "/Model/Profile.php");
}
catch(Exception $e)
{
  $emsg[] = $e->getMessage();
}
 ?>
 <!DOCTYPE html>
<html>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  color: #000000s;
  margin: 0 10 0 10;
}
code{
  background-color: #000000;
  color: #FFFFFF;
  display: block;
  padding: 15px;
  border: 5px;

}
form {
  border: 3px solid #f1f1f1;
  font-family: Arial;

}
header,footer{
  text-align: center;
  background-color: #6e3a8a;
  padding: 10px;
  color: #FFFFFF;
}

a:link, a:visited, a:hover, a:active {
  color: white;
  text-decoration: none;
}
.container {
  padding: 0px;
  background-color: #gray;
  min-height: 300px;
  color: #000000;
}
.success{
  color: lightgreen !important;
}
</style>
<body>
  <header id='header'>
    <h2>Secure Site Examples</h2>
  </header>
  <div class='container'>

    <h3>Examples using the Profile Class</h3>
    <h5>Create User</h5>
    <code>

      global $user; <br>
      $user = new Profile(); <br>
       $user->set_userName("tbrooks");<br><br>

       //set user password to key <br>
       $user->set_password();<br><br>

       //create user<br>
       $userCreated = $user->create_User();<br>

       if($userCreated["Error"] == NULL){ <br><br>
           echo"User id " . $user->get_userId() . " successfully created" . PHP_EOL; <br><br>
         }else{<br>
            echo $userCreated["Error"]  . PHP_EOL;<br>
         }<br><br>
         </code>
         <hr>
         <code class="success">
           User id 4 successfully created<br>
         </code>
           <h5>Create Profile</h5>
         <code>
           //Next set user profile variables name, email, phone <br>
           $user->set_firstName("Tod");<br>
           $user->set_lastName("Brooks");<br>
           $user->set_email("tbrooks@fakeemail.com");<br>
           $user->set_mobile( $user->strip_phone("(123) 123-4567")); <br><br>

           //create user's profile<br>
           $profileCreated = $user->create_profile($user->get_userId());<br>
           if($profileCreated['Error'] == NULL){<br><br>
              echo"Profile id " . $profileCreated["Success"] . " successfully created" . PHP_EOL; <br><br>
           }else{<br>
             echo $profileCreated["Error"] . PHP_EOL;<br>
           }<br>

       </code>
       <hr>
       <code class="success">

         Profile id 4 successfully created<br>

       </code>
         <h5>Update Profile</h5>
         <code>
         //update user's profile <br>
          if($user->get_profileId() != NULL){<br><br>
           $user->set_email("tbrooks@email.com"); <br>
           $profileUpdated = $user->update_profile($user->get_userId());<br>
           if($profileUpdated["Error"] == NULL){<br>
             echo"Profile id " . $user->get_profileId() ." successfully updated" . PHP_EOL;<br>
           }else{<br>
             echo $profileUpdated["Error"] . PHP_EOL;<br>
           }<br><br>
         </code>
         <hr>
         <code class="success">
           Profile id 4 successfully updated<br>
         </code>
         <h3>Set a random password</h3>
         <code>
           $user->set_password();<br>
           $userUpdated = $user->update_User();<br>
           if($userUpdated["Success"] != False){<br>
             echo"User  " . $user->get_userName() ." password successfully updated" . PHP_EOL;<br>
           }else{<br>
             echo $userUpdated["Error"] . PHP_EOL;<br>
           }<br>
         </code>
           <hr>
           <code class="success">
             User tbrooks password successfully updated<br>
           </code>

           <h3>Check Email SMTP</h3>
           <code>
           //Check if the user's email address is valid<br><br>
           $eStatus = $user->validate_email_smtp();<br>
            echo "Email " . $user->get_email() . " valid: " . $eStatus . PHP_EOL;<br>
          </code>
          <hr>
          <code class="success">
            Email tbrooks@email.com valid: 1<br>
          </code>
          <h3>Send User Temporary Access Code</h3>
          <code>
            //if user email has a valid smtp, send the user a temporary access key<br><br>
           if($eStatus == true){<br>
             echo"Start emailing temp key." . PHP_EOL;<br>
             $sendKey = $user->email_temporaryKey("MyCustomPassword");<br>
           }<br>
         </code>
         <hr>
         <code class="success">
           Start emailing temp key.<br>
         </code>
            <h3>Examples using the User Class</h3>
            <h5>Validate User</h5>
            <code>
           //after form submission<br><br>
           global $currentUser;<br>
           $currentUser  = new User();<br>
           $isUserValid = $currentUser->validate_User( $_POST['user_name_entered'], "$_POST['password_entered']");<br>
           echo "User valid: " . $currentUser->get_loggedIn() . PHP_EOL;<br>
         </code>
            <h5>Check User Logged In</h5>
            <code>
           //Using a global user, validate whether the user is loggedIn<br><br>
            if($currentUser->get_loggedIn() != false){<br>
              echo"Redirect user " . $currentUser->get_userName() . " to protected webpage" . PHP_EOL;<br>
            }else{<br>
              echo"Problem with username and/or password combination." . PHP_EOL;<br>
            }<br>
         </code>
         <hr>
         <code class="success">
           User valid: 1<br>
             Redirect user tbrooks to protected webpage<br>
         </code>
         <h3>User Logout</h3>
         <code>

           //logout<br><br>
           $currentUser->log_out();<br>
           if($currentUser->get_loggedIn() !== true){<br><br>
           echo "User " . $currentUser->get_userName()  .  " not logged in" . PHP_EOL;<br><br>
           }else{<br><br>
             echo "User " . $currentUser->get_userName()  .  " logged in" . PHP_EOL;<br><br>
          }<br>

    </code>
    <hr>
    <code class="success">
      User tbrooks not logged in <br>
      [Finished in 10.96s]<br>
    </code>
  </div>
  <br>
  <footer id='footer'>
    Powered By <a href='https://myrims.net' target='_blank' rel='noopener noreferrer'>RIMS</a>
  </footer>
</body>
</html>
