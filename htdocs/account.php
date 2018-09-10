<?
	include("../cmservices-include/global_settings.php");
	session_start();
	
	if ($user != "") session_unset();
	
	$passwordCorrect = "0";
	$takeAction = "";
	$message = "";
	
	if ($action == "submit") {
		$passwordQuery = "SELECT * FROM user WHERE userEmail='$userEmail' and userPassword='$userPassword'";
		$passwordResult = mysql_query ($passwordQuery)
			or die ("Invalid query");
			
		if (mysql_num_rows($passwordResult) < 1) {
			$message = "Please re enter your email address and password";
			
		} elseif (mysql_num_rows($passwordResult) == 1) {
			$passwordCorrect = "1";
			$userResult = mysql_fetch_array($passwordResult);
			$_SESSION['user'] = $userEmail;
			
			if ($userResult['userEmail'] == $adminEmail) {
				$_SESSION['user'] = "admin";
				$userEmail = $userResult['userEmail'];
				$_SESSION['userEmail'] = $userResult['userEmail'];
				header ("Location: " . HOST_URL . "/welcome.php");
				exit;
			} else {
				$_SESSION['user'] = "client";
				$userEmail = $userResult['userEmail'];
				$_SESSION['userEmail'] = $userResult['userEmail'];
				$clientLocation = "Location: " . HOST_URL . '/client.php';
				header ($clientLocation);
				exit;
			}
		}
	} else {
		session_start();
		$_SESSION['user'] = "";
	}
	$action = "";
?>


	<?php include("includes/header.php"); ?>
    
    
    
<div id="content">
<h1>Your account</h1>

<form name="login" method=post action="account.php">
<input type=hidden name=action value="submit">

<table width=500 cellspacing=0 cellpadding=4 border=0>
	<tr>
		<td width=60 >Email </td>
		<td width=400 ><input type="text" name="userEmail" size="25"></td>
	</tr>
	
	<tr>
		<td >Password </td>
		<td ><input type="password" name="userPassword" size="25"></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td ><input type="submit" name="submit" value="Enter" class="button"></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td><br><br><font color="red"><?if ($message) { echo $message;}?></font></td>
	</tr>
	
	</table>
</form>

<p><strong>We assure you:</strong></p>
	<ul>
		<li>That your account will be handled by courteous and knowledgeable staff.</li>
		<li>That we will make our services available to you as scheduled and with the highest degree of accuracy.</li> 		<li>That your account information will be stored by us in a secure manner and that we will not share or commingle your information with other clients or outside sources.</li>
		<li>That we will work with you or your designer closely to ensure that the complete facets of your account flow both ways. </li>
		<li>That we understand that a small business owner is the most qualified person to make key decisions about his/her business.  We respect that and will promise to work side by side with you in making important business decisions.</li> 
	</ul>
		
	

</div>
<?php include("includes/footer.php"); ?>
