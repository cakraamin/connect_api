<?php

$ch = curl_init();
$data = <<<_EOT_
<?xml version="1.0" encoding="euc-kr" ?>
<Product>
  <selMnbdNckNm>Livaza</selMnbdNckNm>
  <selMthdCd>01</selMthdCd>
  <dispCtgrNo>3892</dispCtgrNo>
  <prdNm>Alessia 2In1 Sweet Rusric Style</prdNm>
  <advrtStmt>Hot Items Of The Month !!</advrtStmt> 
  <orgnTypCd>01</orgnTypCd>
  <sellerPrdCd>MPLAML0000011</sellerPrdCd> 
  <suplDtyfrPrdClfCd>02</suplDtyfrPrdClfCd>
  <prdStatCd>01</prdStatCd>
  <dlvGrntYn>N</dlvGrntYn>
  <prdWght>3</prdWght>
  <minorSelCnYn>Y</minorSelCnYn>
  <prdImage01><![CDATA[http://catalog.livaza.com:7070/media/catalog/product/a/l/alessia_2in1_sweet_rustic_style_s1.jpg]]></prdImage01>
  <htmlDetail><![CDATA[Nampan dengan laci dibawahnya laci dengan penyekat bisa untuk tempat sendok garpu, kuas kosmetik, the, dan kopi sachet, pensil warna, atk, dll.]]></htmlDetail>
  <selTermUseYn>N</selTermUseYn>
  <tmpltSeq>326758</tmpltSeq>
  <selPrc>268000</selPrc>
  <prdSelQty>0</prdSelQty>
  <colTitle>Color</colTitle>
  <asDetail>Livaza Garansi pengembalian barang 14 Hari dan Garansi produk 1 Tahun.</asDetail> 
  <rtngExchDetail>support@livaza.com</rtngExchDetail>  
</Product>
_EOT_;

$headers = array("Content-type: application/xml; charset=UTF-8","openapikey:ed7116b7b861a5ccd5f52707d2521181");

curl_setopt($ch, CURLOPT_URL, "http://api.elevenia.co.id/rest/prodservices/product");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$return = curl_exec($ch);
$response = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($response == 200){		
	/*$pecah = explode("Product No:",$return);
	if(isset($pecah['1'])){ 
		echo trim($pecah['1']); 		
	}*/
  echo $return;
}else{
  echo "gagal";
}
curl_close($ch);
?>