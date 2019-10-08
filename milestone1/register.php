<?php ob_start();
require_once "global.php";
$page_title = "Register";
require_once "header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\PHPMailer\src\Exception.php';
require 'C:\PHPMailer\src\PHPMailer.php';
require 'C:\PHPMailer\src\SMTP.php';

$lastname = "";
if (isset($_POST["lastname"]))
	$lastname = $_POST["lastname"];
$firstname = "";
if (isset($_POST["firstname"]))
	$firstname = $_POST["firstname"];
$username = "";
if (isset($_POST["username"]))
	$username = $_POST["username"];
$password1 = "";
if (isset($_POST["password1"]))
	$password1 = $_POST["password1"];
$password2 = "";
if (isset($_POST["password2"]))
	$password2 = $_POST["password2"];

?>
	<div id="content" align="middle">
	<form action="register.php" method="post">
	<table border="0" align="middle">
	  <tr height="150"><td colspan="2">&nbsp;</td></tr>  
	  <tr><td colspan="2"><h3>Sign up</h3></td></tr>
	  <tr><td height="36">Last Name</td><td><input type="text" name="lastname" maxlength="50" size="30" value="<?php echo $lastname ?>"></td></tr>
	  <tr><td height="36">First Name</td><td><input type="text" name="firstname" maxlength="50" size="30" value="<?php echo $firstname ?>"></td></tr>
	  <tr><td height="36">Username</td><td><input type="email" name="username" placeholder="email only" maxlength="50" size="30" value="<?php echo $username ?>"></td></tr>
	  <tr><td height="36">Password</td><td><input type="password" name="password1" maxlength="50" size="30" value="<?php echo $password1 ?>"><br></td></tr>
	  <tr><td height="36">Confirm Password</td><td><input type="password" name="password2" maxlength="50" size="30" value="<?php echo $password2 ?>"></td></tr>
	  <tr><td></td><td height="36"><input type="submit" value="Submit"> </td></tr>
	  <tr><td colspan="2" style="color:red">
	  <?php
	  if (isset($_POST["username"]))
		{
			//$username = $_POST["username"];
			//$password1 = $_POST["password1"];
			//$password2 = $_POST["password2"];
			
			if (empty($lastname))
				echo "Last name can't be empty!";
			elseif (empty($firstname))
				echo "First name can't be empty!";
			elseif (empty($username))
				echo "Username can't be empty!";
			elseif (empty($password1))
				echo "Password can't be empty!";
			elseif (strlen($password1) < 6)
				echo "Password is at least 6 characters!";
			elseif (empty($password2))
				echo "ConfirmPassword can't be empty!";
			elseif ($password1 != $password2)
				echo "Password and ConfirmPassword are not identical!";
			else {
				if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
					echo"Could not connect to database";
				elseif (!(@ mysqli_select_db($connection, $dbname)))
					echo "Could not select the database";
				else {
					$query = "SELECT email,password FROM wp_users WHERE email='{$username}'";
					$result = @ mysqli_query($connection, $query);
					$num = mysqli_num_rows($result);
					if ($num > 0)
						echo "The email ({$username}) has been used as an account.<br>Please Login directly.";
					else {
						$confirmCode = rand(100000,999999);
						$pw = md5($password1);
						$query = "INSERT INTO wp_users SET lastname='{$lastname}',firstname='{$firstname}',email='{$username}',password='{$pw}',";
						$query .= "confirmcode='{$confirmCode}',active='N'";
						$result = @ mysqli_query($connection, $query);
						$uid = mysqli_insert_id($connection);
						echo "You have successfully signed up!<br>";
					
						$sender = "peiwang1908@gmail.com";
						$senerName = "Pei Search";
						$receiver = $username;
						$receiverName = $firstname . " " . $lastname;
						$subject = "PeiSearch Email Confirmation";
						$message = "<html><body>";
						$message .=  "Hello,<br><br>";
						$message .=  "Please click the following URL to activate your account.<br>";
						$url1 = $peiURL . "/emailconfirmation.php?u=" . $uid . "&c=" . $confirmCode;
						$message .=  "<a href=\"{$url1}\">{$url1}</a><br><br>";
						$message .=  "Pei Search";
						$message .=  "</body></html>";
						//$headers  = "From: " . $sender . "\r\n";
						//$headers .= "MIME-Version: 1.0\r\n";
						//$headers .= "Content-type: text/html; charset=UTF-8\r\n";
						$mail = new PHPMailer(TRUE);
						$mail->isSMTP();
						$mail->SMTPDebug = 0;
						//$mail->Debugoutput = 'html';
						$mail->Host = 'smtp.gmail.com';
						$mail->Port = 465;
						$mail->SMTPSecure = 'ssl';
						$mail->SMTPAuth = true;
						$mail->Username = "peiwang1908@gmail.com";
						$mail->Password = "WangtBpB415";
						$mail->setFrom($sender, $senerName);
						$mail->addAddress($receiver, $receiverName);
						$mail->Subject = $subject;
						$mail->IsHTML(true);
						$mail->Body = $message;
						if ($mail->send()) 
							echo "A confirmation email has been sent to your email address";
						else
							echo "A confirmation email sending is failed!";
					}
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