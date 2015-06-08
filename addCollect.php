<?php
include 'storedInfo.php';
session_start();
if(!isset($_SESSION['username']))
{
	header('Location: http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/finalproj.php');
}
if (!($_POST == null))
{
	$everythingOk = 1;
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rodgerju-db", $myPassword, "rodgerju-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if(!($stmt = $mysqli->prepare("INSERT INTO Collection (card_name, player_username) VALUES  (?, ?)"))) 
	{
		echo "Prepare failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$newUser = $_SESSION['username'];
	$newCard = $_POST['id'];
	$stmt->bind_param("ss", $newCard ,$newUser);
	if($stmt->execute())
	{
		$stmt->close();
		header('Location: http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/main.php');
	}
	

	$stmt->close();
	echo "Failed! </br>";
	echo 'Click	<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/main.php> here </a> to return';
}
?>