<?
	include("../cmservices-include/global_settings.php");
	session_start();
	if ($_SESSION['user'] != "admin"){
		header ("Location: " . HOST_URL . "client.php?company=1");
		exit;	
	}
	
	if($_GET['deleteconfirm'] == 'yes' && trim($_GET['id']) != '') {
		
		list($filePath) = mysql_fetch_row(mysql_query("SELECT filePath FROM company WHERE id = '$_GET[id]'"));
		
		// delete the files
		$dh = @opendir("./clients/$filePath");
		if($dh != false) { // dont go into this loop if the dir was not opened successfully
			while (($file = readdir($dh)) !== false) {
				if ($file != '.' and $file != '..') {
					@unlink("./clients/$filePath/$file");
				}
			}
			@closedir($dh);
		}
		
		// delete the client directory
		@rmdir("./clients/$filePath");
		
		// delete users 
		$sql = "DELETE FROM user WHERE companyID = '$_GET[id]'";
		mysql_query($sql);
		
		// delete company
		$sql = "DELETE FROM company WHERE id = '$_GET[id]'";
		mysql_query($sql);
		
		header('Location: welcome.php');
		exit;
	}

	include("includes/header.php");
	$getName = mysql_query("SELECT name FROM user WHERE userEmail='$userEmail'");
	$name = mysql_fetch_array($getName);
?>

<div id="content">
<table width=100% cellspacing=0 cellpadding=4 border=0>
	<tr><td colspan=2><br></td></tr>
	<tr><td class="text" align="center">Welcome <b><?echo $name['name'];?></b> to CM Services extranet.</td></tr>
	<tr><td align="center">Click here to <a href="<?if ($user != "admin") { print "edit_password.php"; } else { print "admin_password.php";}?>">change your password</a>, or to add a <a href="user_details.php">new user</a>.</td></tr>
	
	<tr><td><br>
    
    <?php
	echo $message;
	list($companyname) = mysql_fetch_row(mysql_query("SELECT companyName FROM company WHERE id = '$_GET[id]'"));
	echo "<p>Are you sure you want to delete the company '$companyname' and all of its users and files???</p><p><a href='delete_company.php?deleteconfirm=yes&id=$_GET[id]'>Yes</a> | <a href='welcome.php'>No</a></p>";
	?>
		

	</td></tr>
	<tr><td align="center"><br><font color="#ff0000"><?=$details;?></font></td></tr>
</table>
</div>

<?php include("includes/footer.php"); ?>