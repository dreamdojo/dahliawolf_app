<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_GET)) {
	die();
}

unset_action_session_keys();

$calls = array(
	'delete_from_wishlist' => array(
		'where' => array(
			'id_customer' => $_SESSION['user']['user_id']
			, 'id_product' => $_GET['id_product']
			, 'id_shop' => SHOP_ID
		)
	)
	);

	$data = commerce_api_request('wishlist', $calls, true);
	
	if (!empty($data['errors']) || !empty($data['data']['delete_from_wishlist']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'delete_from_wishlist');
	}

if (!empty($_SESSION['errors'])) {
	redirect($_SERVER['HTTP_REFERER']);
}
else {
	redirect('/shop/my-wishlist.php');
}
die();
?>