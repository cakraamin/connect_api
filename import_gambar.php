<?php
$url = "http://10.116.224.59:7070/media/catalog/product/cache/2/image/700x700/9df78eab33525d08d6e5fb8d27136e95/r/e/red_telephone_box_1.png";
$name = basename($url);
file_put_contents("image/".$name, file_get_contents($url));
?>