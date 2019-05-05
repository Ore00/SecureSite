<?php


class mailBoxLayer{

  protected $email;
  protected $key;

  function mailBoxLayer($email){
    require_once("web_settings.php");
    $this->setApiKey(mailBoxLayerKey);
    $this->setEmail($email);
  }
  function setApiKey($key){
    // set API Access Key
    $this->key = $key;
  }
  function getApiKey(){
    return $this->key;
  }
  function setEmail($email){
    //set Email Address
    $this->email = $email;
  }
  function getEmail(){
    return $this->email;
  }
  function apiRequest(){
    // Initialize CURL:
   $email = $this->getEmail();
   $key = $this->getApiKey();
    $ch = curl_init('http://apilayer.net/api/check?access_key='.$key.'&email='.$email.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Store the data:
    $response = curl_exec($ch);

    if(curl_errno( $ch )){
      $data = array("Error Message" => "Curl ERROR" . curl_error( $ch ) . " Code: " . curl_errno( $ch ));
    }else{
      //check the HTTP status codes
      $statusCode = (int)curl_getinfo( $ch, CURLINFO_HTTP_CODE);
      switch($statusCode){
        case 200:
        break;
        case 400:
        $data = array("Error Message" =>  "HTTP ERROR " . $statusCode . " Bad Request");
        break;
        case 401:
        $data = array("Error Message" =>  "HTTP ERROR " . $statusCode . " User is unauthorized");
        break;
        case 410:
        $data = array("Error Message" =>  "HTTP ERROR " . $statusCode . " Gone");
        break;
        case 500:
        $data = array("Error Message" =>  "HTTP ERROR " . $statusCode . " Internal Server Error");
        break;
        case 504:
        $data = array("Error Message" =>  "HTTP ERROR " . $statusCode . " Gateway Timeout");
        break;
        default:
        $data = array("Error Message" =>  "HTTP ERROR " . $statusCode);
        break;
      }

    }
    if(isset($data)){
      curl_close($ch);
      return $data;
    }else{
      // Decode JSON response: into array
     return json_decode($response, true);

    }

  }

  function isValid($array){
    //Returns true or false depending on whether or not the general syntax of the requested email address is valid.
      return $array['format_valid'];
  }
  function stmpOkay($array){
    //Returns true or false depending on whether or not the SMTP check of the requested email address succeeded.
      return $array['stmp_check'];
  }
  function score($array){
    //Returns a numeric score between 0 and 1 reflecting the quality and deliverability of the requested email address.
      return $array['score'];
  }
  function didYouMean($array){
    //Contains a did-you-mean suggestion in case a potential typo has been detected.
      return $array['did_you_mean'];
  }
  function getError($array){
    if(isset($array['success'])){
      return  "ERROR " . $array['error']['code'] . " " . $array['error']['info'];
    }else{
      return;
    }
  }

}


 ?>
