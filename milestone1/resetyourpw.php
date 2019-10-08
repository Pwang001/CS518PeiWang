<?php ob_start();
require_once "global.php";
$page_title = "Reset Password";
require_once "header.php";

	print "<div id=\"content\" align=\"center\"><br>";

            if (!isset($_GET["u"]) && !isset($_POST["u"]))  /*compare u in link and in database*/
                print "Invalid Operation!";
            else {
                $uid = "";
                if (isset($_GET["u"]))
                    $uid = $_GET["u"];
                elseif (isset($_POST["u"]))
                    $uid = $_POST["u"];

                if (!isset($_GET["c"]) && !isset($_POST["c"])) /*compare c in link and in database*/
                    print "Invalid Operation!";
                else {
                    $confirmCode = "";
			if (isset($_GET["c"]))
				$confirmCode = $_GET["c"];
			elseif (isset($_POST["c"]))
				$confirmCode = $_POST["c"];

			if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
				echo "Could not connect to database";
			elseif (!(@ mysqli_select_db($connection, $dbname)))
				echo "Could not select the database";
			else {
				$query = "SELECT * FROM wp_users WHERE userid={$uid} AND confirmcode='{$confirmCode}'";
				$result = @ mysqli_query($connection, $query);
				$num = mysqli_num_rows($result);
				if ($num == 0)
					print "Invalid Operation!";
				else {
					$newpw = "";
					if (isset($_POST["newpw"]))
						$newpw = $_POST["newpw"];
					$cfmpw = "";
					if (isset($_POST["cfmpw"]))
						$cfmpw = $_POST["cfmpw"];
						
					print "<form action=\"resetyourpw.php\" method=\"post\">";
					print "<input type=\"hidden\" name=\"u\" value=\"{$uid}\" />";
					print "<input type=\"hidden\" name=\"c\" value=\"{$confirmCode}\" />";
					print "<table width=\"400\" border=\"0\" align=\"center\">";
					print "<tr height=\"150\"><td colspan=\"2\">&nbsp;</td></tr>";
					print "<tr><td width=\"130\">New Password:</td><td><input type=\"password\" name=\"newpw\" value=\"{$newpw}\" /></td></tr>";
					print "<tr><td>Confirm Password:</td><td><input type=\"password\" name=\"cfmpw\" value=\"{$cfmpw}\" /></td></tr>";
					print "<tr><td>&nbsp;</td><td><input type=\"submit\" value=\"Change Password\" /></td></tr>";
					print "<tr><td style=\"color:red\" colspan=\"2\">";
					if (isset($_POST["newpw"])) {
						if (strlen($newpw) == 0)
							print "The new password must be entered.";
						elseif (strlen($newpw) < 6)
							print "The new password must be at least 6 characters.";
						elseif (strlen($cfmpw) == 0)
							print "The confirm password must be entered.";
						elseif (strlen($cfmpw) < 6)
							print "The confirm password must be at least 6 characters.";
						elseif ($newpw != $cfmpw)
							print "Your new password and confirm password are not identical!";
						else  {
							$newpw = md5($newpw);
							$query = "UPDATE wp_users SET password='{$newpw}' WHERE userid={$uid} AND confirmcode='{$confirmCode}'";
							if (!($result = @ mysqli_query($connection, $query)))
								print "Error: Database operation failed!";
							else 
								print "Your password has been successfully changed.";
						}	
					}
					print "</td></tr>";
					print "</table></form>";
				}
			}
		}
	}
	print "</div>";

require_once "footer.php";
?>