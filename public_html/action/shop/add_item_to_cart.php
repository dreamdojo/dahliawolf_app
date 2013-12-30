<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	die();
}

unset_action_session_keys();

// Always add to cookie
$cookie = array();
if (!empty($_COOKIE[SITENAME_PREFIX]) && !empty($_COOKIE[SITENAME_PREFIX]['cart'])) {
	$cookie = $_COOKIE[SITENAME_PREFIX]['cart'];
}

$calls = array(	
	'add_cookie_cart_item' => array(
		'cart_cookie' => $cookie
		, 'id_shop' 	=> SHOP_ID
		, 'id_lang' 	=> LANG_ID
		, 'id_product_attribute' => !empty($_POST['id_product_attribute']) ? $_POST['id_product_attribute'] : NULL
		, 'id_product' => $_POST['id_product']
		, 'quantity' => $_POST['quantity']
	)	
);
	
$data = commerce_api_request('cart', $calls, true);

if (!empty($data['errors']) || !empty($data['data']['add_cookie_cart_item']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'add_cookie_cart_item');
}
else {
	if (empty($_SESSION['user'])) {
		$_SESSION['success'] = 'Item added to cart.';
	}
	
	if (!setcookie(SITENAME_PREFIX . "[cart]", json_encode($data['data']['add_cookie_cart_item']['data']), time() + 1209600, '/')) {
		$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], array('Could not set cookie.')) : array('Could not set cookie.');
	}
	
	if (!empty($_SESSION['user'])) { // Add item to db cart
		$calls = array(	
			'add_db_cart_item' => array(
				'user_id'		=> $_SESSION['user']['user_id']
				, 'id_shop' 	=> SHOP_ID
				, 'id_lang' 	=> LANG_ID
				, 'id_product_attribute' => !empty($_POST['id_product_attribute']) ? $_POST['id_product_attribute'] : NULL
				, 'id_product' => $_POST['id_product']
				, 'quantity' => $_POST['quantity']
			)
		);
		
		if (!empty($_SESSION['id_cart'])) {
			$calls['add_db_cart_item']['id_cart'] = $_SESSION['id_cart'];
		}
	
		$data = commerce_api_request('cart', $calls, true); 
		if (!empty($data['errors']) || !empty($data['data']['add_db_cart_item']['errors'])) {
			$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], api_errors_to_array($data, 'add_db_cart_item')) : api_errors_to_array($data, 'add_db_cart_item');
		}
		else { // Save cart id to session
			$_SESSION['id_cart'] = !empty($data['data']['add_db_cart_item']['data']) ? $data['data']['add_db_cart_item']['data']['id_cart'] : NULL;
			$_SESSION['success'] = 'Item added to cart.';
		}
	}
}

if (!empty($_SESSION['errors'])) {
	if(!isset($_POST['ajax'])) {
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        echo json_encode($_SESSION['errors']);
        unset($_SESSION['errors']);
    }
}
else {
	if( !isset($_POST['ajax']) ) {
        redirect('/shop/cart.php');
    } else {
        unset($_SESSION['success']);
        echo json_encode(array('success', $_POST['id_product'], $_POST['quantity']));
    }
}
die();
?>