<?
	include("../cmservices-include/global_settings.php");
	session_start();
	if ($_SESSION['user'] != "admin"){
		header ("Location: " . HOST_URL . "/client.php?company=1");
		exit;
		
	} else {
		if ($action == "listCompany") {
		
		} else if ($action == "newuser") {
			$checkEmail = "select * from user where userEmail='$email'";
			$results = mysql_query($checkEmail);
			
			if (mysql_num_rows($results) > 0) {
				$reason = "/new_user.php?reason=exist";
				header ("Location: " . HOST_URL . $reason);
				exit;
			}
			
			else if (!$userPassword) {
				$reason = "/new_user.php?reason=password";
				header ("Location: " . HOST_URL . $reason);
				exit;
			
			} else {
				if ($newCompany != "") {
					$checkCompany = "SELECT * FROM company WHERE companyName = '$newCompany'";
					$companyResults = mysql_query($checkCompany);
					
					if (mysql_num_rows($companyResults) > 0) {
						$reason = "company";
						header ("Location: " . HOST_URL . "/new_user.php");
						exit;
					}
					else {
						$companyPath = eregi_replace(" ", "", $newCompany);
						mysql_query("INSERT INTO company (id, companyName, filePath) VALUES ('', '$newCompany', '$companyPath')");
						$companyResults = mysql_query("SELECT * FROM company WHERE companyName='$newCompany'");
						$companyArray = mysql_fetch_array($companyResults);
						$company = $companyArray['id'];
						
						$companyDir = "./clients/" . $companyPath;
						mkdir ($companyDir, 0770);
						
						$file = "default.php";
						if (!empty($file)) {
							$fileLocation = $companyDir . "/index.php";
							if (file_exists($fileLocation)) {
								@unlink($fileLocation);
							}
							copy($file, $fileLocation);
						}
					}
				}
				
				$newUser = "insert into user (userID, userEmail, userPassword, companyID, name, address1, address2, city, state, zip, phone, fax, mobile) values ('', '$email', '$userPassword', '$company', '$name', '$address1', '$address2', '$city', '$state', '', '$phone', '$fax', '$mobile')";
				mysql_query($newUser);
				$details = "New User Added";
			}
		}
		
		else if ($action == "editpassword") {
			header ("Location: " . HOST_URL . "/admin_password.php");
			exit;
		}
	}
?>

<?
	include("includes/header.php");
	$getName = mysql_query("SELECT name FROM user WHERE userEmail='$userEmail'");
	$name = mysql_fetch_array($getName);
?>

<div id="content">
<table width=100% cellspacing=0 cellpadding=4 border=0>
	<tr><td colspan=2><br></td></tr>
	<tr><td class="text" align="center">Welcome <b><?echo $name['name'];?></b> to CM Services extranet.</td></tr>
	<tr><td align="center">Click here to <a href="<?if ($user != "admin") { print "edit_password.php"; } else { print "admin_password.php";}?>">change your password</a>, or to add a <a href="user_details.php">new user</a>.</td></tr>
	
	<tr><td align="center"><br>
<?			if ($action != "listCompany") {
				$result = mysql_query("SELECT * FROM company ORDER BY companyName");
				$num_rows = mysql_num_rows($result);
				$onehalf = (int) $num_rows/2;
				?>
				<table cellpadding=10 align="center" width="90%">
					<tr>
						<td width="50%" valign="top">
							<?
							for($i=0;$i < $onehalf; $i++) {
									$getCompany = mysql_fetch_array($result);
									echo "<a href='welcome.php?action=listCompany&companyID=" . $getCompany['id'] . "'>" . $getCompany['companyName'] . "</a><br>\n";
							}
							?>
						</td width="50%" valign="top">
						<td valign=top>
							<?
							while ($getCompany = mysql_fetch_array($result)) {
								echo "<a href='welcome.php?action=listCompany&companyID=" . $getCompany['id'] . "'>" . $getCompany['companyName'] . "</a><br>\n";
							}
							?>
						</td>
					</tr>
				</table>
			<?
			} else if ($action == "listCompany" && $companyID) {
				$companyName = mysql_query("SELECT * FROM company WHERE id = '$companyID'");
				$getName = mysql_fetch_array($companyName);
				
				$result = mysql_query("SELECT userID, name FROM user WHERE companyID = '$companyID' ORDER BY name");
				echo "<b>" . $getName['companyName'] . "</b>, <a href='delete_company.php?id=$companyID'>delete</a><br>\n";
				
				if (mysql_num_rows($result) > 0) {
					while ($getUser = mysql_fetch_array($result)) {
						echo "<a href='user_details.php?action=editUser&clientID=" . $getUser['userID'] . "'>" . $getUser['name'] . "</a>, <a href='delete_user.php?id=" . $getUser['userID'] . "'>delete</a><br>\n";
					}
				}
				
				echo "<br><br><a href='file_admin.php?filePath=" . $getName['filePath'] . "&companyID=" . $getName['id'] . "'>view file list</a>";
				echo "<br><a href='welcome.php'>return to main list</a>";
				
				/*
				} else {
					echo "Sorry no clients available for company.<br>\n";
				}*/
			}
		?>
	</td></tr>
	<tr><td align="center"><br><font color="#ff0000"><?=$details;?></font></td></tr>
</table>
</div>

<?php include("includes/footer.php"); ?>
