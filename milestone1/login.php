<?php ob_start();					/* start PHP output buffer */
require_once "global.php";
$page_title = "Login";
require_once "header.php";

$username1 = "";
if (isset($_POST["username1"]))
	$username1 = $_POST["username1"];  /* if the username is entered, read it */
$password1 = "";
if (isset($_POST["password1"]))
	$password1 = $_POST["password1"];  /* if the password is entered, read it */

?>
	<div id="content" align="middle">
	<form action="login.php" method="post" name="loginform" onsubmit="return(validate());"  autocomplete="off">
        <!-- onsubmit is used start JavaScript validation -->
    <table width="400" border="0" align="center">
	
	   <tr height="150">
		<td>&nbsp;</td>
	   </tr>
	   
	   <tr height="50">
		<td align="center"></td>
	   </tr>
	   
	  <tr>
	  <td>
		Username <br><input type="text" name="username1" maxlength="50" size="30" value="<?php echo $username1 ?>"><br>  <!-- show entered username -->
		Password <br><input type="password" name="password1" maxlength="50" size="30"><br> 
		<br>
		<input type="submit" name="submit" value="Login" /> &nbsp; &nbsp; &nbsp; &nbsp;   <a href="forgetpw.php">Forget password</a>
		<br><br>
	  </td>
	  </tr>	
		
	  <tr><td><a href="register.php" >Create an Account</a></td></tr>
	 
	  <tr><td style="color:red"><br><span id="erremail" style="color:#EE0000"></span>
	  <?php
	    if (isset($_POST["username1"]))
		{
			if (empty($username1))
				echo "Username is not entered!";
			elseif (empty($password1))
				echo "Password is not entered";
			else {
				if (!($connection = @ mysqli_connect($dbhost, $dbuser, $dbpassword)))
					echo"Could not connect to database";
				elseif (!(@ mysqli_select_db($connection, $dbname)))
					echo "Could not select the database";
				else {
					$query = "SELECT * FROM wp_users WHERE email='{$username1}'";
					$result = @ mysqli_query($connection, $query);  /*query's result*/
					$num = mysqli_num_rows($result);                /*result has how many rows*/
					if ($num == 0) {
						echo "Sorry, you do not have an account yet.<br>";
						echo "Please <a href=\"register.php\">Sign Up</a> first.";
					} else {
						$row = @ mysqli_fetch_array($result);
						$pw = md5($password1);
						if ($row['password']==$pw) { 
							$active = $row['active'];
							if ($active == 'Y') {
								$uid = $row['userid'];
								$lastname = $row['lastname'];
								$firstname = $row['firstname'];
								$_SESSION["loginid"] = $uid;
								$_SESSION["loginname"] = $lastname . ", " . $firstname;
								header("Location: index.php");
							} else {
								print "Sorry, your account is not activated.<br>";
								print "Click <a href=\"sendverifyemail.php?e={$username1}\">Send me Activation Email</a> to activate it.";
							}
						} else {
							print "<b>Invalid Password!</b>";
						}
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
	function validate()  /*emailaddress input validate*/
	{   var flag = true;
		var errbox = document.getElementById("erremail");
		errbox.innerHTML = "";
		var str = loginform.username1.value; str = str.trim(); loginform.username1.value = str;
		if (str.length == 0)
			{ errbox.innerHTML = "Username is not entered."; flag = false; }
		else {
		  var patt = /^[0-9a-z]+(\.[0-9a-z]+)*@[0-9a-z]+(\.[0-9a-z]+)+$/i;
		  if (!patt.test(str)) { errbox.innerHTML = "The Username is not a valid Email addtress."; flag = false; }
		}
		return flag;
	}
	</script>
<?php
require_once "footer.php";
?>