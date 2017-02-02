<?php
umask(0);

$ch = curl_init();
require_once('../app/Mage.php');
Mage::app();

$handle = fopen("csv/kurang.csv","r")or die("file dont exist");
$output = '  ';
$numPerPage = 20;
$page = (isset($_GET['start']))?$_GET['start']:0;
$count = 0;
$start = $page * $numPerPage;
$end = ($page + 1) * $numPerPage;
$next = intval($page)+1;
?><a href="javascript:void(0)" onClick="window.location = 'http://161.202.201.43/exportAPI/mirror_gambar.php?start=<?php echo $next; ?>'">Lanjut</a><br/><?php
while (!feof($handle )){
    $data = fgetcsv($handle);    
    if($count < $end && $count >= $start){
			$jeneng = $data['0'];
      $catId = $data['1'];
      
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
        '277'   => '3800',
				'17'		=> '334',
				'264'		=> '3908'
      );

      if(array_key_exists($catId,$cate)){
        $categor = $cate[$catId];
      }else{
        $categor = 30;
      }
      
      $_testproductCollection = Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('entity_id')
        ->addAttributeToFilter('small_image',array('neq'=>'no_selection'))
        ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
        ->addAttributeToFilter(
            'status',
            array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
        )
        ->addAttributeToFilter('SKU', array('eq'=> trim($jeneng)));
        $_testproductCollection->load();
      foreach($_testproductCollection as $prod) {
        $product = Mage::getModel('catalog/product')->load($prod->getId());
        $images = $product->getMediaGalleryImages();
        if($image['disabled'] != 1){
          $productMediaConfig = Mage::getModel('catalog/product_media_config');
          $gambar = $productMediaConfig->getMediaUrl($product->getImage());
        }	
        $gambar = str_replace("cdn.panana.livaza.com/images","catalog.livaza.com:7070/media",$gambar);        
        $uang = intval($product->getData("price"));  
        $weight = intval($product->getData("weight"));
        $weight = ($weight == 0)?intval(1):intval($weight);				
				$url = $gambar;
        $name = basename($url);
        file_put_contents("image/".$name, file_get_contents($url));
				$gambar = "http://161.202.201.43/exportAPI/image/".$name;
				
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
  <prdSelQty>100</prdSelQty>
  <colTitle>Color</colTitle>
  <asDetail>Livaza Garansi pengembalian barang 14 Hari dan Garansi produk 1 Tahun.</asDetail> 
  <rtngExchDetail>support@livaza.com</rtngExchDetail>  
</Product>
_EOT_;

	$headers = array("Content-type: application/xml; charset=UTF-8","openapikey:ed7116b7b861a5ccd5f52707d2521181");

	curl_setopt($ch, CURLOPT_URL, "http://api.elevenia.co.id/rest/prodservices/product");
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$return = curl_exec($ch);
	//echo $jeneng."<hr/>";
	//echo $return."<hr/>";
	$response = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if($response == 200){		
		$pecah = explode("Product No:",$return);
		if(isset($pecah['1'])){ 
			echo $jeneng." ".trim($pecah['1'])."<hr/>"; 
		}
	}
				
				unlink("image/".$name);
      }      			
    }
   	$count++;
}
curl_close($ch);	
fclose($handle);
exit();
?>