<?php 

$username = "fyc585";
$password = '9LfXFQjynvJ2H@$R';
$data = "username=$username&password=$password";
$ch = curl_init('https://cs4743.professorvaladez.com/api/clear_session');
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'content-type: application/x-www-form-urlencoded',
    'content-length: ' . strlen($data)
));

$time_start = microtime(true);
$result = curl_exec($ch);
$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
curl_close($ch);
$cinfo = json_decode($result, true);

if($cinfo[0] == "Status: OK") {
echo "Session successfully cleared!\r\n";
echo "SID: \r\n";
echo "Close session execution time: $execution_time \r\n";
} else {
	echo $cinfo[0];
	echo "\r\n";
	echo $cinfo[1];
	echo "\r\n";
	echo $cinfo[2];
	echo "\r\n";
	
}

?>