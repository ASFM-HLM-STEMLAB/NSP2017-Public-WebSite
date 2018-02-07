<?php

$imei = $_POST["imei"];
$momsn = $_POST["momsn"];
$transmit_time = $_POST["transmit_time"];
$iridium_latitude = $_POST["iridium_latitude"];
$iridium_longitude = $_POST["iridium_longitude"];
$iridium_cep = $_POST["iridium_cep"];
$data = $_POST["data"];
 
$decoded = pack('H*', $data);
 
 $full = $transmit_time . " | " . hex2bin (  $data ) . "\n";
##echo file_put_contents('mydata.txt', $x); #file_put_contents($file, $current);

echo file_put_contents("iridium.txt",$full, FILE_APPEND | LOCK_EX);


echo "ok";

?>