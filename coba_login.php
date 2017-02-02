<?php
$email = "cakra.amin@yahoo.com";
$password = "vespasuper";
require_once "../app/Mage.php";
Mage::app();
umask(0);
Mage::getSingleton("core/session", array("name" => "frontend"));

$email = "cakra.amin@yahoo.com";
$password = "vespasuper";
$websiteId = Mage::app()->getWebsite()->getId();
$store = Mage::app()->getStore();
$customer = Mage::getModel("customer/customer");
$customer->website_id = $websiteId;
$customer->setStore($store);
try {
	$customer->loadByEmail($email);
	$session = Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
	$session->login($email, $password);
	echo "LOGIN: SUCESS";
  header('Location: '.'http://www.livaza.com/customer/account/index/');
}catch(Exception $e){
	echo "LOGIN: FAILED";
}
?>