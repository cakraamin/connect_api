<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: POST'); 

$email = 'cakra.amin@yahoo.com';
$status = 'pending'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
$list_id = '3268fe6b5d'; // where to get it read above
$api_key = 'a94eaed8714ee791f0ff7ee9141a45ce-us9'; // where to get it read above
$merge_fields = array('FNAME' => 'Cakra','LNAME' => 'Aminuddin');
 
echo rudr_mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields );

function rudr_mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME' => '','LNAME' => '') ){
	$data = array(
		  'apikey'        => $api_key,
    	'email_address' => $email,
		  'status'        => $status,
		  'merge_fields'  => $merge_fields
	);
	$mch_api = curl_init(); // initialize cURL connection
 
	curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
	curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
	curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
	curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
	curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
	curl_setopt($mch_api, CURLOPT_POST, true);
	curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
 
	$result = curl_exec($mch_api);
  $httpCode = curl_getinfo($mch_api, CURLINFO_HTTP_CODE);
  curl_close($ch);

  return $httpCode;	
}
?>