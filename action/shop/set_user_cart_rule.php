<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST) || empty($_SESSION['user'])) {
	redirect('/shop/checkout.php');
	die();
}

if (!empty($_POST['id_cart_rule'])) {
	$calls = array(
		'set_user_cart_rule' => array(
			'id_cart_rule' => $_POST['id_cart_rule']
			, 'id_cart' => $_POST['id_cart']
			, 'user_id' => $_SESSION['user']['user_id']
		)
	);
}
else {
	$calls = array(
		'remove_user_cart_rule' => array(
			'id_cart' => $_POST['id_cart']
			, 'user_id' => $_SESSION['user']['user_id']
		)
	);
}

$data = commerce_api_request('cart', $calls, true);

if (!empty($data['errors']) || !empty($data['data']['set_user_cart_rule']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'set_user_cart_rule');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
die();
?>