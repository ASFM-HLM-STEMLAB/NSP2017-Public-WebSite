<?php

$imei = $_POST["imei"];
$momsn = $_POST["momsn"];
$transmit_time = $_POST["transmit_time"];
$iridium_latitude = $_POST["iridium_latitude"];
$iridium_longitude = $_POST["iridium_longitude"];
$iridium_cep = $_POST["iridium_cep"];
$data = $_POST["data"];
 
$decoded = pack('H*', $data);

$data = hex2bin (  $data );
$full = $transmit_time . " | " . "sat," . $data . "\n";

$fields = explode(",", $data);
$lat = $fields[1]; 
$lon = $fields[2]; 
$alt = $fields[3]; 
$googleMapsLink = "<http://www.google.com/maps/place/" . $lat . "," . $lon . ">\n";
$slack = "*[SAT MSG]*\n" . "`MAP:` " . $googleMapsLink . "`RAW:`" . $full . "\n";

$x = slack($slack);
echo file_put_contents("satcom.txt",$full, FILE_APPEND | LOCK_EX);
echo file_put_contents("datalog.txt",$full, FILE_APPEND | LOCK_EX);

echo "OK";


function slack($message)
{
    $ch = curl_init("https://slack.com/api/chat.postMessage");
    $data = http_build_query([
        "token" => "xoxb-257259890405-F0oCYsfapkouJNmAODn7dnTQ",
    	"channel" => "#tracking",
    	"text" => $message, 
    	"username" => "hlm1",
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
}

?>