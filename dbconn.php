<?php

function connectToDB($dbname) {														// Connect to the database.
	$dbc= @mysqli_connect("localhost", "aghazari", "QdVdV2TD", $dbname) or
					die("Connect failed: ". mysqli_connect_error());
	return $dbc;
}



function disconnectFromDB($dbc) {													// Disconnect from the database.
	mysqli_close($dbc);
}



function performQuery($dbc, $query) {												// Query the database.
	//echo "My query is >$query< <br>";
	$result = mysqli_query($dbc, $query) or die("bad query".mysqli_error($dbc));
	return $result;
}



function displayVacationsTable($dbc, $username) {
	$query = "select place_visited, date, rating, price_range, comment from ".$username." where type='trip'";
	$result = performQuery($dbc, $query);
	?>

	<table>
		<tr>
			<th>Place</th>
			<th>Date</th>
			<th>Rating</th>
			<th>Price</th>
			<th>Comments</th>			
		</tr>
	
	<?php
	$color = "#FFF3C2";
	while ( @extract(mysqli_fetch_array($result, MYSQLI_ASSOC)) ) {
		echo "<tr>									
			<td>$place_visited</td>
			<td>$date</td>
			<td>$rating</td>
			<td>$price_range</td>
			<td>$comment</td>
		</tr>\n";	
	}
	?>
	</table>
	<?php
		mysqli_free_result($result);
}



function displayDreamTable($dbc, $username) {
	$query = "select place_visited, comment from ".$username." where type='dreamtrip'";
	$result = performQuery($dbc, $query);
	?>

	<table>
		<tr>
			<th>Place</th>
			<th>Comments</th>			
		</tr>
	
	<?php
	$color = "#FFF3C2";
	while ( @extract(mysqli_fetch_array($result, MYSQLI_ASSOC)) ) {
		echo "<tr>									
			<td>$place_visited</td>
			<td>$comment</td>
		</tr>\n";	
	}
	?>
	</table>
	<?php
		mysqli_free_result($result);
}



function generateLatAndLong($address) {

   		$geocodeURL = "https://maps.googleapis.com/maps/api/geocode/xml?";
   		$address = "address=" . urlencode($address);
   		// https://console.developers.google.com
   		$key = "key=AIzaSyClsDwDA5jZduZMKc-7a89_G5T2s8UNi6U";
   		$geocoderequest = "$geocodeURL$address" . "&" . $key;
   		
   		//die( "The url is >" . $geocoderequest . "<" );
   		
   		$xml= new SimpleXMLElement( file_get_contents( $geocoderequest ) );
   		
   		if($xml->status != 'OK') {
   			$status = $xml->error_message;
   			die("bad result status $status");
   		}

		$placeRequestURL = "https://maps.googleapis.com/maps/api/place/details/xml?";
   		//$key = "key=AIzaSyAsAWbQ0_nFCSoOwOwVP9JYroJ12JI0xOE";
   		$placeID = "placeid=" . $xml->place_id;
   		$placedetailsrequest = "$placeRequestURL$placeID" . "&" . $key;
   		
   		$xml2 = new SimpleXMLElement( file_get_contents( $geocoderequest ) );
   		
   		if($xml2->status != 'OK') {
   			$status = $xml->error_message;
   			die("bad result status $status");
   		}
   		
		$latitude  = $xml->result->geometry->location->lat;
        $longitude = $xml->result->geometry->location->lng;
        
        $location = array("latitude" => $latitude, "longitude" => $longitude);
        
        return ($location);

}


?>