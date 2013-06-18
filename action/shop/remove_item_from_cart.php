<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_GET['id_product']) || !array_key_exists('id_product_attribute', $_GET)) {
	die();
}

unset_action_session_keys();

// Get cart
$cart = array();
$cookie = array();
if (!empty($_COOKIE[SITENAME_PREFIX]) && !empty($_COOKIE[SITENAME_PREFIX]['cart'])) {
	$cookie = $_COOKIE[SITENAME_PREFIX]['cart'];
}

if (empty($_SESSION['user'])) {
	$calls = array(	
		'get_cart_from_cookie' => array(
			'cart_cookie'	=> $cookie
			, 'id_shop' 	=> SHOP_ID
			, 'id_lang' 	=> LANG_ID
		)	
	);
	
	$data = commerce_api_request('cart', $calls, true);
	if (!empty($data['errors']) || !empty($data['data']['get_cart_from_cookie']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'get_cart_from_cookie');
	}
	// Successful
	else {
		$cart = $data['data']['get_cart_from_cookie']['data'];
	}
}
else {
	if (empty($_SESSION['id_cart'])) {
		$calls = array(	
			'save_cookie_cart_to_db' => array(
				'user_id'		=> $_SESSION['user']['user_id']
				, 'cart_cookie'	=> $cookie
				, 'id_shop' 	=> SHOP_ID
				, 'id_lang' 	=> LANG_ID
			)	
		);
		$data = commerce_api_request('cart', $calls, true); 
		if (!empty($data['errors']) || !empty($data['data']['save_cookie_cart_to_db']['errors'])) {
			$_SESSION['errors'] = !empty($data['errors']) ? $data['errors'] : $data['data']['save_cookie_cart_to_db']['errors'];
		}
		else { // Save cart id to session
			$_SESSION['id_cart'] = !empty($data['data']['save_cookie_cart_to_db']['data']) ? $data['data']['save_cookie_cart_to_db']['data']['id_cart'] : NULL;
		}
	}
	
	if (!empty($_SESSION['id_cart'])) {
		$calls = array(	
			'get_cart_from_db' => array(
				'user_id'		=> $_SESSION['user']['user_id']
				, 'id_shop' 	=> SHOP_ID
				, 'id_lang' 	=> LANG_ID
				, 'id_cart' => $_SESSION['id_cart']
			)
		);
		
		// Shipping address to calculate shipping
		/*
		if (!empty($_SESSION['checkout_shipping_address_id'])) {
			$calls['get_cart_from_db']['shipping_address_id'] = $_SESSION['checkout_shipping_address_id'];
		}
		*/
		
		$data = commerce_api_request('cart', $calls, true);
		if (!empty($data['errors']) || !empty($data['data']['get_cart_from_db']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_cart_from_db');
		}
		else {
			$cart = $data['data']['get_cart_from_db']['data'];
		}
	}
}

if (!empty($cart) && !empty($cart['products'])) {
	$id_products = array();
	$id_product_attributes = array();
	$quantities = array();
	
	// Update quantity of cart item to 0
	foreach ($cart['products'] as $i => $cart_product) {
		array_push($id_products, $cart_product['id_product']);
		array_push($id_product_attributes, $cart_product['id_product_attribute']);
		
		$quantity = ($_GET['id_product'] == $cart_product['id_product'] && $_GET['id_product_attribute'] == $cart_product['id_product_attribute']) ? 0 : $cart_product['quantity'];
		array_push($quantities, $quantity);
	} 
	
	// Update cart
	$calls = array(	
		'update_cookie_cart' => array(
			'cart_cookie' => $cookie
			, 'id_shop' 	=> SHOP_ID
			, 'id_lang' 	=> LANG_ID
			, 'id_product_attributes' => $id_product_attributes
			, 'id_products' => $id_products
			, 'quantities' => $quantities
		)	
	);
	
	$data = commerce_api_request('cart', $calls, true);
	if (!empty($data['errors']) || !empty($data['data']['update_cookie_cart']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'update_cookie_cart');
	}
	else {
		if (empty($_SESSION['user'])) {
			$_SESSION['success'] = 'Cart has been updated.';
		}
		
		if (!setcookie(SITENAME_PREFIX . "[cart]", json_encode($data['data']['update_cookie_cart']['data']), time() + 1209600, '/')) {
			$_SESSION['errors'] = !empty($_SESSION['errors']) ? array_merge($_SESSION['errors'], array('Could not set cookie.')) : array('Could not set cookie.');
		}
		
		if (!empty($_SESSION['user'])) { // Update db cart
			$calls = array(	
				'update_db_cart' => array(
					'user_id'		=> $_SESSION['user']['user_id']
					, 'id_shop' 	=> SHOP_ID
					, 'id_lang' 	=> LANG_ID
					, 'id_product_attributes' => $id_product_attributes
		    		, 'id_products' => $id_products
		    		, 'quantities' => $quantities
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
				$_SESSION['success'] = 'Cart has been updated.';
				$_SESSION['id_cart'] = !empty($data['data']['update_db_cart']['data']) ? $data['data']['update_db_cart']['data']['id_cart'] : NULL;
			}
		}
	}
}

redirect('/shop/checkout.php');
die();
?>