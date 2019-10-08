<?php
require_once "global.php";
$page_title = "Send Email";
//require_once "header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\PHPMailer\src\Exception.php';
require 'C:\PHPMailer\src\PHPMailer.php';
require 'C:\PHPMailer\src\SMTP.php';

	if (isset($_GET["e"])) {
		$email = $_GET["e"];
		$confirmCode = rand(100000,999999);
		if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
			echo"Could not connect to database";
		elseif (!(@ mysqli_select_db($connection, $dbname)))
			echo "Could not select the database";
		else {
			$query = "SELECT * FROM wp_users WHERE email='{$email}'";
			$result = @ mysqli_query($connection, $query);
			$num = mysqli_num_rows($result);
			if ($num != 0) {
				$row = @ mysqli_fetch_array($result);
				$uid = $row["userid"];
				$firstname = $row["firstname"];
				$lastname = $row["lastname"];
				$query = "UPDATE wp_users SET confirmcode='{$confirmCode}' WHERE userid={$uid}";
				$result = @ mysqli_query($connection, $query);

				$sender = "peiwang1908@gmail.com";
				$senerName = "Pei Search";
				$receiver = $email;
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
					echo "A confirmation email has been sent to your email address.<br><br>Click <a href=\"login.php\">Login</a>";
				else
					echo "A confirmation email sending is failed!";
			}
		}
	}
?>