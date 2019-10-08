<?php ob_start();
require_once "global.php";
$page_title = "Login";
require_once "header.php";

if (!isset($_SESSION["loginid"]))
	printErrorString("You have logged out. Thank you!");
else {
	$uid = $_SESSION["loginid"];
	/*
	if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
		echo"Could not connect to database";
	elseif (!(@ mysqli_select_db($connection, $dbname)))
		echo "Could not select the database";
	else {
		if ($_SESSION["logintype"] >= 5) {
			$uid2 = $_SESSION["loginid2"];
			if (empty($uid2))
				$query = "UPDATE wx_customers SET conline=0,clogoutime={$TZ_now} WHERE cid={$uid}";
			else
				$query = "UPDATE wx_customers2 SET conline=0,clogoutime={$TZ_now} WHERE cid2={$uid2}";
		} else {
			$query = "UPDATE wx_employee SET eonline=0,elogoutime={$TZ_now} WHERE eid={$uid}";
		}
		$result = @ mysqli_query ($connection, $query);
	}*/
	unset($_SESSION["loginid"]);
	unset($_SESSION["loginname"]);
	header("Location: index.php");
}

?>
<?php
require_once "footer.php";
?>