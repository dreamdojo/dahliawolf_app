<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_GET['id_cart_rule'])) {
	redirect('/shop/checkout.php');
	die();
}

unset_action_session_keys();

$cookie = array();
if (!empty($_COOKIE[SITENAME_PREFIX]) && !empty($_COOKIE[SITENAME_PREFIX]['cart'])) {
	$cookie = $_COOKIE[SITENAME_PREFIX]['cart'];
}

$calls = array(	
	'remove_cookie_cart_discount' => array(
		'cart_cookie' => $cookie
		, 'id_shop' => SHOP_ID
		, 'id_lang' => LANG_ID
		, 'id_cart_rule' => $_GET['id_cart_rule']
	)
);

$data = commerce_api_request('cart', $calls, true); 

if (!empty($data['errors']) || !empty($data['data']['remove_cookie_cart_discount']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'remove_cookie_cart_discount');
}
else {
	if (empty($_SESSION['user'])) {
		$_SESSION['success'] = 'Discount Removed.';
	}
	
	if (!setcookie(SITENAME_PREFIX . "[cart]", json_encode($data['data']['remove_cookie_cart_discount']['data']), time() + 1209600, '/')) {
		$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], array('Could not set cookie.')) : array('Could not set cookie.');
	}
	
	if (!empty($_SESSION['user'])) { // Update db cart
		$calls = array(	
			'remove_db_cart_discount' => array(
				'user_id' => $_SESSION['user']['user_id']
				, 'id_shop' => SHOP_ID
				, 'id_lang' => LANG_ID
				, 'id_cart_rule' => $_GET['id_cart_rule']
			)
		);
		
		if (!empty($_SESSION['id_cart'])) {
			$calls['remove_db_cart_discount']['id_cart'] = $_SESSION['id_cart'];
		}
		
		$data = commerce_api_request('cart', $calls, true);
		
		
		if (!empty($data['errors']) || !empty($data['data']['remove_db_cart_discount']['errors'])) {
			$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], api_errors_to_array($data, 'remove_db_cart_discount')) : api_errors_to_array($data, 'remove_db_cart_discount');
		}
		else { // Save cart id to session
			$_SESSION['id_cart'] = !empty($data['data']['remove_db_cart_discount']['data']) ? $data['data']['remove_db_cart_discount']['data']['id_cart'] : NULL;
			$_SESSION['success'] = 'Discount Removed.';
		}
	}
}

redirect('/shop/checkout.php');
die();
?>