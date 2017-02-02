<?php
umask(0);

$curl = curl_init();
require_once('../app/Mage.php');
Mage::app();

$handle = fopen("csv/Bulk_matmall_kurang.csv","r")or die("file dont exist");
$output = '  ';
$numPerPage = 35;
$page = (isset($_GET['start']))?$_GET['start']:0;
$count = 0;
$start = $page * $numPerPage;
$end = ($page + 1) * $numPerPage;
$next = intval($page)+1;
?>
<a href="javascript:void(0)" onClick="window.location = 'http://161.202.201.43/exportAPI/bulk_matmall.php?start=<?php echo $next; ?>'">Lanjut</a><br/>
<?php
//$warna = array();
$no = 1;
while (!feof($handle )){
    $isine = fgetcsv($handle);    
    if($count < $end && $count >= $start){
			$sku = $isine['0'];
      $nama = $isine['1'];
			$catId = $isine['3'];
			$satu = $isine['4'];
			$dua = $isine['5'];
			$tiga = $isine['6'];
			$empat = $isine['7'];
      
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
        $uang = intval($product->getData("price"));  
        $weight = intval($product->getData("weight"));
        $weight = ($weight == 0)?intval(1):intval($weight);
			
        $uang = intval($product->getData("price"));  
        $weight = intval($product->getData("weight"));
        $weight = ($weight == 0)?intval(1):intval($weight);  

        $attributes = $product->getAttributes();
          $data = [];
          foreach ($attributes as $attribute) {

                  $attributeLabel = $attribute->getFrontendLabel();
                  {
                    $value = $attribute->getFrontend()->getValue($product);
                    $data[$attributeLabel] = $value;
                  }
          } 
        
          $colors = array(
            "Netral"  => 19,
            "Bright White"  => 16,
            "Back to Black" => 3,
            "No"  =>  1,
            "Teen Green"  => 7,
            "True Blue" => 4,
            "Think Pink"  => 11,
            "Creme de la Creme" => 735,
            "Sparky Purple" => 12,
            "Hello Yellow"  => 17,
            "Black to Black"  => 3,
            "Hellow Yello"  => 17,
            "Hello Yelow" => 17,
            "think pink"  => 11,
            "Hellow Yellow" => 17,
            "Thingk Pink" => 11,
            "Bright Whait"  => 16,
            "Choco Loco"  => 5,
						"merah"	=> 13,
						"Biru" => 4,
						"kuning" => 17,
						"netral" => 19,
						"blue" => 4,
						"true blue" => 4
          );
	
          $hightl = array(
            array(
              "sequence" => "1",
              "description" => $satu
            ),
            array(
              "sequence" => "2",
              "description" => $dua
            ),
            array(
              "sequence" => "3",
              "description" => $tiga
            ),
            array(
              "sequence" => "4",
              "description" => $empat
            )
          );
	
          $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
          $brand = (is_null($product->getData('manufacturer')))?"Livaza":(string)$product->getData('manufacturer');
                  
          $warna = $colors[$data['Color']];
					$tambh = "<br />Keset dengan ukuran 60 cm x 40 cm x 2 cm.<br />Keset ini akan menambah manis sudut pintu Anda. tunggu apalagi, miliki keset unik dengan harga terjangkau ini sekarang juga.<br />Kami melayani pengiriman produk ini ke Jakarta, Bandung, Makassar, Banjarmasin, Bali dan seluruh Indonesia.</p>";
					$desk = (strlen($product->getData('description')) < 100)?$product->getData('description').$tambh:$product->getData('description');
				
					$detail = array(
						"category_id" => (string)$catId,						
						//"product_name" => (string)$product->getData("name"),
						"product_name" => (string)$nama,
						"brand" => (string)$brand,
						"color_id" => (string)$warna,						
						"description" => (string)$desk,
						"highlights" => $hightl,
						"youtube_url" => "",
						"handling_fee" => (string)1,
						"insurance_option" => (string)0,
						"jabodetabek_only" => (string)0,
						"weight" => (string)$weight,
						"dimension" => "50 x 50 x 50 cm",
						"package_weight" => (string)$weight,
						"package_dimension" => "50 x 50 x 50 cm",
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
							//"promo_price" => (is_null($product->getSpecialPrice()))?"":(string)$product->getSpecialPrice(),
							"promo_price" => (string)(int)$product->getPrice(),
							//"promo_price" => (is_null($product->getSpecialPrice()))?"":(string)$product->getSpecialPrice(),
							//"promo_start" => (is_null($product->getSpecialFromDate()))?"2017-01-31":(string)$product->getSpecialFromDate(),
      				//"promo_end" => (is_null($product->getSpecialToDate()))?"2017-02-29":(string)$product->getSpecialToDate(),							
							"promo_start" => "2017-01-31",
      				"promo_end" => "2017-02-28",							
							"stock_available" => ($stocklevel < 0)?"0":(string)$stocklevel,
							"stock_minimum" => (string)0,
							"options" => array()
							/*"options" => array(array(
								"id" => "138", 
								"value" => "Keset Handuk"
							))*/
						))
					);
					//echo $count."<br/>";
					$detail = json_encode($detail);										
					echo $detail."<br/>";
					exit();

					curl_setopt_array($curl,array(
						CURLOPT_URL => "https://apiseller.mataharimall.com/product/create",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $detail,
						CURLOPT_HTTPHEADER => array(
							"Authorization: Seller 5e6f4ad3613a0aa6d0d4684565622342",
							"Cache-control: no-cache",
							"Content-type: application/vnd.api+json",
						),
					));

					$response = curl_exec($curl);					
					$err = curl_error($curl);
					
					if ($err) {
					echo "cURL Error #:" . $err;
					} else {
						$hasil = json_decode($response);						
						echo $sku." ".$nama." ".$data['Color']." ";					
						print_r($hasil);
						echo "<br/>";
					}
      }
    }
   	$count++;
		$no++;
}
curl_close($ch);	
fclose($handle);
exit();
?>