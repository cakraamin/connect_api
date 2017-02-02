<?php
umask(0);

$ch = curl_init();

$handle = fopen("csv/list.csv","r")or die("file dont exist");
$output = '  ';
$numPerPage = 20;
$page = (isset($_GET['start']))?$_GET['start']:1;
$count = 0;
$start = $page * $numPerPage;
$end = ($page + 1) * $numPerPage;
$next = intval($_GET['start'])+1;
?><a href="javascript:void(0)" onClick="window.location = 'http://161.202.201.43/exportAPI/del_elevania.php?start=<?php echo $next; ?>'">Lanjut</a><?php
while (!feof($handle )){
    $data = fgetcsv($handle);    
    if($count < $end && $count >= $start){
			$headers = array("Content-type: application/xml; charset=UTF-8","openapikey:ed7116b7b861a5ccd5f52707d2521181");			
			curl_setopt($ch, CURLOPT_URL, "http://api.elevenia.co.id/rest/prodstatservice/stat/stopdisplay/".$data['0']);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			$return = curl_exec($ch);
			//echo $return."<br/>";
			$response = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $return."<hr/>";
    }
   	$count++;
}
curl_close($ch);
header('Refresh: 30;url=http://161.202.201.43/exportAPI/del_elevania.php?start='.$next);	
fclose($handle);
exit();

//foreach($collection as $p) {  


// if($response == 200){		
// 	$pecah = explode("Product No:",$return);
// 	if(isset($pecah['1'])){ 
// 		echo trim($pecah['1']); 
// 		$sql_insert = "INSERT INTO export(id_product,id_elevania) VALUES('".trim($pecah['1'])."','".$catid."')";
// 		mysql_query($sql_insert);
// 	}
// }
//}
?>