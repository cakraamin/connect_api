<?php

$curl = curl_init();

curl_setopt_array($curl,array(
    CURLOPT_URL => "http://api.sb.mataharimall.com/order/update",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "[
      {
        \"so_store_number\": \"S147668821335\",
        \"status\": \"shipped\",       
         \"shipping_provider\": \"pandu\",
         \"tracking_number\": \"646456456\"
      },
      {
        \"so_store_number\": \"S1476688112828\",
        \"status\": \"shipped\",        
        \"shipping_provider\": \"pandu\",
         \"tracking_number\": \"646456456\"
      }
    ]",
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