<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

$file = fopen("csv/livaza-elevania.csv","r");
$myfile = fopen("newdue.txt", "w") or die("Unable to open file!");

while(! feof($file)){
  $jeneng = fgetcsv($file)['0'];
  $productCollection = Mage::getModel('catalog/product')
      ->getCollection() 
      ->addAttributeToSelect('name')
      ->addAttributeToSelect('brand')
      ->addAttributeToFilter('name', array('eq' => $jeneng));
  foreach ($productCollection as $_product){
    $attributes = $_product->getAttributes();
    $data = [];
    foreach ($attributes as $attribute) {

            $attributeLabel = $attribute->getFrontendLabel();
            {             
              $data[$attributeLabel] = $attribute->getFrontend()->getValue($_product);
            }
    }
    $brand = $data['Brand'];
  }
  $txt = "<tr><td>".$jeneng."</td><td>".$brand."</td></tr>";
  //$txt = $data['Brand'].PHP_EOL;
  fwrite($myfile, $txt);
  //echo "<br/>";
}
fclose($myfile);
fclose($file);
?>