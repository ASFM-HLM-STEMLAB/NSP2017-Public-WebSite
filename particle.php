<?php

$event = $_POST["event"];
$data = $_POST["data"];
$published_at = $_POST["published_at"];
$coreid = $_POST["coreid"];
 
// $decoded = pack('H*', $data);
 
 // $full = $published_at . " | " . $data ) . "\n";
// $full = $published_at . " | " .  $data  . "\n";
$full = $published_at . " | " . "cell," . $data . "\n";

$fields = explode(",", $data);
$lat = $fields[1]; // piece1
$lon = $fields[2]; // piece1
$alt = $fields[3]; // piece1
$googleMapsLink = "<http://www.google.com/maps/place/" . $lat . "," . $lon . ">\n";
$slack = "*[CELL MSG]*\n" . "`MAP:` " . $googleMapsLink . "`RAW:`" . $full . "\n";


$x = slack($slack);
echo file_put_contents("cellular.txt",$full, FILE_APPEND | LOCK_EX);
echo file_put_contents("datalog.txt",$full, FILE_APPEND | LOCK_EX);


echo "OK";


############
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

