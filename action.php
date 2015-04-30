<?php
	include('dbconn.php');

		$place = mysql_real_escape_string($_POST['place']);
		$date = mysql_real_escape_string($_POST['date']);
		$price = mysql_real_escape_string($_POST['priceRating']);
		$rating = mysql_real_escape_string($_POST['starRating']);
		$comments = mysql_real_escape_string($_POST['comments']);
		$username = $_POST['username'];
		
		$location = generateLatAndLong($_POST['location']);
		$lat = $location["latitude"];
		$long = $location["longitude"];
		
		$dbc = connectToDB( "aghazari" );
		$addquery = "insert into ".$username." (date, latitude, longitude, place_visited, rating, comment, price_range, type) 
						 values ('$date','$lat', '$long', '$place', '$rating', '$comments', '$price', 'trip')";
		$add = performQuery($dbc, $addquery);
		
		header('Location: http://cscilab.bc.edu/~aghazari/Wanderlust/travelog.php?username='.$username);
?>


