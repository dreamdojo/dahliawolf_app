<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

unset_action_session_keys();

if ($_GET['token'] == '') {
	$_SESSION['errors'] = array('Did not receive token from PayPal.');
	redirect('/login.php');
	exit();
}

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

$calls = array(	
	'set_paypal_token' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'id_cart' => $_SESSION['id_cart']
		, 'id_shop' => SHOP_ID
		, 'id_lang' => LANG_ID
		, 'paypal_token' => $_GET['token']
	)	
);

$data = commerce_api_request('cart', $calls, true); 

$api_errors = api_errors_to_array($data);

if (!empty($api_errors)) {
	$_SESSION['errors'] = $api_errors;
}
redirect('/shop/checkout.php?step=confirmation');
die();
?>