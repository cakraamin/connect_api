<?php
umask(0);

$idne = 1;
$catid = 264;

$curl = curl_init();

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
        ))->setPageSize(2);

foreach($collection as $p) {  
  $id =  $p->getId();
  $product = Mage::getModel('catalog/product')->load($id);
  
//   $productMediaConfig = Mage::getModel('catalog/product_media_config');
//   $gambar = $productMediaConfig->getMediaUrl($product->getImage());
//   $gambar = str_replace(":7070", "", $gambar);
  
  $images = $product->getMediaGalleryImages();
	if($image['disabled'] != 1){
		$productMediaConfig = Mage::getModel('catalog/product_media_config');
  	$gambar = $productMediaConfig->getMediaUrl($product->getImage());
	}	
	$gambar = str_replace("cdn.panana.livaza.com/images","livaza.com/media",$gambar);
  
  
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
	
	$attributes = $product->getAttributes();
    $data = [];
    foreach ($attributes as $attribute) {

            $attributeLabel = $attribute->getFrontendLabel();
            {
              $value = $attribute->getFrontend()->getValue($product);
              $data[$attributeLabel] = $value;
            }
    } 
	
	/*$pecah = explode(",",$data['Tags']);
	$no = 1;
	$hightl = array();
	foreach($pecah as $dt_pecah){
		if($no <= 9){
			$hightl[] = array(
				"sequence" => (string)$no,
      	"description" => (string)ucwords($dt_pecah)
			);
		}
		$no++;
	}
	print_r($hightl);
	echo $data['Meta Description'];
	exit();*/
	$hightl = array(
		array(
			"sequence" => "1",
      "description" => "Livaza Ecommerce"
		),
		array(
			"sequence" => "2",
      "description" => "Furniture Ecommerce"
		),
		array(
			"sequence" => "3",
      "description" => "Furniture Livaza"
		),
		array(
			"sequence" => "4",
      "description" => "Kirim Seluruh Indonesia"
		)
	);
	
	$stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
	$brand = (is_null($product->getData('manufacturer')))?"Livaza":(string)$product->getData('manufacturer');
  //print_r($product->getData());
  $detail = array(
    "category_id" => (string)1220,
    "product_name" => (string)$product->getData("name"),
    "brand" => (string)$brand,
    "color_id" => (string)3,
    "description" => (string)$product->getData('description'),
    "highlights" => $hightl,
    "youtube_url" => "",
    "handling_fee" => (string)1,
    "insurance_option" => (string)0,
    "jabodetabek_only" => (string)0,
    "weight" => (string)$weight,
    "dimension" => "2 x 3 x 4 cm",
    "package_weight" => (string)$weight,
    "package_dimension" => "2 x 3 x 4 cm",
    "limit_qty_on_cart" => (is_null($product->getData('min_sale_qty')))?"1":(string)$product->getData('min_sale_qty'),
    "attributes" => array(
      array(
        "id" => "1",
        //Product Waranty
        "value" => "",			
      ),
      array(
        "id" => "4",
        //Product Line
        "value" => "",			
      ),
      array(
        "id" => "6",
        //Type
        "value" => "",			
      ),
      array(
        "id" => "13",
        //Product Country
        "value" => "",			
      ),
      array(
        "id" => "20",
        //Main Material
        "value" => "",			
      ),
      array(
        "id" => "73",
        //Certification
        "value" => "",			
      ),
      array(
        "id" => "98",
        //Model Number
        "value" => "",			
      )
    ),
    "images" => array(array(
        "sequence"  => (string)1,
        "path"      => $gambar
      )
    ),
    "variants" => array(array(
      "seller_sku" => (string)$product->getData("sku"),
      "upc" => (string)$product->getData("sku"),
      "normal_price" => (string)(int)$product->getPrice(),
      "selling_price" => (string)(int)$product->getPrice(),
      "promo_price" => (is_null($product->getSpecialPrice()))?"":(string)$product->getSpecialPrice(),
      "promo_start" => (is_null($product->getSpecialFromDate()))?"":(string)$product->getSpecialFromDate(),
      "promo_end" => (is_null($product->getSpecialToDate()))?"":(string)$product->getSpecialToDate(),
      "stock_available" => ($stocklevel < 0)?"0":(string)$stocklevel,
      "stock_minimum" => (string)0,
      "options" => array()
    ))
  );
  
  $detail = json_encode($detail);	
  
  curl_setopt_array($curl,array(
    CURLOPT_URL => "http://api.sb.mataharimall.com/product/create",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $detail,
    CURLOPT_HTTPHEADER => array(
      "Authorization: Seller 3aaa4d1c5d2b43a669785bf40913cba3",
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
}

curl_close($curl);
//echo $detail;
?>