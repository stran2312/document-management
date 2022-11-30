
<?php

include("functions.php");
$dblink=db_connect("document");

$sql = "SELECT * FROM `empty_doc`";
$result = $dblink->query($sql) or die("Something went wrong with $sql<br>".$dblink->error);
while($data = $result->fetch_array(MYSQLI_ASSOC)) {
//	echo '<div>'.$data['name'].'</div>';
	$tmp = explode("-",$data['name']);
	$size += $data['size'];
	$loanArray[] = $tmp[0];
}
echo '<div>Total size of the document is: '.$size.'.';
$count = 0;
$num_documents = 0;
$loanUnique = array_unique($loanArray);
foreach($loanUnique as $key=>$value){
	$sql = "SELECT count(`name`) from `empty_doc` where `name` LIKE '%$value%'";
	$result = $dblink->query($sql) or die("Seomthing went wrong with $sql<br>.$dblink->error");
	$tmp = $result->fetch_array(MYSQLI_NUM);
	echo '<div>Loan number: '.$value.' has '.$tmp[0].' number of documents</div>';
	$count += 1;
	$num_documents += $tmp[0];
}

$sql = "SELECT `name` from `empty_doc`";
$result = $dblink->query($sql) or die("Something went wrong with $sql<br>".$dblink->error);
$index=0;
while($data = $result->fetch_array(MYSQLI_ASSOC)) {
//	echo '<div>'.$data['name'].'</div>';
	$tmp = explode("-",$data['name']);
	$loanNum = $loanUnique[$index];
	$current_loan = $tmp[0];
	if($current_loan = $loanNum){
	}
	
}

?>