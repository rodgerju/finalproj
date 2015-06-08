<?php
include 'storedInfo.php';

if (!($_POST == null))
{
	$everythingOk = 1;
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rodgerju-db", $myPassword, "rodgerju-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if(!($stmt = $mysqli->prepare("SELECT username, pword FROM users WHERE username=?"))) 
	{
		echo "Prepare failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$newName = $_POST['name'];
	$newPass = $_POST['pword'];
	$newPass = hash('sha256', $newPass); 
	$stmt->bind_param("s", $newName);
	if (!$stmt->execute()) 
	{
		echo "Execute failed: (". $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if(!$stmt->bind_result($tableName, $tablePword)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch())
	{
		if($tableName == $newName)
		{
			if($tablePword == $newPass)
			{
				session_start();
				$_SESSION['username'] = $newName;
				header('Location: http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/main.php');
			}
		}
	}
	$stmt->close();
	echo "Signin failed! </br>";
	echo 'Click	<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/finalproj.php> here </a> to return';
}
?>