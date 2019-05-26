<?php


class apiConnector{

  protected $certFile;
  protected $keyFile;
  protected $authUserId;
  protected $authPassword;
  protected $authPassPhrase;
  protected $authNonce;
  protected $apiHeaders;
  protected $passwordDigest;
  protected $data = array();
  protected $API_URL;
  protected $contentType;
  protected $contentLength;
  protected $modeSSL;
  protected $encoding;
  protected $sslVersion;
  protected $sslCipher;
  protected $sslVerifyHost;
  function set_certFile($value){
    $this->certFile = $value;
  }
  function get_certFile(){
    return $this->certFile;
  }
  function set_keyFile($value){
    $this->keyFile = $value;
  }
  function get_keyFile(){
    return $this->keyFile;
  }
  function set_authUserId($value){
    $this->authUserId = $value;
  }
  function get_authUserId(){
    return $this->authUserId;
  }
  function set_authPassword($value){
    $this->authPassword = $value;
  }
  function get_authPassword(){
    return $this->authPassword;
  }
  function set_authPassPhrase($value){
    $this->authPassPhrase = $value;
  }
  function get_authPassPhrase(){
    return $this->authPassPhrase;
  }
  function set_data($array){
    $this->data = $array;
  }
  function get_data(){
    return $this->data;
  }
  function set_API_URL($value){
    $this->API_URL = $value;
  }
  function get_API_URL(){
    return $this->API_URL;
  }
  function set_authNonce($secret, $chars, $seconds=60, $delimitar="-"){    
    require_once("NonceUtil.php");
    $this->authNonce = customNonce::generate( $secret, $chars, $seconds, $delimitar);
  }
  function get_authNonce(){
    return $this->authNonce;
  }
  function set_passwordDigest(){
    $this->passwordDigest = hash('sha256', $this->get_authPassword() .  ":" . $this->get_authNonce() . ":" . time());
  }
  function get_passwordDigest(){
    return $this->passwordDigest;
  }
  function set_contentType($value = "application/xml"){
    //“text/plain”, “application/xml”, “text/html”, “application/json”, “image/gif”, and “image/jpeg”
    $this->contentType = $value;
  }
  function get_contentType(){
    return $this->contentType;
  }
  function set_contentLength(){
    $content = json_encode($this->get_data());
    $this->contentLength = strlen($content);
  }
  function get_contentLength(){
    return $this->contentLength;
  }
  function set_modeSSL($value = FALSE){
    $this->modeSSL = $value;
  }
  function get_modeSSL(){
    return $this->modeSSL;
  }
  function set_encoding($value = "UTF-8"){
    $this->encoding = $value;
  }
  function get_encoding(){
    return $this->encoding;
  }
  function set_apiHeaders($array){
    if(count($array) == 0){
      if($this->get_contentType() != NULL){
        $headers[] = "Content-type: " . $this->get_contentType();
      }
      if($this->get_contentLength() != NULL){
        $headers[] = "Content-length: " . $this->get_contentLenght();
      }
      if($this->get_authUserId() != NULL){
        $headers[] = "X-Auth-Username: " . $this->get_authUserId();
      }
      if($this->get_authNonce() != NULL){
        $headers[] = "X-Auth-Timestamp: " . time();
        $headers[] = "X-Auth-Nonce: " . $this->get_authNonce();
      }
      if($this->get_passwordDigest() != NULL){
        $headers[] = "X-Auth-PasswordDigest: " . $this->get_passwordDigest();
      }
      $headers[] = "Connection: close";

      $this->apiHeaders = $headers;

   }else {
     $this->apiHeaders = $array;
   }
  }
  function get_apiHeaders(){
    return $this->apiHeaders;
  }
  function set_sslVersion($value=4){
    $this->sslVersion = $value;
  }
  function get_sslVersion(){
    return $this->sslVersion;
  }
  function set_sslCipher($value = "SSLv3"){
    $this->sslCipher = $value;
  }
  function get_sslCipher(){
    return $this->sslCipher;
  }
  function set_sslVerifyHost($value=2){
    $this->$sslVerifyHost = $value;
  }
  function get_sslVerifyHost(){
    return $this->sslVerifyHost;
  }
  function apiConnector($apiData, $apiURL, $apiContentType, $defaultSSL = FALSE){
    if($defaultSSL != FALSE){
      $this->requireDefaultSSL();
    }
    $this->set_contentType($apiContentType);
    $this->set_modeSSL($defaultSSL);
    $this->set_data($apiData);
    $this->set_API_URL($apiURL);
    $this->set_encoding();
  }
  function requireDefaultSSL(){
    if(!isset(apiConnectorCertificate)){ require_once("api_settings.inc"); }
    $this->set_certFile(apiConnectorCertificate);
    $this->set_keyFile(apiConnectorKey);
    $this->set_authUserId(apiConnectorUserId);
    $this->set_authPassword(apiConnectorPassword);
    $this->set_authPassPhrase(apiConnectorPhrase);
    $this->set_sslCipher();
    $this->set_sslVersion();

    php_enviroment_nonce();
    $this->set_authNonce(NONCE_SECRET, NONCE_CHARS, 60, "-");
    php_enviroment_default();
  }
  function post_to_api($headers = array(), $return_array = TRUE ){
        set_time_limit(0);
        $URL = $this->get_API_URL();
        $post_data = $this->get_data();
        $curl_encoding = $this->get_encoding();
        $curl_obj = curl_init();

        curl_setopt( $curl_obj, CURLOPT_URL, $URL);
        if($this->get_modeSSL() != FALSE){
              $certfile = $this->get_certFile();
              $keyfile =  $this->get_keyFile();
              $Auth_user = $this->get_authUserId();
              $Auth_password = $this->get_authPassword();
              $Auth_phrase = $this->get_authPassPhrase();
              $ssl_version = $this->get_sslVersion();
              $ssl_cipher = $this->get_sslCipher();
              $ssl_verifyHost = $this->get_sslVerifyHost();
              curl_setopt( $curl_obj, CURLOPT_SSLVERSION, $ssl_version);
              curl_setopt( $curl_obj, CURLOPT_SSL_CIPHER_LIST, $ssl_cipher);
              curl_setopt( $curl_obj, CURLOPT_SSL_VERIFYHOST, $ssl_verifyHost);
              curl_setopt( $curl_obj, CURLOPT_SSLCERT, $certfile);
              curl_setopt( $curl_obj, CURLOPT_SSLKEY, $keyfile);
              curl_setopt( $curl_obj, CURLOPT_SSLKEYPASSWD, $Auth_phrase);
              curl_setopt( $curl_obj, CURLOPT_USERPWD, $Auth_user . ":" . $Auth_password );
       }

       if($this->get_encoding() != NULL){
            curl_setopt( $curl_obj, CURLOPT_ENCODING, $this->get_encoding());
        }

        curl_setopt( $curl_obj, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl_obj, CURLOPT_CONNECTTIMEOUT, 0 );
        curl_setopt( $curl_obj, CURLOPT_TIMEOUT, 500 );

        if(count($post_data) > 0){
            curl_setopt( $curl_obj, CURLOPT_POST, true );
            curl_setopt( $curl_obj, CURLOPT_POSTFIELDS, $post_data);
        }
        if(count($headers) > 0){ curl_setopt( $curl_obj, CURLOPT_HTTPHEADER, $headers ); }

        $response = curl_exec( $curl_obj );
          //check for errors
          if(curl_errno( $curl_obj)){
            //get the cURL error and message
            $data = array("Error Message" =>  "CURL ERROR " . curl_error( $curl_obj ) . " Code: " . curl_errno( $curl_obj ));
          }
          else
          {
              //check the HTTP status codes
              $statusCode = (int)curl_getinfo( $curl_obj, CURLINFO_HTTP_CODE);
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
            //On fail close curl and send HTTP error
              curl_close($curl_obj);
              return $data;
          }else{
              $obj = ($this->get_contentType() == "application/xml") ? simplexml_load_string($response) : $response;
              if($return_array == true){
                  //send data array
                  $data = json_decode(json_encode($obj), true);
                }else{
                  $data = json_encode($obj);
              }
          }

          //On success close curl and send api data
          curl_close($curl_obj);
          return $data;

  }

}

?>
