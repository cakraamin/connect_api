<?php
umask(0);

mysql_connect("10.116.224.14","livaza","hidupmakmur");
mysql_select_db("livaacom-livedb");

if(isset($_GET['id']) AND isset($_GET['cat'])){
	$idne = $_GET['id'];
	$catid = $_GET['cat'];	
}else{
	$sql_selek = "SELECT * FROM cakra_category ORDER BY tanggal ASC";
	$kueri = mysql_query($sql_selek);
	$row = mysql_fetch_row($kueri);
	$idne = $row['0'];
	$catid = $row['1'];	
	
	$sql_update = "UPDATE cakra_category SET tanggal='".date('Y-m-d')."' WHERE id='".$idne."'";
	mysql_query($sql_update);
}

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
        ))->setPageSize(50);

foreach($collection as $p) {  
  $id =  $p->getId();
  $product = Mage::getModel('catalog/product')->load($id);
  $productMediaConfig = Mage::getModel('catalog/product_media_config');
  $gambar = $productMediaConfig->getMediaUrl($product->getImage());
  $gambar = str_replace(":7070", "", $gambar);
  $uang = intval($product->getData("price"));  
  $weight = intval($product->getData("weight"));
	$weight = ($weight == 0)?intval(1):intval($weight);
		
  $categoryName = array();
	
	foreach($product->getCategoryIds() as $dt){
		if (isset($dt)){
			$category = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($dt);
			$categoryName[] = $category->getName();
		}	
	}		
	
	$stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
	$brand = (is_null($product->getData('manufacturer')))?"Livaza":$product->getData('manufacturer');
  //print_r($product->getData());
  $detail[] = array(
    "referensi_sku" => $product->getData("sku"),
	  "name" => $product->getData("name"),
	  "model" => $categoryName['0'],       	
		"minimum_order" => $product->getData('min_sale_qty'),
		"brand" => $brand,
	  "category" => $categoryName,
	  "description" => $product->getData('description'),
	  "short_desc" => $product->getData('short_description'),
	  "height" => "1.00",
	  "width" => "1.00",
	  "depth" => "1.00",
	  "dim_uom" => "measurement dari height, width, depth",
	  "weight" => $weight,
		"height_shipping" => "1.50",
	  "width_shipping" => "1.50",
	  "depth_shipping" => "1.50",
		"dim_uom_shipping" => "satuan dari height, width, depth untuk shipping",
	  "weight_shipping" => $weight,
		"stock" => $stocklevel,
		"images" => array($gambar),
		"manuals" => array(),
		"prices" => array(
      array(
        "price" => $product->getPrice(),
			  "discount" => $product->getSpecialPrice(),
				"start_sale" => $product->getSpecialFromDate(),
				"end_sale" =>  $product->getSpecialToDate(),
				"qty_start" => 0,
				"qty_end"   => 0,
				"type" =>  "retail"
      )
    )
  );
}

$hasil = array(
      "vendor_id"   => "9684",        
      "vendor_name" => "Livaza",
      "products"    => $detail
   );

$hasil = json_encode($hasil);

$ch = curl_init('https://apidev.ralali.com/api/v2/seller/products');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $hasil);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($hasil))                                                                       
);                                                                                                                   
                                                                                                                     
$result = curl_exec($ch);
curl_close($ch);

print_r($result);
?>