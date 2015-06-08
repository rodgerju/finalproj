<?php
include 'storedInfo.php';

if (!($_POST == null))
{
	$everythingOk = 1;
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rodgerju-db", $myPassword, "rodgerju-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if(!($stmt = $mysqli->prepare("SELECT username FROM users WHERE username=?"))) 
	{
		echo "Prepare failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$newName = $_POST['name'];
	$stmt->bind_param("s", $newName);
	if (!$stmt->execute()) 
	{
		echo "Execute failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if(!$stmt->bind_result($tableName)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch())
	{
		if($tableName == $newName)
		{
			$everythingOk = 0;
			echo "Signup failed! </br>";
			echo 'Click	<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/finalprojnewuser.php> here </a> to return';
		}
	}
	$stmt->close();
	if($everythingOk == 1)
	{
		if(!($stmt = $mysqli->prepare("INSERT INTO users (username, pword) values (?, ?)"))) 
		{
			echo "Prepare failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		$newPass = $_POST['pword'];
		$newPass = hash('sha256', $newPass); 
		$stmt->bind_param("ss", $newName, $newPass);
		if (!$stmt->execute()) 
		{
			echo "Execute failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		$stmt->close();
		header('Location: http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/finalproj.php');
	}
}
?>