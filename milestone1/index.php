<?php ob_start();
require_once "global.php";
$page_title = "Home";
require_once "header.php";
?>
	<div id="content" align="center">
	<table border="0" align="center">
	
	   <tr height="150">
		<td>&nbsp;</td>
	   </tr>
	   
	   <tr height="50">
		<td align="center"><img src="images/logopei.jpg" alt="indeximage" height="200"></td>
	   </tr>
	   
	  <tr><td>
	  <form action="search.php" methord="post">
		<input type="text" placeholder="input" maxlength="50" size="50">
		<input type="submit" value="Search">
	  </form>
	  </td></tr>
	  <tr><td align="center"><a href="advsearch.php">Advanced Search</a></td></tr>
	 </table>
	</div>
<?php
require_once "footer.php";
?>
	
