<?php
umask(0);

mysql_connect("10.116.224.14","livaza","hidupmakmur");
mysql_select_db("livaacom-livedb");

if(isset($_GET['id']) AND isset($_GET['cat'])){
	$idne = $_GET['id'];
	$catid = $_GET['cat'];	
}else{
	//$sql_selek = "SELECT * FROM cakra_category ORDER BY tanggal ASC";
	//$kueri = mysql_query($sql_selek);
	//$row = mysql_fetch_row($kueri);
	//$idne = $row['0'];
	//$catid = $row['1'];	
	//47-36,25-21,26-67,27-68,50-33,51-65,52-66,53-69
	
	$idne = 25;
	$catid = 21;	
	
	$sql_update = "UPDATE cakra_category SET tanggal='".date('Y-m-d')."' WHERE id='".$idne."'";
	mysql_query($sql_update);
}

$start = (isset($_GET['start']))?$_GET['start']:0;

$ch = curl_init();

$cate = array(
  '82'    => '3803',
  '5'     => '3803',
  '47'    => '281',
  '52'    => '3880',
  '92'    => '3876',
  '25'    => '288',
  '13'    => '4326',
  '57'    => '3852',
  '61'    => '3854',
  '11'    => '3800',
  '22'    => '3800',
  '26'    => '3800',
  '27'    => '3800',
  '29'    => '3800',
  '203'   => '3800',
  '93'    => '3800',
  '43'    => '3822',
  '46'    => '3822',
  '54'    => '3801',
  '60'    => '3824',
  '326'   => '298',
  '514'   => '3822',
  '515'   => '3800',
  '518'   => '3801',
  '21'    => '333',
  '67'    => '4363',
  '68'    => '259',
  '56'    => '3895',
  '87'    => '3896',
  '83'    => '3908',
  '252'   => '3908',
  '253'   => '3896',
  '254'   => '3908',
  '38'    => '3610',
  '90'    => '3803',
  '109'   => '3876',
  '30'    => '4218',
  '14'    => '337',
  '97'    => '4327',
  '28'    => '291',
  '41'    => '299',
  '62'    => '316',
  '35'    => '302',
  '271'   => '292',
  '294'   => '4124',
  '306'   => '302',
  '36'    => '290',
  '50'    => '4129',
  '8'     => '297',
  '33'    => '386',
  '65'    => '386',
  '66'    => '386',
  '69'    => '386',
  '328'   => '3604',
  '277'   => '3800'
);

if(array_key_exists($catid,$cate)){
	$categor = $cate[$catid];
}else{
	$categor = 3908;
}

require_once('../app/Mage.php');
Mage::app();
$collection = Mage::getResourceModel('catalog/product_collection');
        $collection->joinField(
            'category_id', 'catalog/category_product', 'category_id', 
            'product_id = entity_id', null, 'left'
        )
        ->addAttributeToSelect('entity_id')
        ->addAttributeToFilter('small_image',array('neq'=>'no_selection'))
        ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
        ->addAttributeToFilter(
            'status',
            array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
        )
        ->addAttributeToFilter('category_id', array(
                array('finset' => $catid),
        ))->setPage(90, 40);

foreach($collection as $p) {  
  $id =  $p->getId();
  $product = Mage::getModel('catalog/product')->load($id);
	$images = $product->getMediaGalleryImages();
	if($image['disabled'] != 1){
		$productMediaConfig = Mage::getModel('catalog/product_media_config');
  	$gambar = $productMediaConfig->getMediaUrl($product->getImage());
	}	
	$gambar = str_replace("cdn.panana.livaza.com/images","catalog.livaza.com/media",$gambar);
	//echo $gambar."<br/>";
  //$gambar = str_replace(":7070", "", $gambar);
  $uang = intval($product->getData("price"));  
  $weight = intval($product->getData("weight"));
	$weight = ($weight == 0)?intval(1):intval($weight);
	$stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();	
$data = <<<_EOT_
<?xml version="1.0" encoding="euc-kr" ?>
<Product>
  <selMnbdNckNm>Livaza</selMnbdNckNm>
  <selMthdCd>01</selMthdCd>
  <dispCtgrNo>{$categor}</dispCtgrNo>
  <prdNm>{$product->getData("name")}</prdNm>
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
  <htmlDetail><![CDATA[{$product->getData("description")}]]></htmlDetail>
  <selTermUseYn>N</selTermUseYn>
  <tmpltSeq>326758</tmpltSeq>
  <selPrc>{$uang}</selPrc>
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
//echo $return."<br/>";
$response = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
//echo $return."<br/>";
if($response == 200){		
	$pecah = explode("Product No:",$return);
	if(isset($pecah['1'])){ 
		echo trim($pecah['1']); 
		$sql_insert = "INSERT INTO export(id_product,id_elevania) VALUES('".trim($pecah['1'])."','".$catid."')";
		mysql_query($sql_insert);
	}
}
}
curl_close($ch);

if(count($collection->getAllIds()) > 0){
	$ke = $start + 40;
	header('Refresh: 400;url=http://161.202.201.43/exportAPI/export_elevania.php?start='.$ke.'&id='.$idne.'&cat='.$catid);	
}else{
	//header('Refresh: 400;url=http://161.202.201.43/exportAPI/export_elevania.php');	
	exit();
}
?>