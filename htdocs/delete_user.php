<?
	include("../cmservices-include/global_settings.php");
	session_start();
	
	if ($_SESSION['user'] != "admin"){
		header ("Location: " . HOST_URL);
		exit;
	}
	
	if ($confirm == "yes") {
		mysql_query("delete from user where userID='$id'");
		header ("Location: " . HOST_URL . "/welcome.php");
		exit;
	}
	
	
	$getCustomer = mysql_query("select * from user where userID='$id'");
	$customer = mysql_fetch_array($getCustomer);
	include("includes/header.php");
	
	$customer['userID'];
	$customer['userEmail'];
	$customer['userPassword'];
	$customer['companyID'];
	$customer['name'];
	$customer['address1'];
	$customer['address2'];
	$customer['city'];
	$customer['state'];
	$customer['zip'];
	$customer['phone'];
	$customer['fax'];
	$customer['mobile'];
?>

<div align="center">
<table cellspacing=0 cellpadding=2 border=0>
	<tr><td colspan=2><br></td></tr>
	<tr>
		<td class="text">Name</td>
		<td class="text"><?print $customer['name'];?></td>
	</tr>
	<tr>
		<td class="text">Address</td>
		<td class="text"><?print $customer['address1'];?></td>
	</tr>
	<tr>
		<td class="text">&nbsp;</td>
		<td class="text"><?print $customer['address2'];?></td>
	</tr>
	<tr>
		<td class="text">City</td>
		<td class="text"><?print $customer['city'];?></td>
	</tr>
	<tr>
		<td class="text">State</td>
		<td class="text"><?print $customer['state'];?></td>
	</tr>
	<tr>
		<td class="text">Zip</td>
		<td class="text"><?print $customer['zip'];?></td>
	</tr>
	<tr>
		<td class="text">Phone</td>
		<td class="text"><?print $customer['phone'];?></td>
	</tr>
	
	<tr>
		<td class="text">fax</td>
		<td class="text"><?print $customer['fax'];?></td>
	</tr>
	<tr>
		<td class="text">Mobile</td>
		<td class="text"><?print $customer['mobile'];?></td>
	</tr>
	<tr>
		<td class="text">Email</td>
		<td class="text"><?print $customer['email'];?></td>
	</tr>
	<tr><td class="text" colspan=2><a href="delete_user.php?confirm=yes&id=<?print $customer['userID']?>">Confirm Delete</a><br><br></td></tr>
	<tr><td colspan=2><br><a href="client.php">Welcome Page</a></td></tr>
</table>
</div>
</form>

<?php include("includes/footer.php"); ?>
