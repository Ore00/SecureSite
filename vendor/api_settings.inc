<?php

//Key should include the path to the key file, if the api doesn't require it, leave the value as null to exclude
define("apiConnectorKey", NULL);
//Certificate should include the path to the certificate file, if the api doesn't require it, leave the value as null to exclude
define("apiConnectorCertificate", NULL);
// if the API requires a Username, set this value, else leave it as null
define("apiConnectorUserId", NULL);
// if the API requires a Password associated with username, set this value, else leave it as null
define("apiConnectorPassword", NULL);
// if the API requires a Pass Phrase, set this value, else leave it as null
define("apiConnectorPhrase", NULL);

// if using the required default SSL method , set the Nonce Secret value, else leave it as null
define("NONCE_SECRET", NULL);
// if using the required default SSL method , set the Nonce Chars value, else leave it as null
define("NONCE_CHARS", NULL);


 ?>
