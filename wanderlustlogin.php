<!DOCTYPE html>

<html lang="en">
<?php 

include('dbconn.php'); 

?>
<head>
     <meta charset="utf-8" />
     <title>Wanderlust Login</title>
<style>

h1 {text-align: center;font-size: 80px}
h2 {text-align: center}
body { background-image: url(wanderlust.jpg); background-size: cover; font-family: courier;}
fieldset {text-align: center; background-image: url(suitcase.jpg); padding:5px;    width:670px;    line-height:3.0;    margin: 0 auto;}

</style>

</head>
<body>
<h1>WANDERLUST</h1> 

<h2>(n.) a strong desire or urge to explore the land and cultures of the earth</h2>


<?php
displayformlogin();
	if (isset ($_POST['login2'] )) {
		handleformlogin();
	} 
	if (isset ($_POST['forgot'] )) {
		displayformforgot();
	} 
	if (isset ($_POST['newpassword'] )) {
		handleformforgot();
	} 

?>

</body>
</html>

<?php
function displayformlogin() {
?>

<form method="post" >
<fieldset>

<b>Username:</b> <input type= "text" name="username" />

<br>
<b>Password:</b> <input type= "password" name="password" />

<br><br>
<input type= "submit" name="login2" value= "Login"/>
<br>
<input type= "submit" name="forgot" value= "Forgot My Password"/>

</fieldset>
</form>

<?php
}

function handleformlogin(){



$dbc = connectToDB( "aghazari" );
	$username = $_POST['username'];
    $password2 = $_POST['password'];
	$password = sha1($password2);	
$selectquery="select * from users where Username='$username' AND Password='$password'";
$result = performQuery($dbc, $selectquery);

if ( mysqli_num_rows( $result ) > 0 ) {
	echo "<script>window.location='http://cscilab.bc.edu/~aghazari/Wanderlust/travelog.php?username=".$username."'</script>"; 
	
}
else {
echo "<fieldset>Username Or Password Are Incorrect. Please Try Again.</fieldset>";


}
}
function displayformforgot() {
?>

<form method="post">
<fieldset>
	<form name="newpassword" method="post">
	Please Enter Your Email: 
	<input type= "text" name="resetemail" />
	<br>
	<input type= "submit" name="newpassword" value= "Reset Password"/>
</fieldset>

</form>
<?php
}
function handleformforgot() {
?>

<fieldset>
<?php

$resetpassword = createpassword();
$resetemail = $_POST['resetemail'];
$enresetpassword = sha1($resetpassword);
$to=$resetemail;
$subject='Wanderlust Password Reset';
$body="Your new password is '$resetpassword'";
$headers = 'From: aghazari@bc.edu';

$dbc = connectToDB( "aghazari" );

$resetemailquery = "select * from users where email='$resetemail'";
$result = performquery ($dbc, $resetemailquery); 
if ( mysqli_num_rows( $result ) == 1 ) {
	$changequery="update users set password='$enresetpassword' where email='$resetemail'";
	$result = performQuery($dbc, $changequery);
	if ( mail($to, $subject, $body, $headers) ) {
	echo " <fieldset>Mail  sent to $resetemail with new password</fieldset>";
	} 
	else { echo "<fieldset>Email Failed. Please try again.<fieldset>";
	}
	}
else { echo "<fieldset>Sorry! This Email Is Not Signed Up With Wanderlust. Please Try Again.</fieldset>";
}

}
?>
</fieldset>

<?php
function createpassword() {
	$password="";
	
	$possible="23456789abcdefghjklmnpwrstuvwxyz";
	
	$password="";
	$length=8;
	
	for ($i=1; $i<=$length; $i++){
		$pick=rand(0, strlen($possible)-1);
		
		// pick a random character from the possible characters
		$passchar=substr($possible, $pick, 1);
		
		$password .= $passchar;
	}
	return $password;
}
?>

