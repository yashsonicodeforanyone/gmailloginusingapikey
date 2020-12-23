<?php




include('config.php');

$login_button = '';

$conn = (mysqli_connect("localhost", "root", "", "task2"));

//                           this is session for logout
if(isset($_SESSION['logout'])){
    
session_destroy();
header('location:index.php');
}



//                                check set a code with get method
if (isset($_GET["code"])) {
 
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);


        $_SESSION['access_token'] = $token['access_token'];
        // echo $_SESSION['access_token'];
    

        $google_service = new Google_Service_Oauth2($google_client);


        $data = $google_service->userinfo->get();
        // print_r($data);


//                                     take  name
        if (!empty($data['given_name'])) {

            $_SESSION['user_first_name'] = $data['given_name'];
            // echo $_SESSION['user_first_name'];
        }
        
        //                             
        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
            // echo $_SESSION['user_last_name'];
        }
        
        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
            // echo $_SESSION['email'];
        }
    }
}



                
if (!isset($_SESSION['access_token'])) {

    $login_button= $google_client->createAuthUrl();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <head>
<link rel="stylesheet" href="index.css" type="text/css">

</head>

<body>


<?php


if (!$login_button == '') {
    


?>

       <div class="container">
       <form>
            <h1>Welcome to login System</h1>
            <button> <a href="<?php echo $login_button ?> ">Login with google</a></button>
            </form>
    </div>
<?php
            $random=bin2hex(random_bytes(15));
            echo $random; 


} else {
            
    $firstname = $_SESSION['user_first_name'];
    $lastname = $_SESSION['user_last_name'];
    $email =  $_SESSION['user_email_address'];
    $name = $firstname . ' ' . $lastname;
 
    

    $q = "INSERT INTO `email`(`name`, `email`) VALUES ('$name','$email')";
    $done = mysqli_query($conn, $q);
    
    if ($done) {
        ?>

        <div class="container">
        <form >
             <h1>Your are successful login</h1>
             <h3> User Name :) <?php echo  $name ?> </h3><br>
             <h3> Gmail :) <?php echo   $email ?></h3><br>
             <?php      $_SESSION['logout']= $name ?>
            <h2> <a href="index.php">Go to logout</a></h2>   
            

          
             </form>
     </div>
     
   
     
   <?php 

    }
}

?>

</body>

</html>


