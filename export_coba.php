<?php
umask(0);
$ch = curl_init();

$pesan = array();

//$kat = (isset($_GET['cat']))?$_GET['cat']:83;
$kat = (isset($_GET['cat']))?$_GET['cat']:17;
$start = (isset($_GET['start']))?$_GET['start']:0;
$limit = (isset($_GET['limit']))?$_GET['limit']:10;

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

if(array_key_exists($kat,$cate)){
	$categor = $cate[$kat];
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
                array('finset' => $kat),
        ));

foreach($collection as $p) {  
  $id =  $p->getId();	
  $product = Mage::getModel('catalog/product')->load($id);
	$images = $product->getMediaGalleryImages();
	if($image['disabled'] != 1){
		$productMediaConfig = Mage::getModel('catalog/product_media_config');
  	echo $productMediaConfig->getMediaUrl($product->getImage())." dan ".$id."<br/>";  
		//echo '<img src="'.$productMediaConfig->getMediaUrl($product->getImage()).'"/>';
	}
	/*foreach ($product->getMediaGalleryImages() as $image):  
		if($image['disabled'] != 1){
			$productMediaConfig = Mage::getModel('catalog/product_media_config');
  		echo $productMediaConfig->getMediaUrl($product->getImage())." dan ".$id."<br/>";    	
    }
  endforeach;*/
}

exit();
?>