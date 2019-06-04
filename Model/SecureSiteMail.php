<?php

/**
* Send Mail: Create Message, Send Email
*
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//require_once("../env.inc");
require Base_Path . '/vendor/phpmailer/phpmailer/src/Exception.php';
require Base_Path . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require Base_Path . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once('includes/web_settings.inc');
class SecureSiteMail{

  protected $message;
  protected $fromEmail;
  protected $fromName;
  protected $siteName;
  protected $siteUrl;
  protected $toEmail;
  protected $toName;

  function set_fromName($value){ $this->fromName = $value; }
  function get_fromName(){ return $this->fromName;}
  function set_fromEmail($value){ $this->fromEmail = $value; }
  function get_fromEmail(){ return $this->fromEmail; }
  function set_toName($value){ $this->toName = $value; }
  function get_toName(){ return $this->toName;}
  function set_toEmail($value){ $this->toEmail = $value; }
  function get_toEmail(){ return $this->toEmail; }
  function set_message($value){ $this->message = $value; }
  function get_message(){ return $this->message; }
  function set_siteName($value){ $this->siteName = $value; }
  function get_siteName(){ return $this->siteName; }
  function set_sitUrl($value){ $this->siteUrl = $value;}
  function get_siteUrl(){ return $this->siteUrl; }

  function SecureSiteMail($toName, $toEmail){
    //Set default values
    $this->set_fromName(SiteName);
    $this->set_fromEmail(SiteEmail);
    $this->set_siteName(SiteName);
    $this->set_sitUrl(SiteUrl);
    $this->set_toName( $toName );
    $this->set_toEmail( $toEmail );

  }
  function send_email( $emailSubject, $emailBody, $isHTML = true){
    Try{
        $smail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
        $smail->IsSendmail();
        $mail_sent = False;
        $error = NULL;
        $msg = NULL;
        //create email
        $smail->SetFrom( $this->get_fromEmail(), $this->get_fromName());
        $smail->AddAddress($this->get_toEmail(), $this->get_toName());
        $smail->addReplyTo($this->get_fromEmail(), $this->get_fromName());
        $smail->addBCC($this->get_fromEmail(), $this->get_fromName());
        $smail->isHTML($isHTML);
        $smail->Subject = $this->get_siteName() . " " . $emailSubject;
        //to use an image within
        if(EmailLogoUrl != NULL){
          $smail->AddEmbeddedImage(EmailLogoUrl, "my-attach", "EmailLogo.png");
        }
         $smail->Body = $emailBody;

          //send message
          if(!$smail->send()){
            $error = "Error: email not sent to " . $this->get_toEmail();
          }else{
            $msg = "Email successfully sent to " . $this->get_toEmail();
          }
          $resultArray = array("Error" => $error, "Success" => $msg);
          return $resultArray;
     }catch (phpmailerException $e) {
           $resultArray = array("Error" => $e->errorMessage(), "Success" => $msg);
         return $resultArray;

    }catch (Exception $e) {
        $resultArray = array("Error" => $e->getMessage(), "Success" => $msg);
        return $resultArray;
    }
  }

  function emailTemplate($message = "Put Message Here!"){

      $msg = "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8' /><meta name='viewport' content='width=device-width, initial-scale=1'>";
      $msg .="<link rel='stylesheet' href='";
      $msg .= $this->get_SiteUrl();
      $msg .= "/View/css/email.css'/>";
      $msg .= "<title>" . $this->get_siteName() . " Notification</title><style></style></head>";
      $msg .= "<body style='background: rgba(138, 58, 100, 0.025) !important; font-family: Roboto, Helvetica, sans-serif; font-weight: 100; font-size: 12pt; line-height: 1.5em; color: #4d4d4d; -webkit-text-stroke: 0.1px;' >";
      $msg .= "<table style='margin: 25px auto; border-collapse: collapse; border-spacing: 5; width: 600px  !important;'>";
      $msg .= "<tr style='background:#6e3a8a; color:#ffffff; text-align: center; border-bottom-style: solid; border-bottom-color: #6e3a8a line-height: 2em;'>";
      $msg .= "<td style='padding: 25px 15px !important;'><h1>". $this->get_siteName() ."</h1></td></tr>";
      $msg .= "<tr><td></td></tr>";
      $msg .="<tr><td style='padding: 60px 25px !important; text-align: left;
      background: #fff; border-left-style: solid;  border-right-style: solid;
      border-left-width: 1px; border-right-width: 1px; border-left-color: #f2f2f2;
      border-right-color: #f2f2f2; height: 300px !important; vertical-align: top !important;'>";

      $msg .= $message;
      $msg .="</td></tr>";

      $msg .="<tr><td id='myAppID'></td></tr>";
      $msg .="<tr><td id='emailFooter' style='background: #6e3a8a; text-align: center; padding: 15px !important;'>";
      $msg .="</td></tr>";
      $msg .="<tr><td style='text-align: center;  padding: 25px; font-size: 10px;'><span>";
      $msg .="
      <a href='" . $this->get_siteUrl() ."' target='_blank' rel='noopener noreferrer'>RIMS</a>. </span></td></tr>";
      $msg .="</table></body></html>";

        $this->set_message( $msg );
        return $this->get_message();
    }
  function emailTemplateBasic($message = "Put Message Here"){
        $msg = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html lang='en' xmlns='http://www.w3.org/1999/xhtml'>
        <head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1'>";
        $msg .="<link rel='stylesheet' href='";
        $msg .= $this->get_SiteUrl();
        $msg .= "/View/css/email.css'/>";
        $msg .= "<title>" . $this->get_siteName() . " Notification</title>";
        $msg .="<style>
       body {
         font-family: Arial, Helvetica, sans-serif;
         color: #000000;
         margin: 0 10 0 10;
       }

       form {
         border: 3px solid #f1f1f1;
         font-family: Arial;

       }
       header,footer{
         text-align: center;
         background-color: #6E3A8A;
         padding: 20px;
       }

       a:link, a:visited, a:hover, a:active {
         color: #000000;
         text-decoration: none;
       }
       .container {
         padding: 20px;
         background-color: #FDFCFE;
         min-height: 300px;
         color: #000000;
       }
       </style>";
       $msg .= "</head>";
       $msg .= "<body>
         <header id='email_header' style='text-align: center;
          background-color: #6e3a8a;
          padding: 20px;'>
           <h2>" . $this->get_siteName() ."</h2>
         </header>";
       $msg .= "<div class='container' style='padding: 20px;
       background-color: #ffffff;
       min-height: 300px;
       color: #000000;'>
         " . $message . "
       </div>";

       $msg .= "<footer id='email_footer' style='text-align: center;
        background-color: #6e3a8a;
        padding: 20px;'>
         Powered By <a href='" . $this->get_siteUrl() ."' target='_blank' rel='noopener noreferrer'>RIMS</a>
       </footer>
       </body>
       </html>";

        $this->set_message( $msg );
        return $this->get_message();
  }
}

 ?>
