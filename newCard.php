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
	if(!($stmt = $mysqli->prepare("INSERT INTO magiccard (name, rarity, cset, manacost, value) VALUES  (?, ?, ?, ?, ?)"))) 
	{
		echo "Prepare failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$newName = $_POST['name'];
	$newRarity = $_POST['rare'];
	$newSet = $_POST['set'];
	$newMana = $_POST['mana'];
	$newValue = $_POST['value'];
	
	$stmt->bind_param("sssid", $newName, $newRarity, $newSet, $newMana, $newValue);
	if($stmt->execute())
	{
		$stmt->close();
		header('Location: http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/main.php');
	}
	

	$stmt->close();
	echo "Signin failed! </br>";
	echo 'Click	<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/main.php> here </a> to return';
}
?>