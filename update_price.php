<?php

$curl = curl_init();

$detail = array(
  array(
    "seller_sku" => "MPLFRN0000017",
    "variant_sku" => "XHL0017540000000101",
    "normal_price" => "1099000",
    "selling_price" => "1000000",
    "promo_price" => "",
    "promo_start" => "",
    "promo_end" => ""
  ),
  array(
    "seller_sku" => "MPLFRN0000018",
    "variant_sku" => "XHL0017540000000201",
    "normal_price" => "1099000",
    "selling_price" => "1000000",
    "promo_price" => "",
    "promo_start" => "",
    "promo_end" => ""
  ),
  array(
    "seller_sku" => "MPLFRN0000019",
    "variant_sku" => "XHL0017540000000301",
    "normal_price" => "1099000",
    "selling_price" => "1000000",
    "promo_price" => "",
    "promo_start" => "",
    "promo_end" => ""
  ),
);

$detail = json_encode($detail);
echo $detail;

/*curl_setopt_array($curl,array(
    CURLOPT_URL => "https://apiseller.mataharimall.com/product/price/update",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $detail,
    CURLOPT_HTTPHEADER => array(
      "Authorization: Seller 5e6f4ad3613a0aa6d0d4684565622342",
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
  }*/
?>