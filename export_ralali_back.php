<?php
umask(0);
$hasil = array();

require_once('../app/Mage.php');
Mage::app();

$ip_add = array("36.78.131.32");
if (!in_array($_SERVER['REMOTE_ADDR'], $ip_add)) {
    echo "Maaf tidak berhak akses";
    exit();
}

// load category object by category ID
$category = Mage::getModel('catalog/category')->load($_GET['catid']);

$attributeCode = 'brand';
$attributeOption = $_GET['brand'];

$attributeDetails = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
$options = $attributeDetails->getSource()->getAllOptions(false); 
$selectedOptionId = false;
foreach ($options as $option){ 
    // print_r($option) and find all the elements 
    if ($option['label'] == $attributeOption) {
        $selectedOptionId = $option['value'];   
    }
}

if ($selectedOptionId) {
    $products = Mage::getModel('catalog/product')
        ->getCollection()
        ->addCategoryFilter($category)
        ->addAttributeToSelect('*')        
        ->addAttributeToFilter($attributeCode, array('eq' => $selectedOptionId))
        ->load();        
}

foreach($products as $p){
  $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($p->getId())->getQty();	
  $hasil[] = array(
    "vendor_id"       => "Ralali akan memberikan vendor id kepada livaza",
    "name"            => $p->getName(),
    "model"           => "",
    "referensi_sku"   => $p->getSku(),
    "price"           => $p->getPrice(),
    "discount"        => $rule->getData('discount_amount'),
    "start_sale"      => "YY-MM-DD",
    "end_sale"        => "YY-MM-DD",
    "minimum_order"   => $p->getMinQty(),
    "brand"           => $_GET['brand'],
    "category"        => array(),
    "description"     => $p->getDescription(),
    "short_desc"      => $p->getShortDescription(),
    "height"          => "1.00",
    "width"           => "1.00",
    "depth"           => "1.00",
    "dim_uom"         => "measurement dari height, width, depth",
    "weight"          => $p->getWeight(),
    "weight_shipping" => $p->getWeight(),
    "status"          => 0,
    "stock"           => $stocklevel,
    "images"          => array($p->getImageUrl()),
    "manuals"         => array()
  );  
}

echo json_encode($hasil);
?>