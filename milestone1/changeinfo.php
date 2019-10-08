<?php ob_start();
require_once "global.php";
$page_title = "Change Information";
require_once "header.php";

$lname = "";
if (isset($_POST["lname"]))
	$lname = $_POST["lname"];
$fname = "";
if (isset($_POST["fname"]))
	$fname = $_POST["fname"];

?>
	<div id="content" align="center">
	<form name="infoform" action="changeinfo.php" method="post">
    <table width="400" border="0" align="center">
	    <tr height="150"><td colspan="2">&nbsp;</td></tr>
	    <tr><td colspan="2"><b>Change Your Information:</b></td></tr>
	    <tr><td width="80">Last Name:</td><td><input type="text" name="lname" size="30" value="<?php echo $lname ?>" /></td></tr>
		<tr><td>First Name:</td><td><input type="text" name="fname" size="30" value="<?php echo $fname ?>" /></td></tr>
		<tr><td colspan="2" height="12"></td></tr>
		<tr><td></td><td><input type="submit" name="submit" value="Change" /></td></tr>
	  </td>
	  </tr>	
	 
	  <tr><td style="color:red" colspan="2"><br>
	  <?php
	    if (isset($_POST["lname"]))
		{
			if (empty($lname))
				echo "Last Name is not entered!";
			elseif (empty($fname))
				echo "First Name is not entered!";
			else {
				if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
					echo"Could not connect to database";
				elseif (!(@ mysqli_select_db($connection, $dbname)))
					echo "Could not select the database";
				else {
					$uid = $_SESSION["loginid"];
					$query = "UPDATE wp_users SET lastname='{$lname}',firstname='{$fname}' WHERE userid={$uid}";
					$result = @ mysqli_query($connection, $query);
					$_SESSION["loginname"] = $lname . ", " . $fname;
					echo "Your Information has been changed successfully!";
				}
			}
		}
	  ?>
	  </td></tr>
	</table>
	  </form>
	</div>

<?php
require_once "footer.php";
?>