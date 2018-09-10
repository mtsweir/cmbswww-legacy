<?
	include("../cmservices-include/global_settings.php");
	session_start();
	
	if ($_SESSION['user'] != "client"){
		header ("Location: " . HOST_URL);
		exit;
		
	} else {
	if ($action == "edituser"){
		include ("../include/modifyuser.php3");
	} else if ($action == "editpassword"){
		include ("../include/modifypassword.php3");
	}
?>

<?
	include("includes/header.php");
	$getName = mysql_query("SELECT name FROM user WHERE userEmail = '$userEmail'");
	$name = mysql_fetch_array($getName);
?>
<div id="content">
<h1>Your Account</h1>
<p>Welcome <strong><?echo $name['name'];?></strong> to CM Business Services.</p>

<p>Click here to <a href="client_details.php?">modify details</a> or to <a href="client_password.php">change your password.</a></p>

<p><a href="file_admin.php">File Admin</a><br /></p>
<?=$details;?>

</div>

<?php include("includes/footer.php"); ?>

<?}?>