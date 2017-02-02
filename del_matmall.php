<?php

$ch = curl_init();

$handle = fopen("csv/del_matmall.csv","r")or die("file dont exist");
$output = '  ';
$numPerPage = 50;
$page = (isset($_GET['start']))?$_GET['start']:0;
$count = 0;
$start = $page * $numPerPage;
$end = ($page + 1) * $numPerPage;
$next = intval($page)+1;
$detail = array();
?>
<a href="javascript:void(0)" onClick="window.location = 'http://161.202.201.43/exportAPI/del_matmall.php?start=<?php echo $next; ?>'">Lanjut</a><br/>
<?php
//$warna = array();
while (!feof($handle )){
    $isine = fgetcsv($handle);    
    if($count < $end && $count >= $start){
			$sku = $isine['0'];
      $varian = $sku."01";
      $detail[] = array(
        'product_sku'   => (string)$sku,
        'variant_sku'   => array((string)$varian)
      );
    }
   	$count++;
}

$detail = json_encode($detail);
echo $detail;
exit();

curl_setopt($ch, CURLOPT_URL, "https://apiseller.mataharimall.com/product/delete");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/vnd.api+json",
  "Authorization: Seller 5e6f4ad3613a0aa6d0d4684565622342"
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
?>