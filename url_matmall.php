<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

//$ch = curl_init();

$file = fopen("csv/MatMall.csv","r");
$no = 1;
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=spreadsheet.xls");
echo "<table>";
while(! feof($file)){
  $nama = fgetcsv($file)['0'];
  $nama = str_replace("https://www.livaza.com/","",$nama);
  $url = $nama;
  $rewrite = Mage::getModel('core/url_rewrite')->setStoreId(Mage::app()->getStore()->getId())->loadByRequestPath($url);

  $productId = $rewrite->getProductId();

  $id =  $productId;  
  $product = Mage::getModel('catalog/product')->load($id);  
  $images = $product->getMediaGalleryImages();
	if($image['disabled'] != 1){
		$productMediaConfig = Mage::getModel('catalog/product_media_config');
  	$gambar = $productMediaConfig->getMediaUrl($product->getImage());
	}	
	$gambar = str_replace("cdn.panana.livaza.com/images","livaza.com/media",$gambar);
  $uang = intval($product->getData("price"));  
  $weight = intval($product->getData("weight"));
	$weight = ($weight == 0)?intval(1):intval($weight);
	$stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
	$desc = strip_tags($product->getData("description"));
	$name = str_replace("&","dan",$product->getData("name"));
	
	if ($product->getStockItem()->getIsInStock()) { 
  	$stat = "Made In Order";
  }else{
  	$stat = "Out Of stok";
  }
	
	echo "<tr><td>".$no."</td><td>".$product->getData("sku")."</td><td>".$name."</td><td>".$stocklevel."</td><td>".$stat."</tr>";
	$no++;
}
echo "</table>";
fclose($file);
//curl_close($ch);
?>