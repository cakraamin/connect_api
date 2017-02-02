<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

$product_collection = Mage::getResourceModel('catalog/product_collection')
                  ->addAttributeToSelect('entity_id')
                  ->addAttributeToFilter('small_image',array('neq'=>'no_selection'))
                  ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                  ->addAttributeToFilter(
                      'status',
                      array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                  )
                  ->addAttributeToFilter('name', array('like' => '%wesi%'))
                  ->load();

foreach ($product_collection as $product) {
  $id =  $product->getId();
  $products = Mage::getModel('catalog/product')->load($id);
  $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($products)->getQty();	
  //if($stocklevel >= '10'){
    echo $products->getData("sku")." ".$products->getData("name")." ".$stocklevel."<br/>"; 
  //}  
}
?>