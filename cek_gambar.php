<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

$ch = curl_init();

$categor = 333;
$file = fopen("csv/akhir.csv","r");
$no=1;
while(! feof($file)){
  $nama = fgetcsv($file)['0'];
  $nama = str_replace("http://www.livaza.com/","",$nama);
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
  //echo $no."<img src='".$gambar."'/><br/>";
  echo $gambar."<br/>";
  $no++;
}
fclose($file);
curl_close($ch);
?>