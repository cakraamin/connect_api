<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

$file = fopen("csv/cek.csv","r");

while(! feof($file)){
  $jeneng = fgetcsv($file)['0'];
  $_testproductCollection = Mage::getResourceModel('catalog/product_collection')
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('SKU', array('eq'=> $jeneng));
    $_testproductCollection->load();
  foreach($_testproductCollection as $prod) {
    $product = Mage::getModel('catalog/product')->load($prod->getId());
    //echo $prod->getName()." ";
    if ($product->getStockItem()->getIsInStock()) { 
        echo "Made In Order";
    }else{
        echo "Out Of stok";
    }
  }
  //echo " ".$jeneng."<br/>";
  echo "<br/>";
}
fclose($file);
?>