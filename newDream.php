<!DOCTYPE html>
<html lang="en">

<?php
	include('dbconn.php');
?>



<head>
	<meta charset="utf-8" />
	<title>Wanderlust</title>
		<link rel="stylesheet" type="text/css" href="defaultTheme.css" />
	
</head>

<body>
	<?php displayInsertAttractionForm() ?>
	

</body>

<?php

function displayInsertAttractionForm() {
	?>
	<fieldset>
	<form name="userinfo" method="post" onsubmit="return validateAdd();" action="dreamAction.php" >
	
		<script type="text/javascript"> 
		
			function validateAdd() { 					
				var validPlace = validatePlace();
				var validLocation = validateLocation();
				var validRating = validateRating();
				var validComments = validateComments();
				var validPeople = validatePeople();

				if (validPlace && validLocation && validRating && validComments && validPeople)
					return true;

				return false;
			}
			
			
			function validatePlace() {
				var error = document.getElementById("errorPlace");
				var enteredPlace = document.userinfo.place;
	
				if (enteredPlace.value == '') {
					error.innerHTML = "Please enter a place";
					return false;
				} 
				//error.innerHTML = "validated";
				return true;
			}
			
			
			function validateLocation() {
				var error = document.getElementById("errorLocation");
				var enteredLocation = document.userinfo.location;
	
				if (enteredLocation.value == '') {
					error.innerHTML = "Please enter a location";
					return false;
				} 
				//error.innerHTML = "validated";
				return true;
			}
			
			
			function validatePeople() {
				var error = document.getElementById("errorPeople");
				var menu = document.getElementById("people");
				if (menu.selectedIndex == 0) {
					error.innerHTML = "Please select one";
					return false;
				}
				//error.innerHTML = "validated";
				return true;
			}
			
			
			function validateComments() {
				var error = document.getElementById("errorComments");
				var enteredComments = document.userinfo.comments;
	
				if (enteredComments.value == '') {
					error.innerHTML = "Please enter some comments";
					return false;
				} 
				//error.innerHTML = "validated";
				return true;
			}

		</script>
	
		<b>Place:</b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="place" placeholder="Ex. Old North Church" size="40" /> &nbsp;&nbsp;&nbsp;&nbsp;
		<span id="errorPlace"></span>
		<br><br>
		
		<b>Location:</b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="location" placeholder="Ex. Boston, Massachusetts, USA" size="40" /> &nbsp;&nbsp;&nbsp;&nbsp;
		<span id="errorLocation"></span>
		<br><br>

		<b>Who With?:</b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;
		<select id="people" name="people">
			<option value="0" >Select </option>
			<option value="Family">Family </option>
			<option value="Friends">Friends </option>
			<option value="Significant Other" >***	</option>
			<option value="Self" >****	</option>
			<option value="*****" >*****	</option>
		</select> &nbsp;&nbsp;&nbsp;&nbsp;
		<span id="errorPeople"></span>
		<br><br>
		
		<b>Comments:</b><br>
		<textarea rows=10 cols=50 name="comments"></textarea> <br>
		<span id="errorComments"></span>
		<br><br>
		<input type="hidden" name="username" value="<?php echo $_GET['username'] ?>" />
		<input value="Submit info" name="info" type="submit">
		<br><br>
	</form>
	</fieldset>
<?php
}