<!DOCTYPE html>

<html lang="en">

<?php 

include('dbconn.php'); 

?>
<head>
     <meta charset="utf-8" />
     <title>Wanderlust Join</title>
<style>

h1 {text-align: center;font-size: 80px}
h2 {text-align: center}
body { background-image: url(wanderlust.jpg); background-size: cover; font-family: courier;}
fieldset {text-align: center; background-image: url(suitcase.jpg); padding:5px;    width:670px;    line-height:3.0;    margin: 0 auto;}
legend {background-color: #8AA1BA}

</style>
<script type="text/javascript">

 function validate(){
			var validName = validatename();
			var validUsername = validateusername();
			var validEmail = validateemail();
			var validPass = validatepassword();
			var valid2pass = validate2password();
			
			if (validName && validUsername && validEmail && validPass && valid2pass)
				return true;
			
			return false;
		}
 function validatename(){
		var named = document.userinfo.name;
		var nameent = named.value;
		var tomatch = /[ ]/;
		if (!tomatch.test(nameent)) {
			var errorreport=document.getElementById("nameerror");
			errorreport.innerHTML = "Please Fill Out Both First and Last Name";
			return false;
		}
		return true;
	}		


 function validateusername(){
		var usernamed = document.userinfo.username;
		var usernameent = usernamed.value;
		var tomatch = /^\w{6,}$/;
		if (!tomatch.test(usernameent)) {
			var errorreport=document.getElementById("usernameerror");
			errorreport.innerHTML = "Username Must Be At Least 6 Characters";
			return false;
		}
		return true;
	}

 function validateemail(){
		var email = document.userinfo.email;
		var emailent = email.value;
		var tomatch = /@/;
		if (!tomatch.test(emailent)) {
			var errorreport=document.getElementById("emailerror");
			errorreport.innerHTML = "Please Provide A Valid Email Address";
			return false;
		}
	
		return true;
	}
	
 function validatepassword(){
		var password = document.userinfo.password;
		var passwordent = password.value;
		var tomatch = /^\w{6,}$/;
		if (!tomatch.test(passwordent)) {
			var errorreport=document.getElementById("passworderror");
			errorreport.innerHTML = "Password Must Be At Least 6 Characters";
			return false;
		}
		return true;
	}

 function validate2password(){
		var password1 = document.userinfo.password;
		var password2 = document.userinfo.confirmedpassword;
		var passwordent = password1.value;
		var passwordent2 = password2.value;

		if (!(passwordent == passwordent2)) {
			var errorreport=document.getElementById("password2error");
			errorreport.innerHTML = "Make Sure Both Of Your Passwords Match!";
			return false;
		}
		
		return true;
	}

</script>
</head>
<body>
<h1>WANDERLUST</h1> 

<h2>(n.) a strong desire or urge to explore the land and cultures of the earth</h2>

<?php


displayformjoin();
if (isset ($_POST['join2'] )) {
		handleformjoin();
	}

?>



</body>
</html>


<?php

function displayformjoin() {

?>

<br>
<form name="userinfo" method="post" onsubmit="return validate();">
<fieldset>

<legend>Please Fill Out The Following Fields</legend>

<b>Name:</b> <input type= "text" name="name" />
<span style="color:maroon" class="ereport" id="nameerror"></span>
<br><br>
<b>Username:</b> <input type= "text" name="username" />
<span style="color:maroon" class="ereport" id="usernameerror"></span>
<br><br>
<b>Password:</b> <input type= "password" name="password" />
<span style="color:maroon" class="ereport" id="passworderror"></span>
<br><br>
<b>Confirm Password:</b> <input type= "password" name="confirmedpassword" />
<span style="color:maroon" class="ereport" id="password2error"></span>
<br><br>
<b>Email:</b> <input type= "text" name="email" />
<span style="color:maroon" class="ereport" id="emailerror"></span>
<br><br>
<input style="color:maroon" type= "submit" name="join2" value= "Join!"/>
</fieldset>
</form>

<?php
}

function handleformjoin() {
 $password = sha1($_POST["password"]);
 $confirmedpassword = sha1($_POST["confirmedpassword"]);

$dbc = connectToDB( "aghazari" );
	
		$name = mysql_real_escape_string ( $_POST['name']);
		$username = mysql_real_escape_string ( $_POST['username']);
		$email = mysql_real_escape_string ( $_POST['email']);
		$grabquery = "select * from users where username='$username'";
		$grabresult = performQuery($dbc, $grabquery);
		
if ( mysqli_num_rows( $grabresult ) == 0 ) {
	$insertquery="insert into users (Name, Username, Password, Email) values ('$name', '$username', '$password', '$email')";
	$result = performQuery($dbc, $insertquery);
	
	echo "<fieldset>Success! <a href='http://cscilab.bc.edu/~aghazari/Wanderlust/wanderlusthome.php'>Back To Home</a></fieldset>";
	}
else echo "<fieldset>Uh Oh! This Username Is Already In Our System...Please Try Another!
<br><br> <a href='http://cscilab.bc.edu/~aghazari/Wanderlust/join.php'>Try Again</a></fieldset>"
;

}


