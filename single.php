<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

$ch = curl_init();

$categor = 290;

  $nama = 'http://www.livaza.com/lampu-dinding-/-wall-lamp-white-glass-3-dl-wl1206-da-ah.html';
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
  $uang = intval($product->getData("price"));  
  $weight = intval($product->getData("weight"));
	$weight = ($weight == 0)?intval(1):intval($weight);
	$stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
	$desc = strip_tags($product->getData("description"));
  $name = str_replace("&","dan",$product->getData("name"));
$data = <<<_EOT_
<?xml version="1.0" encoding="euc-kr" ?>
<Product>
  <selMnbdNckNm>Livaza</selMnbdNckNm>
  <selMthdCd>01</selMthdCd>
  <dispCtgrNo>{$categor}</dispCtgrNo>
  <prdNm>{$name}</prdNm>
  <advrtStmt>Hot Items Of The Month !!</advrtStmt> 
  <orgnTypCd>01</orgnTypCd>
  <orgnNmVal></orgnNmVal> 
  <sellerPrdCd>{$product->getData("sku")}</sellerPrdCd> 
  <suplDtyfrPrdClfCd>02</suplDtyfrPrdClfCd>
  <prdStatCd>01</prdStatCd>
  <dlvGrntYn>N</dlvGrntYn>
  <prdWght>{$weight}</prdWght>
  <minorSelCnYn>Y</minorSelCnYn>
  <prdImage01><![CDATA[{$gambar}]]></prdImage01>
  <htmlDetail><![CDATA[{$desc}]]></htmlDetail>
  <selTermUseYn>N</selTermUseYn>
  <tmpltSeq>326758</tmpltSeq>
  <selPrc>389000</selPrc>
  <prdSelQty>{$stocklevel}</prdSelQty>
  <colTitle>Color</colTitle>
  <asDetail>Livaza Garansi pengembalian barang 14 Hari dan Garansi produk 1 Tahun.</asDetail> 
  <rtngExchDetail>support@livaza.com</rtngExchDetail>  
</Product>
_EOT_;

$headers = array("Content-type: application/xml; charset=UTF-8","openapikey:ed7116b7b861a5ccd5f52707d2521181");

curl_setopt($ch, CURLOPT_URL, "http://api.elevenia.co.id/rest/prodservices/product");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$return = curl_exec($ch);
$response = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
print_r($return);
/*if($response == 200){		
	$pecah = explode("Product No:",$return);
	if(isset($pecah['1'])){ 
		echo "http://www.livaza.com/".$url." ".$id." ".trim($pecah['1'])."<br/>"; 		
	}else{
    echo $return."<br/>";
  }
}else{
	echo $return."<br/>";
}*/

curl_close($ch);
?>