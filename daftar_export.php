<?php
umask(0);

require_once('../app/Mage.php');
Mage::app();

mysql_connect("10.116.224.14","livaza","hidupmakmur");
mysql_select_db("livaacom-livedb");

$sql_export = "SELECT * FROM export";
$kueri_e = mysql_query($sql_export);

while($datae = mysql_fetch_array($kueri_e)){
    echo $datae['0']." dan ".$datae['1']." dan ".$datae['2']."<br/>";
}
?>