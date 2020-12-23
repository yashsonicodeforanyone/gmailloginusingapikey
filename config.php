<?php


session_start();

require_once 'vendor/autoload.php';

$google_client = new Google_Client();

// client id 
$google_client->setClientId('673346798185-f2ov9itbg52993jqjtnhgtmuu1o3su3a.apps.googleusercontent.com');

//api scret id  
$google_client->setClientSecret('q7lCkG1D2W6w8aBY1Qy9q2iy');

$google_client->setRedirectUri('http://localhost/task2/sign02in.php');

$google_client->addScope('email');

$google_client->addScope('profile');

?>