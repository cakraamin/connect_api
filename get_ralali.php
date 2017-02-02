<?php
$ch = curl_init();  
 
$url = "https://apidev.ralali.com/api/v2/seller/products/9684";
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false); 
 
$output=curl_exec($ch);
 
curl_close($ch);
echo $output;
?>