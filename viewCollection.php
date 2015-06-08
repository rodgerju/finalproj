<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/HTML');
include 'storedInfo.php';
session_start();
if(!isset($_SESSION['username']))
{
	header('Location: http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/finalproj.php');
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
		<title>Collection</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="outer-content">
		</div>
		<div class = "inner-content">
			<table>
				<tr><td> Card Name </td><td> Rarity </td><td> Card Set </td><td> Mana Cost </td> <td> Dollar Value </td>
				<?php
					$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rodgerju-db", $myPassword, "rodgerju-db");
					if(!($stmt = $mysqli->prepare("SELECT c.name, c.rarity, c.cset, c.manacost, c.value FROM magiccard c
												   INNER JOIN Collection col ON c.name = col.card_name
												   WHERE col.player_username = ?")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					$newUser = $_SESSION['username'];
					$stmt->bind_param("s", $newUser);
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($cName, $cRarity, $cSet, $cMana, $cVal)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch())
					{
						echo "<tr><td>" . $cName . "</td><td>" . $cRarity . "</td><td>" . $cSet . "</td><td>" . $cMana . "</td><td>" . $cVal . "</td>";
					}
					$stmt->close();
				?>
	</table>
		<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/main.php> Main Menu </a></br>
		<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/logout.php> Log Out </a>
		</div>
		<div class="outer-content">
		</div>
	</body>
</html>