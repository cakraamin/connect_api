<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://apiseller.mataharimall.com/master/attributes");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"category_id\": \"1493\"
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/vnd.api+json",
  "Authorization: Seller 5e6f4ad3613a0aa6d0d4684565622342"
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);