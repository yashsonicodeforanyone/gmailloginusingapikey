<?php
session_start();


if(isset($_SESSION['token'])  && isset($_SESSION['email'])){

    $email=$_SESSION['email'];
    $token=$_SESSION['token'];
    
    
    $_SESSION['logout.php']=$token;


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .box{
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="box">
    <h1>hello <?php echo $email ?> welcome to Session </h1>
<button style="padding:10px 20px 10px 20px; border-radius:20px; " ><a href="<?php echo $_SERVER['PHP_SELF']; ?>?token=<?php echo $token; ?>" style="text-decoration:none; font-size:large;">Click here to logout</a></button>
    </div>
</body>
</html>



<?php

}


if(isset($_GET['token'])){
    
    
    session_destroy();

    header('location:sign02in.php');

}



?>