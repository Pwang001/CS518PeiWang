<?php
require_once "global.php";
$page_title = "Email Confirmation";
//require_once "header.php";

	if (isset($_GET["u"])) {
		$uid = $_GET["u"];   /*uid cfcode pairs*/
		$confirmCode = $_GET["c"];
		if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
			echo"Could not connect to database";
		elseif (!(@ mysqli_select_db($connection, $dbname)))
			echo "Could not select the database";
		else {
			$query = "SELECT * FROM wp_users WHERE userid={$uid} AND confirmcode='{$confirmCode}'";
			$result = @ mysqli_query($connection, $query);
			$num = mysqli_num_rows($result);
			if ($num != 0) {
				$query = "UPDATE wp_users SET active='Y' WHERE userid={$uid}";
				$result = @ mysqli_query($connection, $query);
				echo "Your account is activated!<br><br>Go to <a href=\"login.php\">Login</a>";
			}
		}
	}
	echo "";
?>