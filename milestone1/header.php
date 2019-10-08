<!DOCTYPE html>
<html>
<head>
<title><?php echo $page_title ?></title>     <!--动态标题-->
<link rel="stylesheet" type="text/css" href="mystyle.css" />
<?php
if (isset($_SESSION["loginid"]))
{
?>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script type="text/javascript">
function showmenu() {
	var offsets = $('#picon').offset();
	var top = offsets.top;
	var left = offsets.left;
	$("#popupmsgbox").css("top", top + 50);
	$("#popupmsgbox").css("left", left - 20);
	$("#popupmsgbox").show();
}

function hidemenu() {
	$("#popupmsgbox").hide();
}
/*
var showpmenu = false;
function showmenu() {
	var offsets = $('#picon').offset();
	var top = offsets.top;
	var left = offsets.left;
	$("#popupmsgbox").css("top", top + 50);
	$("#popupmsgbox").css("left", left - 20);
	showpmenu ^= true;
	if (showpmenu)
		$("#popupmsgbox").show();
	else
		$("#popupmsgbox").hide();
}
*/
</script>
<div id="popupmsgbox" style="position:fixed;top:50px;left:1000px;width:170px;height:150px;border:1px solid #000000;border-radius:5px;background-color:#dddddd;z-index:99999;display:none;" onmouseleave="hidemenu();">
<p id="popupmsgbody" style="padding-left:20px;">
<span style="color:blue"><?php print $_SESSION["loginname"]; ?></span><br><br>
<a href="changeinfo.php">Change Information</a><br>
<a href="forgetpw.php">Change Password</a><br><br>
<a href="logout.php">Logout</a>
</p>
</div>
<?php
}
?>
</head>
<body>
<div id="container">
	<div id="menubar" align="right">
	<?php
		if ($page_title != "Home") {
			print "<table border=\"0\" width=\"980\">";
			print "<tr><td width=\"130\"><a href=\"index.php\" alt=\"Advanved Search\"><img src=\"images/logopei2.jpg\" height=\"28\" width=\"120\" /></a></td><td>";
			print "<form name=\"searchform\" action=\"search.php\" methord=\"post\">";
			print "<input type=\"text\" maxlength=\"50\" size=\"60\"> &nbsp;";
			print "<input type=\"submit\" value=\"Search\">";
			print "<a href=\"advsearch.php\"> advanced search </a>";
			print "</form>";
			print "</td><td width=\"50\">";
		}
		if (!isset($_SESSION["loginid"]))
			print '<a href="login.php">Login</a>';
		else
			//print "<img id=\"picon\" src=\"images/profile.jpg\" onclick=\"showmenu();\" />";
			print "<img id=\"picon\" src=\"images/profile.jpg\" onmouseover=\"showmenu();\" />";
		if ($page_title != "Home")
		   print "</td></tr></table>";
	?>
	</div>