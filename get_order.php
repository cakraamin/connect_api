<?php

$curl = curl_init();

curl_setopt_array($curl,array(
    CURLOPT_URL => "http://api.sb.mataharimall.com/order/list",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n    \"start_date\": \"2016-10-10\",\n    \"end_date\": \"2016-10-30\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Seller 8343f1cf3a243b8fd2cee5a2f8220b7d",
      "Cache-control: no-cache",
      "Content-type: application/vnd.api+json",
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  if ($err) {
  echo "cURL Error #:" . $err;
  } else {
  echo $response;
  }
?>