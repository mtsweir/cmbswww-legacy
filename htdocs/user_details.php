<?
	include("../cmservices-include/global_settings.php");
	session_start();
	if ($_SESSION['user'] == "admin"){
		if ($action == "editUser") {
			$userResults = mysql_query("SELECT * FROM user WHERE userID='$clientID'");
			if (mysql_num_rows($userResults) > 0) {
				$userDetails = mysql_fetch_array($userResults);
			}
		}
		
		$selectCompany = "select * from company";
		$companyResults = mysql_query($selectCompany);
		if (mysql_num_rows($companyResults) > 0) {
			$showCompany = "<select name='company'>\n";
			while ($companyDetails = mysql_fetch_array($companyResults)){
				if ($companyDetails['id'] == $userDetails['companyID']) $selected = "selected";
				else $selected = "";
				$showCompany .=	"<option value='" . $companyDetails['id'] . "' " . $selected . "> " . $companyDetails['companyName'] . "\n";
			}
			$showCompany .= "</select>\n";
		}
?>

<?php include("includes/header.php"); ?>

<div id="content">
<h1>Create a new user</h1>


	<form name="password" method=post action="welcome.php?action=newuser" class="cm">
    
    <fieldset>
	<ol>
    	<li><label>Name</label>  <input type="text" name="name" size="25" value="<?echo $userDetails['name']?>"></li>


		<li><label>Email</label> <input type="text" name="email" size="25" value="<?echo $userDetails['userEmail']?>"></li>
	
    
    <li><label>Company</label> <?=$showCompany;?></li>

	<li><label>New Company</label>  <input type="text" name="newCompany" size="25" value=""></li>
    
    <li><label>Address 1 </label> <input type="text" name="address1" size="25" value="<?echo $userDetails['address1']?>"></li>

	<li><label>Address 2 </label> <input type="text" name="address2" size="25" value="<?echo $userDetails['address2']?>"></li>
	<li><label>City</label>  <input type="text" name="city" size="25" value="<?echo $userDetails['city']?>"></li>
	<li><label>State</label>  <input type="text" name="state" size="25" value="<?echo $userDetails['state']?>"></li>
	<li><label>Phone</label> <input type="text" name="phone" size="25" value="<?echo $userDetails['phone']?>"></li>
	<li><label>Fax</label> <input type="text" name="fax" size="25" value="<?echo $userDetails['fax']?>"></li>
	<li><label>Mobile</label>  <input type="text" name="mobile" size="25" value="<?echo $userDetails['mobile']?>"></li>
	<li><label>Assign Password</label>  <input type="text" name="userPassword" size="25" value="<?echo $userDetails['userPassword']?>"></li>
	<li><label>&nbsp;</label> <input type="submit" name="submit" value="enter"></li>
 </ol>
</fieldset>
	</form>
	
	<?if ($reason == "exist") {?>
	<p style="color:#ff0000;">That email address has already been assigned.</p>
	<?} else if ($reason == "password") {?>
	<p style="color:#ff0000;">Invalid Password.</p>
	<?} else if ($reason == "company") {?>
	<p style="color:#ff0000;">That company already exists.</p>
	<?}?>

</div>

<?
} else {
	include("../cmservices-include/global_settings.php");
	header ("Location: " . HOST_URL);
	exit;
}
?>

<div style="clear:both;">&nbsp;</div>
<?
	include("../cmservices-include/footer.php");
?>

