<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

/*$name='brand';
$attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($name)->getFirstItem();
$attributeId = $attributeInfo->getAttributeId();                                    
$attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
$attributeOptions = $attribute ->getSource()->getAllOptions(false); 
print_r($attributeOptions);
exit();*/

/*$collection = Mage::getModel('catalog/product')
    ->getCollection()
    ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
    ->addAttributeToSelect('*')
    ->addFieldToFilter('brand', '795');

foreach($collection as $p){
  $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($p->getId())->getQty();
  if($stocklevel >= '10'){    
    echo $p->getData('sku')." ".$p->getData('name')." ".$stocklevel."<br/>";      
  }  
}*/
$productCollection = Mage::getModel('catalog/product')
    ->getCollection()
    ->joinField(
        'category_id', 'catalog/category_product', 'category_id', 
        'product_id = entity_id', null, 'left'
    )
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('category_id', array(
            array('finset' => array('306')),
    ))
    ->addAttributeToSort('created_at', 'desc')
    //->addAttributeToFilter('name', array('like' => '%white frame%'));
    ->addFieldToFilter('brand', '9');

foreach($productCollection as $p){
    $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($p->getId())->getQty();
    if($stocklevel >= '5'){    
      echo $p->getData('sku')." ".$p->getData('name')." ".$stocklevel."<br/>";      
    }
};
?>