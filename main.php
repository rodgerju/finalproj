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
		<title>Main</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="outer-content">
		</div>
		<div class = "inner-content">
			<table>
				<tr><td> Card Name </td><td> Rarity </td><td> Card Set </td><td> Mana Cost </td> <td> Dollar Value </td><td> Collection</tr>
				<?php
					$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "rodgerju-db", $myPassword, "rodgerju-db");
					if(!($stmt = $mysqli->prepare("SELECT c.name, c.rarity, c.cset, c.manacost, c.value FROM magiccard c")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($cName, $cRarity, $cSet, $cMana, $cVal)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch())
					{
						echo "<tr><td>" . $cName . "</td><td>" . $cRarity . "</td><td>" . $cSet . "</td><td>" . $cMana . "</td><td>" . $cVal . "</td>";
						echo '<td> <form method="post" action ="http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/addCollect.php">';
						echo "<button> Add to Collection </button><input type='hidden' name='id' value='" . $cName . "'></form></td>";
					}
					$stmt->close();
				?>
	</table>
		</div>

		<div class="inner-content">
				<form method="post" action="http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/newCard.php">
				<fieldset>
				<legend>New Card</legend>
					<p><input type="text" name="name" required="required"/> Card Name</p>
					<p><input type="text" name="rare" required="required"/> Rarity</p>
					<p><input type="text" name="set" required="required"/> Set</p>
					<p><input type="number" name="mana" required="required" min="0"/> Mana Cost</p>
					<p><input type="number" name="value" required="required" min="0" step="any"/> Value </p>

					<p></br><input type="submit" value="Submit"/></p>
		</fieldset>
	</form>
		<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/viewCollection.php> View Collection </a></br>
		<a href=http://web.engr.oregonstate.edu/~rodgerju/cs290/finalproj/logout.php> Log Out </a>
		</div>
		<div class="outer-content">
		</div>
	</body>
</html>