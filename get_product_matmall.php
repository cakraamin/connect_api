<?php
$curl = curl_init();

curl_setopt_array($curl,array(
    CURLOPT_URL => "https://apiseller.mataharimall.com/product/get",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{
      \"page\": \"1\",
      \"limit\": \"32\",
      \"sortby\": \"id\",
      \"order\": \"desc\",
      \"status\": \"all\",
      \"q\": \"\"
    }",
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
      header("Content-Type: application/vnd.ms-excel");
      header("Content-disposition: attachment; filename=spreadsheet.xls");
      $hasil = json_decode($response);
//       print_r($hasil);
//       echo "<br/>";
      foreach($hasil->results as $dt){
        echo $dt->seller_sku."\t".$dt->product_sku."\t".$dt->product_name."\t".$dt->normal_price."\t".$dt->selling_price."\t".$dt->stock_available."\n";
      }
  }
?>