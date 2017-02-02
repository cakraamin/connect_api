<?php

$curl = curl_init();

$detail = array(
  array(
    "product_sku" => "XHL00175400000001",
    "description" => "Sofa dengan desain terbaru dengan warna yang menarik serta dengan material yang berkualitas sehingga enak digunakan",
    "highlights" => array(
      array(
        "sequence" => "1",
        "description" => "Livaza Ecommerce Nomor 1"
      ),
      array(
        "sequence" => "2",
        "description" => "Furniture Ecommerce Nomor 1"
      ),
      array(
        "sequence" => "3",
        "description" => "Furniture Livaza Nomor 1"
      ),
      array(
        "sequence" => "4",
        "description" => "Kirim Seluruh Indonesia Nomor 1"
      )
    )
  ),
  array(
    "product_sku" => "XHL00175400000002",
    "description" => "Sofa dengan desain terbaru dengan warna yang menarik serta dengan material yang berkualitas sehingga enak digunakan",
    "highlights" => array(
      array(
        "sequence" => "1",
        "description" => "Livaza Ecommerce Nomor 1"
      ),
      array(
        "sequence" => "2",
        "description" => "Furniture Ecommerce Nomor 1"
      ),
      array(
        "sequence" => "3",
        "description" => "Furniture Livaza Nomor 1"
      ),
      array(
        "sequence" => "4",
        "description" => "Kirim Seluruh Indonesia Nomor 1"
      )
    )
  ),
  array(
    "product_sku" => "XHL00175400000003",
    "description" => "Sofa dengan desain terbaru dengan warna yang menarik serta dengan material yang berkualitas sehingga enak digunakan",
    "highlights" => array(
      array(
        "sequence" => "1",
        "description" => "Livaza Ecommerce Nomor 1"
      ),
      array(
        "sequence" => "2",
        "description" => "Furniture Ecommerce Nomor 1"
      ),
      array(
        "sequence" => "3",
        "description" => "Furniture Livaza Nomor 1"
      ),
      array(
        "sequence" => "4",
        "description" => "Kirim Seluruh Indonesia Nomor 1"
      )
    )
  ),
);

$detail = json_encode($detail);

curl_setopt_array($curl,array(
    CURLOPT_URL => "http://api.sb.mataharimall.com/bulk/product/update",
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