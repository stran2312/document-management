<?php 
username = "fyc585";
$password = "9LfxFQjynvJ2H@\$R";
$data = "username=$username&password=$password";
$ch = curl_init('https://cs4743.professorvaladez.com/api/create_session');
curl_setopt($ch, CURLOPT_POST,1):
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

if ($cinfo[0] == "Status: OK") {
    
    if($cinfo[1] == "Action: None"){ //no new files
        echo "\r\n No new files to import\r\n";
        echo "SID: $sid\r\n";
        echo "Username: $username\r\n";
        echo "Query Files Execution Time: $execution_time\r\n";
    } else { // there are files to import
        $tmp = explode(":",$cinfo[1]);
        $files = explode(",", $tmp[1]);
        echo "Number of new files to import found: " .count(files)."\r\n";
        echo "Files:\r\n";
        foreach($files as $key=>$value) {
            echo $value."\r\n";
        }
        echo "Query Files Execution Time: $execution_time\r\n";
    }
    $data = "sid:$sid";
    $ch = curl_init('https://cs4743.professorvaladez.com/api/close_session');
    curl_setopt($ch, CURLOPT_POST,1):
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'content-type: application/x-www-form-urlencoded',
    'content-length: ' . strlen($data)
    ));
    //  
    $time_start = microtime(true);
    $result = curl_exec($ch);
    $time_end = microtime(true);
    $execution_time = ($time_end - $time_start)/60;
    curl_close($ch);
    if ($cinfo[0] == "Status: OK") { // successfully close session
        echo "Session successfully closed!\r\n";
        echo "SID: $sid \r\n";
        echo "Close session execution time: $execution_time \r\n";
    } else { // error closing the session
        echo $cinfo[0];
        echo "\r\n";
        echo $cinfo[1];
        echo "\r\n";
        echo $cinfo[2];
        echo "\r\n";
    }
}

?>