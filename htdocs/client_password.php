<?
	include("../cmservices-include/global_settings.php");
	session_start();
	
	if ($_SESSION['user'] != "client"){
		header ("Location: " . HOST_URL);
		exit;
		
	} else {
		if ($action == "editpassword") {
			if ($userPassword && $newPassword && $passwordCheck ) {
				if ($newPassword == $passwordCheck) {
					
					$query = "SELECT * FROM user WHERE userPassword='$userPassword' and userEmail='$userEmail'";
					$results = mysql_query($query);
					
					if (mysql_num_rows($results) > 0) {
						while ($getInfo = mysql_fetch_array($results )) {
							$id = $getInfo['userID'];
						}
						$query = "UPDATE user SET userPassword='$newPassword' ";
						$query .= "WHERE userID='$id'";
						mysql_query($query);
						
						$details = "Your password has now been updated.";
						header ("Location: " . HOST_URL . "/client.php");
					} else { $reason=incorrect; }
				} else { $reason=mismatch; }
			} else { $reason=invalid; }
		}
?>

<?php include("includes/header.php"); ?>

<div id="content">
<h1>Modify your password</h1>

<form name="password" method=post action="client_password.php?action=editpassword" class="cm">

<fieldset>
	<ol>
    	<li><label>Existing Password</label>  <input type="password" name="userPassword" size="25" value=""></li>
        
        <li><label>New Password</label> <input type="password" name="newPassword" size="25" value=""></li>
        
        <li><label>Retype new Password</label>  <input type="password" name="passwordCheck" size="25" value=""></li>
        
        <li><label>&nbsp;</label> <input type="submit" name="submit" value="enter"></li>
   </ol>
</fieldset>

	
	<?if ($reason == "incorrect") {?>
	<p style="color:#ff0000;">You have incorrectly entered in your current password, <br>please try again.</p>
	<?} else if ($reason == "invalid") {?>
	<p style="color:#ff0000;">One or more passwords were invalid, please try again.</p>
	<?} else if ($reason == "mismatch") {?>
	<p style="color:#ff0000;">You did not enter your new password correctly, please try again.</p>
		
	<?}?>
	
	<p><a href="client.php">Welcome Page</a></p>

</form>

</div>

<?php include("includes/footer.php"); ?>
<?}?>
