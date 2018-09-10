<?
	include("/www/data/cmservices-include/global_settings.php");
	session_start();
	if ($user != "client" && $user != "admin"){
		header ("Location: " . HOST_URL);
		exit;
	
	} else {
		if ($user != "admin") {
			$result = mysql_query("SELECT company.filePath from company, user WHERE company.id = user.companyID AND user.userEmail = '$userEmail'");
			$getResults = mysql_fetch_array($result);
			$filePath = $getResults['filePath'];
		}
		
		$results = mysql_query("SELECT companyName from company WHERE filePath='$filePath'");
		$getName = mysql_fetch_array($results);
		$companyName = $getName['companyName'];
		
		$companyPath = "clients/" . $filePath . "/";
		if ($fileAction == "add") {
			if (!empty($file)) {
				$modifiedPath = eregi_replace(" ", "_", $file_name);
				//echo "modify : " . $modifiedPath;
				$fileLocation = $companyPath . $modifiedPath;
				if (file_exists($fileLocation)) {
					@unlink($fileLocation);
				}
				copy($file, $fileLocation);
			}
		
			if ($user != "admin") {
				$query = "select company.id from company, user WHERE company.id=user.companyID AND user.userEmail='$userEmail'";
				$result = mysql_query($query);
				$getCompanyID =  mysql_fetch_array($result);
				$companyID = $getCompanyID['id'];
			}
			
			$addFile = "INSERT INTO files (fileID, file, companyID) values ('', '$fileLocation', '" . $companyID . "')";
			mysql_query($addFile);
			
			$from = "From:" . $userEmail;
			$message = "File : " . $fileLocation . "\n\n";
			$message .= "Has been uploaded by " . $userEmail . "\n";
			
			mail($adminEmail, "New file upload" , $message, $from);
		} else if ($fileAction == "delete") {
			unlink($file);
		}
?>

<?
	include("/www/data/cmservices-include/head.php");
?>


<div align="center">
<form name="articles" enctype="multipart/form-data" method="post" action="file_admin.php">
<input type=hidden name="fileAction" value="add">
<input type=hidden name="filePath" value="<?echo $filePath?>">
<table width=90% cellpadding=0 cellspacing=3 border=0>
	<tr><td colspan=2 class=genericHeading><b>File Administration - <?echo $companyName;?></b></td></tr>
	<tr><td colspan=2 class=generic>&nbsp;</td></tr>
	
	<tr>
		<td class=generic><b>File</b></td>
		<td class=generic><input class=generic type="File" name="file" size="30"></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td class=generic><input class=generic type="submit" value="upload file"></td>
	</tr>
	
	<tr><td colspan=2 class=generic>&nbsp;</td></tr>
	<tr><td colspan=2 class=generic><hr color="Black"></td></tr>
	<tr><td colspan=2 class=generic>&nbsp;</td></tr>
		
	<tr><td colspan=2 class=generic>
		<table width=100% cellspacing=1 cellpadding=1 border=0>
			<tr>
				<td class=generic valign=top><b>File List</b></td>
				<td class=generic>&nbsp;</td>
			</tr>
			
			<?
			$handle=opendir($companyPath);
			while ($file = readdir($handle)) {
				if ($file != "." && $file != ".." && $file != "index.php") {
			?>
			<tr>
				<td bgcolor="#eeeeee" class=generic><a href="<?echo $companyPath . $file;?>"><?echo "$file";?></a></td>
				<td bgcolor="#eeeeee" class=generic>&nbsp;<a href="file_admin.php?fileAction=delete&filePath=<?echo $filePath;?>&file=<?echo $companyPath . $file;?>">delete</a>&nbsp;</td>
			</tr>
			<?
				}
			}
			closedir($handle);
			?>
		</table>
		
		<br><br>Right mouse click on the file you wish to download. Select the <b>Save Target As</b> (for IE) or <b>Save Link As</b> (for Netscape) and specify where you wish to save the file.
		<br><br>
		<?if ($user == "client") { ?>
			<br><a href="client.php">Welcome Page</a>
		<?} else {?>
			<br><a href="welcome.php">Welcome Page</a>
		<?}?>
	</td></tr>
</table>
</form>
</div>

<?
	include("/www/data/cmservices-include/footer.php");
?>
<?}?>