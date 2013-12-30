<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/classes/PayPalExpressCheckout.php';


if (empty($_SESSION['user']['user_id'])) {
	$_SESSION['errors'] = array('Your session has expired. Please login to continue.');
	redirect('/login.php');
	exit();
}
else if (empty($_SESSION['id_cart'])) {
	$_SESSION['errors'] = array('Your cart is empty.');
	redirect('/shop/checkout.php');
	exit();
}
else if (empty($_SESSION['checkout_billing_address_id'])) {
	$_SESSION['errors'] = array('Billing address is not set.');
	redirect('/shop/checkout.php?step=billing');
	exit();
}
else if (empty($_SESSION['checkout_shipping_address_id'])) {
	$_SESSION['errors'] = array('Shipping address is not set.');
	redirect('/shop/checkout.php?step=billing');
	exit();
}
else if (empty($_SESSION['checkout_id_delivery'])) {
	$_SESSION['errors'] = array('Delivery method is not set.');
 	redirect('/shop/checkout.php?step=shipping');
	exit();
}
else if (empty($_SESSION['checkout_payment_method_id'])) {
	$_SESSION['errors'] = array('Payment method is not set.');
 	redirect('/shop/checkout.php?step=confirmation');
	exit();
}

$returnUrl = 'http://dw.zyonnetworks.com/action/shop/paypal-express-checkout/return';
$cancelUrl = 'http://dw.zyonnetworks.com/login.php';

$calls = array(	
	'begin_paypal_purchase' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'id_cart' => $_SESSION['id_cart']
		, 'id_shop' => SHOP_ID
		, 'id_lang' => LANG_ID
		, 'return_url' => $returnUrl
		, 'cancel_url' => $cancelUrl
		, 'item_name' => 'DahliaWolf Purchase'
		, 'item_description' => 'Clothing & Accessories'
		, 'shipping_address_id' => $_SESSION['checkout_shipping_address_id']
		, 'id_delivery' => $_SESSION['checkout_id_delivery']
	)	
);

$data = commerce_api_request('cart', $calls, true);

$api_errors = api_errors_to_array($data);

if (!empty($api_errors)) {
	$_SESSION['errors'] = $api_errors;
	redirect($_SERVER['HTTP_REFERER']);
	die();
}

$_SESSION['checkout_payment_method_id'] = $data['data']['begin_paypal_purchase']['data']['payment_method_id'];

header('Location: ' .  $data['data']['begin_paypal_purchase']['data']['redirect_uri']);
die();
?>