<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST) || empty($_SESSION['id_cart']) || empty($_SESSION['user'])) {
	redirect('/shop/checkout.php');
	die();
}

unset_action_session_keys();

$calls = array(
	'save_cart_store_credit' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'id_cart' => $_SESSION['id_cart']
		, 'id_shop' => SHOP_ID
		, 'amount' => $_POST['amount']
	)
);
$data = commerce_api_request('cart', $calls, true);

if (!empty($data['errors']) || !empty($data['data']['save_cart_store_credit']['errors'])) {
	$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], api_errors_to_array($data, 'save_cart_store_credit')) : api_errors_to_array($data, 'save_cart_store_credit');
}

redirect('/shop/checkout.php');
die();
?>