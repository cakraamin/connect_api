<?php
umask(0);

$ch = curl_init();
require_once('../app/Mage.php');
Mage::app();
header("Content-Type: application/vnd.ms-excel");
$handle = fopen("csv/bulk_matmall.csv","r")or die("file dont exist");
$no = 1;
while (!feof($handle )){
    $data = fgetcsv($handle);    
    $sku = $data['0'];
      $nama = $data['1'];
      $kat = $data['2'];
      $kode = $data['3'];
      $_testproductCollection = Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('entity_id')          
        ->addAttributeToFilter('SKU', array('eq'=> trim($sku)));
        $_testproductCollection->load();
      foreach($_testproductCollection as $prod) {
        $product = Mage::getModel('catalog/product')->load($prod->getId());
        $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
        $stat = ($product->getStockItem()->getIsInStock())?" Made To Order":" Out Of Stok";
        $visible = ($product->getVisibility() == "1")?" Not Visible":" Visible";
        $status = ($product->getStatus() == "1")?" Enable":" Disable";
        
        echo $no."\t".$sku."\t".$nama."\t".$kat."\t".$stocklevel."\t".$stat."\t".$visible."\t".$status."\n"; 
      }      
    $no++;
}	
fclose($handle);
header("Content-disposition: attachment; filename=spreadsheet.xls");
exit();
?>