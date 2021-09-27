<?php
//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('748799551650-cbiusdhugqosh5d7u9n1qtqh18psh3he.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('st3w3z5hq1phfqLNSjBzZCIj');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/aroma/signup.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?> 