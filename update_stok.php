<?php

$curl = curl_init();

$detail = array(
  array(
    "seller_sku" => "MPLFRN0000017",
    "variant_sku" => "XHL0017540000000101",
    "stock" => "2"    
  ),
  array(
    "seller_sku" => "MPLFRN0000018",
    "variant_sku" => "XHL0017540000000201",
    "stock" => "3"  
  ),
  array(
    "seller_sku" => "MPLFRN0000019",
    "variant_sku" => "XHL0017540000000301",
    "stock" => "4"
  ),
);

$detail = json_encode($detail);

curl_setopt_array($curl,array(
    CURLOPT_URL => "http://api.sb.mataharimall.com/product/stock/update",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $detail,
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