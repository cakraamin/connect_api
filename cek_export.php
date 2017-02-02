<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

mysql_connect("10.116.224.14","livaza","hidupmakmur");
mysql_select_db("livaacom-livedb");
$sql_selek = "SELECT * FROM cakra_category ORDER BY tanggal ASC";
$kueri = mysql_query($sql_selek);

while($data = mysql_fetch_array($kueri)){
    echo $data['0']." dan ".$data['1']." dan ".$data['2'];
    
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
                    array('finset' => $data['1']),
            ));
    echo count($collection->getAllIds())."<br/>";
}

$sql_export = "SELECT * FROM export";
$kueri_e = mysql_query($sql_export);

/*while($datae = mysql_fetch_array($kueri_e)){
    echo $datae['0']." dan ".$datae['1']." dan ".$datae['2']."<br/>";
}*/
?>