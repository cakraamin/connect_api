<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

$handle = fopen("csv/image.csv","r")or die("file dont exist");
$no = 1;
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=spreadsheet.xls");
while (!feof($handle )){
    $isine = fgetcsv($handle);    
    
      $sku = $isine['0'];
      $mm = $isine['1'];			
      
      $_testproductCollection = Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('entity_id')
        ->addAttributeToFilter('small_image',array('neq'=>'no_selection'))
        //->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
        ->addAttributeToFilter(
            'status',
            array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
        )
        ->addAttributeToFilter('SKU', array('eq'=> trim($sku)));
        $_testproductCollection->load();
      foreach($_testproductCollection as $prod) {
        $product = Mage::getModel('catalog/product')->load($prod->getId());
        $images = $product->getMediaGalleryImages();
        if($image['disabled'] != 1){
          $productMediaConfig = Mage::getModel('catalog/product_media_config');
          $gambar = $productMediaConfig->getMediaUrl($product->getImage());
        }	
        //$gambar = str_replace("http://cdn.panana.livaza.com/images","https://catalog.livaza.com/media",$gambar); 
				$gambar = str_replace("http","https",$gambar); 
				//echo $no."<img src='".$gambar."' width='50px;'/><br/>";
        //echo "<img src='".$gambar."' width='100px'/><br/>";
        echo $sku."\t".$mm."\t".$gambar."\n";
      } 
}
fclose($handle);
exit();
?>