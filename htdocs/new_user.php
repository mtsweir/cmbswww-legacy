<?
	include("../cmservices-include/global_settings.php");
	session_start();
	if ($_SESSION['user'] == "admin"){
		$selectCompany = "select * from company";
		$companyResults = mysql_query($selectCompany);
		if (mysql_num_rows($companyResults) > 0) {
			$showCompany = "<select name='company'>\n";
			while ($companyDetails = mysql_fetch_array($companyResults)){
				$showCompany .=	"<option value='" . $companyDetails['id'] . "'> " . $companyDetails['companyName'] . "\n";
			}
			$showCompany .= "</select>\n";
		}
?>

<?
	include("../cmservices-include/head.php");
?>

<div align="center">
<table cellspacing=0 cellpadding=2 border=0>
	<tr><td class="text" colspan=2><b>Create New User</b><br><br></td></tr>
	<form name="password" method=post action="welcome.php?action=newuser">
	<tr>
		<td class="text">Name </td>
		<td class="text"><input type="text" name="name" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">E-mail </td>
		<td class="text"><input type="text" name="email" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">Company </td>
		<td class="text"><?=$showCompany;?></td>
	</tr>
	
	<tr>
		<td class="text">New Company </td>
		<td class="text"><input type="text" name="newCompany" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">Address 1 </td>
		<td class="text"><input type="text" name="address1" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">Address 2 </td>
		<td class="text"><input type="text" name="address2" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">City </td>
		<td class="text"><input type="text" name="city" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">State </td>
		<td class="text"><input type="text" name="state" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">Phone </td>
		<td class="text"><input type="text" name="phone" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">Fax </td>
		<td class="text"><input type="text" name="fax" size="25"></td>
	</tr>
	
	<tr>
		<td class="text">Mobile </td>
		<td class="text"><input type="text" name="mobile" size="25"></td>
	</tr>	
	
	<tr>
		<td class="text">Assign Password </td>
		<td class="text"><input type="text" name="userPassword" size="25"></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td class="text"><input type="submit" name="submit" value="enter"></td>
	</tr>
	
	<tr><td colspan=2>&nbsp;</td></tr>
	</form>
	
	<?if ($reason == "exist") {?>
	<tr><td class="text" colspan=2><br><font color="#ff0000">That email address has already been assigned.</font></td></tr>
	<?} else if ($reason == "password") {?>
	<tr><td class="text" colspan=2><br><font color="#ff0000">Invalid Password.</font></td></tr>
	<?} else if ($reason == "company") {?>
	<tr><td class="text" colspan=2><br><font color="#ff0000">That company already exists.</font></td></tr>
	<?}?>
</table>
</div>

<?
	include("../cmservices-include/footer.php");
?>

<?
} else {
	include("../cmservices-include/global_settings.php");
	header ("Location: " . HOST_URL);
	exit;
}
?>