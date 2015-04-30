<?php
include("dbconn.php");

function parseToXML($htmlStr) { 
	$xmlStr=str_replace('<','&lt;',$htmlStr); 
	$xmlStr=str_replace('>','&gt;',$xmlStr); 
	$xmlStr=str_replace('"','&quot;',$xmlStr); 
	$xmlStr=str_replace("'",'&apos;',$xmlStr); 
	$xmlStr=str_replace("&",'&amp;',$xmlStr); 
	return $xmlStr; 
} 

$username = $_GET['username'];
//$username = "shannonspecht";

// Select all the rows in the markers table
$query = "SELECT * FROM ".$username;
$dbc = connectToDB("aghazari");
$result = performQuery($dbc, $query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ( @extract(mysqli_fetch_array($result, MYSQLI_ASSOC)) ) {
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'place_visited="' . parseToXML($place_visited) . '" ';
  echo 'date="' . parseToXML($date) . '" ';
  echo 'lat="' . $latitude . '" ';
  echo 'lng="' . $longitude . '" ';
  echo 'rating="' . $rating . '" ';
  echo 'type="' . $type . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>