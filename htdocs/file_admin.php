<?php
	include("../cmservices-include/global_settings.php");
	session_start();
	

reset ($_FILES);
while (list ($key, $val) = each ($_FILES)) {
    ${$key}=$_FILES[$key]['tmp_name'];
    while (list ($key1, $val1) = each ($val)) {
        ${$key."_".$key1}=$_FILES[$key][$key1];
    }
}

if ($_SESSION['user'] != "client" && $_SESSION['user'] != "admin"){
		header ("Location: " . HOST_URL);
		exit;
	
	} else {
		
		if ($_SESSION['user'] != "admin") {
			$sql = "SELECT company.filePath from company, user WHERE company.id = user.companyID AND user.userEmail = '$_SESSION[userEmail]'";
			$result = mysql_query($sql);
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
		
			if ($_SESSION['user'] != "admin") {
				$query = "select company.id from company, user WHERE company.id=user.companyID AND user.userEmail='$_SESSION[userEmail]'";
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
			@unlink($file);
		}
?>

<?php include("includes/header.php");


?>

<div id="content">
<h1>File Administration</h1>
<form name="articles" enctype="multipart/form-data" method="post" action="file_admin.php" class="cm">
<input type=hidden name="fileAction" value="add">
<input type=hidden name="filePath" value="<?php echo $filePath; ?>">
<fieldset>
	<ol>
    	<li><label>File</label> <input class=generic type="File" name="file" size="30"></li>
        <li><label>&nbsp;</label> <input class=generic type="submit" value="upload file"></li>
        </ol>
        </fieldset>
	
<h2>File List</h2>
<table width=90% cellpadding=0 cellspacing=3 border=0>
	
			
			<?php
			$handle=opendir($companyPath);
			while ($dirfile = readdir($handle)) {
				if ($dirfile != "." && $dirfile != ".." && $dirfile != "index.php") {
				$files[] = $dirfile;
				}
			}
			if($files[0] != '') {
				sort($files);
				foreach($files as $file) {
					if(strlen($file) > 53) {
						$displayName = substr($file,0,53).'...';
					} else {
						$displayName = $file;
					}
				?>
				<tr>
					<td bgcolor="#eeeeee" class=generic><a href="<?echo $companyPath . $file;?>"><?echo $displayName; ?></a></td>
					<td bgcolor="#eeeeee" class=generic>&nbsp;<a href="file_admin.php?fileAction=delete&filePath=<?echo urlencode($filePath);?>&file=<?echo urlencode($companyPath . $file);?>">delete</a>&nbsp;</td>
				</tr>
				<?
				}
			}
			closedir($handle);
			?>
		</table>
 </form>
		
		<p>Right mouse click on the file you wish to download. Select the <strong>Save Target As</strong> or <strong>Save Link As</strong> and specify where you wish to save the file.
		</p>
		<? if ($_SESSION['user'] == "client") { ?>
			<p><a href="client.php">Welcome Page</a></p>
		<? } else {?>
			<p><a href="welcome.php">Welcome Page</a></p>
		<? }?>
	

</div>

<?php include("includes/footer.php"); ?>
<?}?>
