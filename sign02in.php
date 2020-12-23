<?php


include('config.php');

$login_button = '';

$conn = (mysqli_connect("localhost", "root", "", "task2"));





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


if ($login_button == '') {

    $random=random_bytes(15);        
    $firstname = $_SESSION['user_first_name'];
    $lastname = $_SESSION['user_last_name'];
    $email =  $_SESSION['user_email_address'];
	$name = $firstname . ' ' . $lastname;
	
	$token=bin2hex(random_bytes(15));
	// echo $random; 
 
	$select="SELECT * FROM `email` WHERE `email`='$email'";
	$fire=mysqli_query($conn,$select);
	$row=mysqli_num_rows($fire);
	
	if($row>0){
		$data=mysqli_fetch_assoc($fire);
		$gettoken=$data['token'];
		$update="UPDATE `email` SET `token`='$token',`name`='$name',`email`='$email' WHERE `token`='$gettoken'";
		$updatequery=mysqli_query($conn,$update);
		if($updatequery){
			$_SESSION['token']=$token;
			$_SESSION['email']=$email;
			header("Location:done.php");

		}
	}else{

	

    $insert = "INSERT INTO `email`(`token`,`name`, `email`) VALUES ('$token','$name','$email')";
    $insertquery = mysqli_query($conn, $insert);
    
    if ($insertquery) {
		$_SESSION['token']=$token;
		$_SESSION['email']=$email;
		header("Location:done.php");
	}
 
}
}
?>












<html>
<head>	
	<title>Capital Exchange - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="NOT_DECIDED.png" alt="IMG">
				</div>
				<form class="login100-form validate-form"  action='' method="post">
				<a class="creat_cont" href="">
							Create your Account
						</a>
					<span class="login100-form-title" style="line-height: 0.5;">
						Login <br><br>
					
			
					</span>
							
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="email" name="user_id" placeholder="Email" autocomplete="off"	id="user_name" onkeyup="validate()">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password" id="upassword" onkeyup="validate()">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="login"  id="btn-login" onclick="logedin()" disabled="true">
							Login
						</button>
					<h4 style="padding-top:20px;">-------------or-------------</h4>
					</div>
				
				
					<div class="container-login100-form-btn">
					<button class="login100-form-btn" disabled="true" style="background-image:linear-gradient(to top,red,lightgreen); font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> <a href="<?php echo $login_button ?> "  style="text-decoration: none; color:white; ">Login with google</a></button></div>


				
					<div class="text-center p-t-136">
						<a class="txt2" href="abhianahai">
							Forgot Password
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
<!--============================================form validation file===================================================-->
		<script src="js/form_validation.js"> </script>	<!--form walidation-->
		
		
<script>

 function logedin(){
	document.getElementById('btn-login').innerHTML = "Logged in";
	setTimeout(()=>{},1200);
 }
  function submited(){
	  
	document.getElementById('btn-submit').innerHTML = "Submited";
	setTimeout(()=>{},1200);
 }
</script>

</body>
</html>
						
							