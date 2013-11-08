<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	redirect('/shop/cart.php');
	die();
}

unset_action_session_keys();

$cookie = array();
if (!empty($_COOKIE[SITENAME_PREFIX]) && !empty($_COOKIE[SITENAME_PREFIX]['cart'])) {
	$cookie = $_COOKIE[SITENAME_PREFIX]['cart'];
}

$calls = array(	
	'update_cookie_cart' => array(
		'cart_cookie' => $cookie
		, 'id_shop' 	=> SHOP_ID
		, 'id_lang' 	=> LANG_ID
		, 'id_product_attributes' => array_key_exists('id_product_attributes', $_POST) ? $_POST['id_product_attributes'] : NULL
		, 'id_products' => array_key_exists('id_products', $_POST) ? $_POST['id_products'] : NULL
		, 'quantities' => array_key_exists('quantities', $_POST) ? $_POST['quantities'] : NULL
	)	
);

$data = commerce_api_request('cart', $calls, true); 
if (!empty($data['errors']) || !empty($data['data']['update_cookie_cart']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'update_cookie_cart');
}
else {
	$_SESSION['success'] = 'Cart has been updated.';
	if (!setcookie(SITENAME_PREFIX . "[cart]", json_encode($data['data']['update_cookie_cart']['data']), time() + 1209600, '/')) {
		$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], array('Could not set cookie.')) : array('Could not set cookie.');
	}
	
	if (!empty($_SESSION['user'])) { // Update db cart
		$calls = array(	
			'update_db_cart' => array(
				'user_id'		=> $_SESSION['user']['user_id']
				, 'id_shop' 	=> SHOP_ID
				, 'id_lang' 	=> LANG_ID
				, 'id_product_attributes' => array_key_exists('id_product_attributes', $_POST) ? $_POST['id_product_attributes'] : NULL
	    		, 'id_products' => array_key_exists('id_products', $_POST) ? $_POST['id_products'] : NULL
	    		, 'quantities' => array_key_exists('quantities', $_POST) ? $_POST['quantities'] : NULL
			)
		);
		
		if (!empty($_SESSION['id_cart'])) {
			$calls['update_db_cart']['id_cart'] = $_SESSION['id_cart'];
		}
		
		$data = commerce_api_request('cart', $calls, true);
		if (!empty($data['errors']) || !empty($data['data']['update_db_cart']['errors'])) {
			$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], api_errors_to_array($data, 'update_db_cart')) : api_errors_to_array($data, 'update_db_cart');
		}
		else { // Save cart id to session
			$_SESSION['id_cart'] = !empty($data['data']['update_db_cart']['data']) ? $data['data']['update_db_cart']['data']['id_cart'] : NULL;
		}
	}
}

redirect('/shop/cart.php');
die();
?>