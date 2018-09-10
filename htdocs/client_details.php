<?
	include("../cmservices-include/global_settings.php");
	session_start();
	
	if ($_SESSION['user'] != "client"){
		header ("Location: " . HOST_URL);
		exit;
		
	} else {
		if ($action == "edituser") {
			$checkEmail = "select * from user WHERE userID != '$userID' and userEmail='$email'";  // changed email address to one that already exists.
			$result = mysql_query($checkEmail);
			
			if (mysql_num_rows($result) > 0) {
				$reason = "exist";
			} else {
				$query = "UPDATE user SET userEmail='$email', name='$name', address1='$address1', address2='$address2', city='$city', state='$state', phone='$phone', fax='$fax', mobile='$mobile' ";
				$query .= "WHERE userID='$userID'";
				mysql_query($query);
				$details = "Your Details have now been updated.";
				header ("Location: " . HOST_URL . "/client.php");
			}
		}
		
		// grab users' company
		$query = "select company.companyName, company.id from company, user WHERE company.id=user.companyID AND user.userEmail='$userEmail'";
		$result = mysql_query($query);
		
		if (mysql_num_rows($result) > 0) {
			while($getResult = mysql_fetch_array($result)){
				$companyName = $getResult['companyName'];
				$companyID = $getResult['id'];
			}
		}
		
		// get user details
		$getUserDetails = "SELECT * FROM user WHERE userEmail='$userEmail'";
		$result = mysql_query($getUserDetails);
		
		if (mysql_num_rows($result) > 0) {
			$getResult = mysql_fetch_array($result);
			$id=$getResult['userID'];
			$name=$getResult['name'];
			$address_1=$getResult['address1'];
			$address_2=$getResult['address2'];
			$city=$getResult['city'];
			$state=$getResult['state'];
			$phone=$getResult['phone'];
			$fax=$getResult['fax'];
			$mobile=$getResult['mobile'];
		}
?>

<?php include("includes/header.php"); ?>

<div id="content">
<h1>Modify your details</h1>

<form name="password" method=post action="client_details.php?action=edituser" class="cm">
<input type="hidden" name="userID" value="<?=$id;?>">

<fieldset>
	<ol>
		<li><label>Name</label> <input type="text" name="name" size="25" value="<?=$name;?>"></li>
		
        <li><label>Address 1</label> <input type="text" name="address1" size="25" value="<?=$address_1;?>"></li>
        
        <li><label>Address 2</label> <input type="text" name="address2" size="25" value="<?=$address_2;?>"></li>
        
        <li><label>City</label> <input type="text" name="city" size="25" value="<?=$city;?>"></li>
        
        <li><label>State</label> <input type="text" name="state" size="25" value="<?=$state;?>"></li>
        
        <li><label>Phone</label>  <input type="text" name="phone" size="25" value="<?=$phone;?>"></li>
        
        <li><label>Fax</label> <input type="text" name="fax" size="25" value="<?=$fax;?>"></li>
        
        <li><label>Mobile</label>  <input type="text" name="mobile" size="25" value="<?=$mobile;?>"></li>
        
        <li><label>E-mail</label> <input type="text" name="email" size="25" value="<?=$userEmail?>"></li>
        
        <li><label>Company</label><?=$companyName;?></li>
	
    	<li><label>&nbsp;</label><input type="submit" name="submit" value="enter"></li>
      </ol>
  </fieldset>
	
	
    <?if ($reason == "exist") {?>
	
	<p style="color:#ff0000;">That email address has already been assigned.</p>
	
	<?} else if ($reason == "password") {?>

	<p style="color:#ff0000;">Invalid Password or password did not match.</p>
		
	<?}?>
	
	<p><a href="client.php">Welcome Page</a></p>


</form>

</div>



<?php include("includes/footer.php"); ?>

<?}?>