<?php


session_start();

require_once 'vendor/autoload.php';

$google_client = new Google_Client();

// client id 
$google_client->setClientId('Enter client id for gmail');

//api scret id  
$google_client->setClientSecret('Enter the scret id for gmail');

$google_client->setRedirectUri('http://localhost/task2/sign02in.php');

$google_client->addScope('email');

$google_client->addScope('profile');

?>