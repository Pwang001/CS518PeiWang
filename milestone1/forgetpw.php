<?php ob_start();
require_once "global.php";
$page_title = "Forgot Password";
require_once "header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\PHPMailer\src\Exception.php';
require 'C:\PHPMailer\src\PHPMailer.php';
require 'C:\PHPMailer\src\SMTP.php';

$email = "";
if (isset($_POST["email"]))
	$email = $_POST["email"];

?>
	<div id="content" align="middle">
	<form name="emailform" action="forgetpw.php" method="post" onsubmit="return(validate());" >
    <table width="400" border="0" align="center">
	    <tr height="150">
		<td>&nbsp;</td>
	    </tr>
	    <tr><td>Enter your email address:</td></tr>
		<tr><td><input type="text" name="email" size="50" value="<?php echo $email ?>" /></td></tr>
		<tr><td></td></tr>
		<tr><td><input type="submit" name="submit" value="Send an Email" /></td></tr>
	  </td>
	  </tr>	
	 
	  <tr><td style="color:red" colspan="2"><br><span id="erremail" style="color:#EE0000"></span>
	  <?php
	    if (isset($_POST["email"]))
		{
			if (empty($email))
				echo "Email is not entered!";
			else {
				if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
					echo"Could not connect to database";
				elseif (!(@ mysqli_select_db($connection, $dbname)))
					echo "Could not select the database";
				else {
					$query = "SELECT * FROM wp_users WHERE email='{$email}'";
					$result = @ mysqli_query($connection, $query); 
					$num = mysqli_num_rows($result);  
					if ($num == 0) {
						echo "Sorry, you do not have an account yet.<br>";
						echo "Please <a href=\"register.php\">Sign Up</a> first.";
					} else {
						$row = @ mysqli_fetch_array($result);
						$uid = $row["userid"];
						$firstname = $row["firstname"];
						$lastname = $row["lastname"];
						$confirmCode = rand(100000,999999);
						$query = "UPDATE wp_users SET confirmcode='{$confirmCode}' WHERE userid={$uid}";
						$result = @ mysqli_query($connection, $query);
						$sender = "peiwang1908@gmail.com";
						$senerName = "Pei Search";
						$receiver = $email;
						$receiverName = $firstname . " " . $lastname;
						$subject = "PeiSearch Reset Password";
						$message = "<html><body>";
						$message .=  "Hello,<br><br>";
						$message .=  "Please click the following URL to reset your account.<br>";
						$url1 = $peiURL . "/resetyourpw.php?u=" . $uid . "&c=" . $confirmCode;
						$message .=  "<a href=\"{$url1}\">{$url1}</a><br><br>";
						$message .=  "Pei Search";
						$message .=  "</body></html>";
						//$headers  = "From: " . $sender . "\r\n";
						//$headers .= "MIME-Version: 1.0\r\n";
						//$headers .= "Content-type: text/html; charset=UTF-8\r\n";
						//if (mail($receiver, $subject, $message, $headers))
						
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
							echo "The email has been sent to your email address";
						else
							echo "An email sending is failed!";
					}
				}
			}
		}
	  ?>
	  </td></tr>
	</table>
	  </form>
	</div>
	<script type="text/javascript">
	function validate()
	{   var flag = true;
		var errbox = document.getElementById("erremail");
		errbox.innerHTML = "";
		var str = emailform.email.value; str = str.trim(); emailform.email.value = str;
		if (str.length == 0)
			{ errbox.innerHTML = "Email is not entered."; flag = false; }
		else {
		  var patt = /^[0-9a-z]+(\.[0-9a-z]+)*@[0-9a-z]+(\.[0-9a-z]+)+$/i;
		  if (!patt.test(str)) { errbox.innerHTML = "It is not valid Email addtress."; flag = false; }
		}
		return flag;
	}
	</script>
<?php
require_once "footer.php";
?>