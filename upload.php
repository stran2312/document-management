<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
<?php
include("functions.php");
$dblink=db_connect("document");
echo '<div id="page-inner">';
if (isset($_REQUEST['msg']) && ($_REQUEST['msg']=="success"))
{
	echo '<div class="alert alert-success alert-dismissable">';
	echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	echo 'Document successfully uploaded!</div>';
}
echo '<h1 class="page-head-line">Upload a New File to DocStorage</h1>';
echo '<div class="panel-body">';
echo '<form method="post" enctype="multipart/form-data" action="">';
echo '<input type="hidden" name="uploadedby" value="user@test.mail">';
echo '<input type="hidden" name="MAX_FILE_SIZE" value="10000000">';
echo '<div class="form-group">';
echo '<label class="control-label col-lg-4">File Upload</label>';
echo '<div class="">';
echo '<div class="fileupload fileupload-new" data-provides="fileupload">';
echo '<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>';
echo '<div class="row">';//buttons
echo '<div class="col-md-2">';
echo '<span class="btn btn-file btn-primary">';
echo '<span class="fileupload-new">Select File</span>';
echo '<span class="fileupload-exists">Change</span>';
echo '<input name="userfile" type="file"></span></div>';
echo '<div class="col-md-2"><a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a></div>';
echo '</div>';//end buttons
echo '</div>';//end fileupload fileupload-new
echo '</div>';//end ""
echo '</div>';//end form-group
echo '<hr>';
echo '<button type="submit" name="submit" value="submit" class="btn btn-lg btn-block btn-success">Upload File</button>';
echo '</form>';
echo '</div>';//end panel-body
echo '</div>';//end page-inner
if (isset($_POST['submit']))
{
   
	$uploadDate=date("Y-m-d H:i:s");
	$uploadDName=date("Y-m-d_H:i:s");
	$uploadBy="user@test.mail";
	$fileName=str_replace(" ","_",$_FILES['userfile']['name']);
	$fileName=$uploadDName.$fileName;
	$docType="pdf";
	$tmpName=$_FILES['userfile']['tmp_name'];
	$fileSize=$_FILES['userfile']['size'];
	$fileType=$_FILES['userfile']['type'];
	$category=2;
    $path = "";
	$tags="";
	$fp=fopen($tmpName, 'r');
	$content=fread($fp, filesize($tmpName));
	fclose($fp);
	$contentsClean=addslashes($content);
	$sql="Insert into `doc` (`file_name`, `file_size`, `file_type`,`category` ,`upload_by`,`upload_date`,`path`,`content`,`status`, `tags`) values ('$fileName','$fileSize','$docType','$category','$uploadBy','$uploadDate','$path','$contentsClean','active', '$tags')";
	$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
	//$fp=fopen($path.$fileName,"wb") or
	//	die("Could not open $path$fileName for writing");
	//fwrite($fp,$content);
	//fclose($fp);
	header("upload.php?msg=success");
}
?>