<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php
include("functions.php");
$dblink=db_connect("document");
echo '<div id="page-inner">';
echo '<h1 class="page-head-line">Search Files on DB</h1>';
echo '<div class="panel-body">';
if (!isset($_POST['submit']))
{
	echo '<form action="" method="post">';
	echo '<div class="form-group">';
	echo '<label>Search String:</label>';
	echo '<input type="text" class="form-control" name="searchString">';
	echo '</div>';
	echo '<select name="searchType">';
	echo '<option value="name">Name</option>';
	echo '<option value="uploadBy">Uploaded By</option>';
	echo '<option value="uploadDate">Date</option>';
	echo '<option value="all">All</option>';
	echo '</select>';
	echo '<hr>';
	echo '<button type="submit" name="submit" value="submit">Search</button>';
	echo '</form>';
}
if (isset($_POST['submit']))
{
	$searchType=$_POST['searchType'];
	$searchString=addslashes($_POST['searchString']);
	$sql = "SELECT `auto_id`, `title` FROM `file_category`";
	$result = $dblink->query($sql) or die("Something went wrong with $sql<br>".$dblink->error);
	$category = array();
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$category[$row['auto_id']] = $row['title'];
	}
	switch($searchType)
	{
		case "name":
			$sql="Select `file_name`,`upload_date`,`upload_by`,`auto_id`,`category`,`status` from `doc` where `file_name` like '%$searchString%'";
			break;
		case "uploadBy":
			$sql="Select `file_name`,`upload_date`,`upload_by`,`auto_id`,`category`,`status` from `doc` where `upload_by` like '%$searchString%'";
			break;
		case "uploadDate":
			$sql="Select `file_name`,`upload_date`,`upload_by`,`auto_id`,`category`,`status` from `doc` where `upload_date` like '%$searchString%'";
			break;
		case "all":
			$sql="Select `file_name`,`upload_date`,`upload_by`,`auto_id`,`category`,`status` from `doc`";
			break;
		default:
			redirect("search.php?msg=searchTypeError");
			break;
	}
	$result=$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
	echo '<table id="myTable">';
	echo '<thead>';
	echo '<th>Name</th>';
	echo '<th>Upload Date</th>';
	echo '<th>Category</th>';
	echo '<th>Status</th>';
	echo '<th>Action</th>';
	echo '</thead>';
	echo '<tbody>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC))
	{
		echo '<tr>';
		echo '<td>'.$data['file_name'].'</td>';
		echo '<td>'.$data['upload_date'].'</td>';
		echo '<td>'.$category[$data['category']].'</td>';
		echo '<td>'.$data['status'].'</td>';
		echo '<td><a href="view.php?fid='.$data['auto_id'].'">View</a></td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}
echo '</div>';//end panel-body
echo '</div>';//end page-inner
?>
<script>$(document).ready(function () {
    $.noConflict();
    var table = $('#myTable').DataTable();
});</script>