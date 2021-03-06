<!DOCTYPE html>
<html lang="en">

<?php
	include('dbconn.php');
?>



<head>
	<meta charset="utf-8" />
	<title>Wanderlust</title>
		<link rel="stylesheet" type="text/css" href="defaultTheme.css" />
	<style>
	fieldset {text-align: center; float: center; background-color: black; color: white; padding:5px;    width:670px;    line-height:1.0;    margin: 0 auto;}
	h2 {background-color: black; color: white; padding:5px;    width:1100px;    line-height:1.0;    margin: 0 auto;}
	</style>
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
		
		function load() {
		  var map = new google.maps.Map(document.getElementById("map-canvas"), {
			center: new google.maps.LatLng(23.025815, -1.406250),
			zoom: 2
		    
		    });
		  map.setMapTypeId(google.maps.MapTypeId.HYBRID);
		  
		  var infoWindow = new google.maps.InfoWindow;

		  // Change this depending on the name of your PHP file
		  
		  var username = <?php echo json_encode($_GET['username']); ?>;
		  var url = "http://cscilab.bc.edu/~aghazari/Wanderlust/turnToXML.php?username="+username;
		  
		  var showPosition = function (position) {
    			var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    			// Do whatever you want with userLatLng.
    			var marker = new google.maps.Marker({
        		position: userLatLng,
        		title: 'Your Location',
        		map: map,
        		icon: 'redmarker.png'
    		});
			}
		  
		
		  downloadUrl(url, function(data) {
			var xml = data.responseXML;
			var markers = xml.documentElement.getElementsByTagName("marker");
			for (var i = 0; i < markers.length; i++) {
			  var name = markers[i].getAttribute("place_visited");
			  var date = markers[i].getAttribute("date");
			  var rating = markers[i].getAttribute("rating");
			  var point = new google.maps.LatLng(
				  parseFloat(markers[i].getAttribute("lat")),
				  parseFloat(markers[i].getAttribute("lng")));
			  var type = markers[i].getAttribute("type");
			  if (type == "trip") {
			  		var html = "<b>" + name + "</b> <br/>" + date;
					var marker = new google.maps.Marker({
					map: map,
					position: point,
					icon: 'yellowmarker.png'
				  });
			  }
			  
			  else {
			  		var html = "<b>" + name + "</b> <br/> Someday!";
			  		var marker = new google.maps.Marker({
					map: map,
					position: point,
					icon: 'orangemarker.png'
				  });
			  } 			  
			  
			  bindInfoWindow(marker, map, infoWindow, html);
			}
		  });
		  
		  navigator.geolocation.getCurrentPosition(showPosition); 
		}


		function bindInfoWindow(marker, map, infoWindow, html) {
		  google.maps.event.addListener(marker, 'click', function() {
			infoWindow.setContent(html);
			infoWindow.open(map, marker);
		  });
		}

		
		function downloadUrl(url, callback) {
		  var request = window.ActiveXObject ?
			  new ActiveXObject('Microsoft.XMLHTTP') :
			  new XMLHttpRequest;

		  request.onreadystatechange = function() {
			if (request.readyState == 4) {
			  request.onreadystatechange = doNothing;
			  callback(request, request.status);
			}
		  };

		  request.open('GET', url, true);
		  request.send(null);
		}

		function doNothing() {}

		//]]>

  </script>

	
</head>



<body onload="load()">
	<h1>WANDERLUST</h1> 
<?php
$link = "http://cscilab.bc.edu/~aghazari/Wanderlust/travelinspo.php?username=".$_GET['username'];
?>
	<h2>(n.) a strong desire or urge to explore the land and cultures of the earth</h2>
	<form method="get" action="<?php echo $link ?>">
	<br>
	<input type="hidden" name="username" value="<?php echo $_GET['username'] ?>">
	<input type="submit" value="Needing Some Travel Inspiration">
	</form>
	<br>
	<div id='map-canvas' class='map-canvas'></div>
	<br>
	<fieldset>
	yellow = visited
	|
	red = current location
	|
	orange = dreams
	</fieldset>
	<br>
		<form method="post">
			<input type="submit" name="myVacations" value="My Vacations" /> 
			<input type="submit" name="dreamVacations" value="Dream Vacations" />
		</form>
		
		<br>
		
		<?php
		
			$dbc = connectToDB("aghazari");
			
			$username = $_GET['username'];
			//$username = "shannonspecht";
			
			$tablequery = "create table if not exists " . $username . 
						  " (date date, latitude float, longitude float, place_visited text, 
						    rating enum('*', '**', '***', '****', '*****'), comment text, 
						    price_range enum('$', '$$', '$$$'), type enum('trip', 'dreamtrip')) ";
			$result = performQuery($dbc, $tablequery);
			
			if (isset($_POST['myVacations'])) {
				displayVacationsTable($dbc, $username);
				echo "<br><br>";				
				displayRegularModifyForm();
			}
				
			if (isset($_POST['dreamVacations'])) {
				displayDreamTable($dbc, $username);
				echo "<br><br>";		
				displayDreamModifyForm();
				
			}
			
		?>
	
	<br><br>
	<form action="http://cscilab.bc.edu/~aghazari/Wanderlust/wanderlusthome.php">
	<input type="submit" value="Log Off" />
	</form>
</body>


</html>


<?php

function displayRegularModifyForm() {
	?>
	<form method="get" action="newPlace.php">
		<input type="hidden" name="username" value="<?php echo $_GET['username'] ?>" />
		<input type="submit" name="add" value="Add New" /> 
	</form>
	
	
	<?php	
}


function displayDreamModifyForm() {
	?>
	<form method="get" action="newDream.php">
		<input type="hidden" name="username" value="<?php echo $_GET['username'] ?>" />
		<input type="submit" name="add" value="Add New" /> 
	</form>
	
	
	<?php	
}



