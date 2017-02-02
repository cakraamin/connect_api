<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

$name='color';
$attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($name)->getFirstItem();
$attributeId = $attributeInfo->getAttributeId();                                    
$attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
$attributeOptions = $attribute ->getSource()->getAllOptions(false); 
print_r($attributeOptions);
exit();
?>