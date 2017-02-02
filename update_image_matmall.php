<?php
umask(0);
$curl = curl_init();

require_once('../app/Mage.php');
Mage::app();

$handle = fopen("csv/upload_image_fix.csv","r")or die("file dont exist");
$hasil = array();
$no = 1;
while (!feof($handle )){
    $isine = fgetcsv($handle);    
    
      $sku = $isine['0'];
      $mm = $isine['1'];
      $nharga = $isine['2'];
      $sharga = $isine['3'];
      $url = $isine['4'];
  
      if($no == 1){
        $hasil[] = array(
          'seller_sku'    => (string)$sku,
          'variant_sku'   => (string)$mm.'01',
          'normal_price' => (string)$nharga,
          'selling_price' => (string)$sharga,
          'promo_price' => '',
          'promo_start' => '',
          'promo_end' => '',
          'images'        => array(array(
              'sequence'    => "1",
              'path'        => (string)$url
          ))
        ); 
      }      
      $no++;
}
fclose($handle);

$detail = json_encode($hasil);

curl_setopt_array($curl,array(
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
  }

exit();
?>