
<?php
function db_connect($db){
	$hostname="localhost";
    $username="root";
    $password="";
    $dblink=new mysqli($hostname,$username,$password,$db);
	if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }
	return $dblink;
}
?>