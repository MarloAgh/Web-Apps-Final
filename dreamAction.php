<?php
	include('dbconn.php');

		$place = mysql_real_escape_string($_POST['place']);
		$comments = mysql_real_escape_string($_POST['comments']);
		$username = $_POST['username'];
		
		$location = generateLatAndLong($_POST['location']);
		$lat = $location["latitude"];
		$long = $location["longitude"];
		
		$dbc = connectToDB( "aghazari" );
		$addquery = "insert into ". $username ." (latitude, longitude, place_visited, comment, type) 
						 values ('$lat', '$long', '$place', '$comments', 'dreamtrip')";
		$add = performQuery($dbc, $addquery);
		
		header('Location: http://cscilab.bc.edu/~aghazari/Wanderlust/travelog.php?username='.$username);
?>


