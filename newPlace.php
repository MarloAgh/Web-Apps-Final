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
	<form name="userinfo" method="post" onsubmit="return validateAdd();" action="action.php" >
	
		<script type="text/javascript"> 
		
			function validateAdd() { 					
				var validPlace = validatePlace();
				var validLocation = validateLocation();
				var validDate = validateDate();
				var validRating = validateRating();
				var validPrice = validatePrice();
				var validComments = validateComments();

				if (validPlace && validLocation && validDate && validRating && validPrice && validComments)
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
			
			
			function validateDate() {
				var error = document.getElementById("errorDate");
				var enteredDate = document.userinfo.date;
				var regex = /^\d{4}-\d{2}-\d{2}$/;
	
				if (!regex.test(enteredDate.value)) {
					error.innerHTML = "Please enter a date in the format YYYY-MM-DD";
					return false;
				} 
				//error.innerHTML = "validated";
				return true;
			}

			
			function validateRating() {
				var error = document.getElementById("errorRating");
				var menu = document.getElementById("rating");
				if (menu.selectedIndex == 0) {
					error.innerHTML = "Please select a rating";
					return false;
				}
				//error.innerHTML = "validated";
				return true;
			}
			
			
			function validatePrice() {
				var error = document.getElementById("errorPrice");
				var menu = document.getElementById("price");
				if (menu.selectedIndex == 0) {
					error.innerHTML = "Please select a price range";
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
		
		<b>Date:</b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="date" placeholder="Ex. 2015-03-01" size="40" /> &nbsp;&nbsp;&nbsp;&nbsp;
		<span id="errorDate"></span>
		<br><br>
		
		<b>Rating:</b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;
		<select id="rating" name="starRating">
			<option value="0" >Select a rating </option>
			<option value="*">* </option>
			<option value="**">**  </option>
			<option value="***" >***	</option>
			<option value="****" >****	</option>
			<option value="*****" >*****	</option>
		</select> &nbsp;&nbsp;&nbsp;&nbsp;
		<span id="errorRating"></span>
		<br><br>
		
		<b>Price:</b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select id="price" name="priceRating">
			<option value="0" >Select a price </option>
			<option value="$">$ </option>
			<option value="$$">$$ </option>
			<option value="$$$" >$$$ </option>
		</select> &nbsp;&nbsp;&nbsp;&nbsp;
		<span id="errorPrice"></span>
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