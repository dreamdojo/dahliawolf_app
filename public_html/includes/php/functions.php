<?
function getTotalProductsInCart($prods) {
    $retVal = 0;
    foreach($prods as $prod ) {
        $retVal += $prod['quantity'];
    }
    return $retVal;
}

function edit_action_redirect($data, $function_name, $success_msg, $redirect = NULL) {
	// Failed edit
	if (!empty($data)) {
		if (!empty($data['errors'])) {
			$_SESSION['errors'] = $data['errors'];
		}
		else if (!empty($data['data'][$function_name]['errors'])) {
			$_SESSION['errors'] = $data['data'][$function_name]['errors'];
		}
		// Successful edit
		else {
			$_SESSION['success'] = $success_msg;
		}
	}

	$redirect = !empty($redirect) ? $redirect : $_SERVER['HTTP_REFERER'];
	header('location: ' . $redirect);
	die();
}

function socialize($str){
	$hashified = preg_replace('/\#([a-z0-9_]+)/i', '<a href="http://www.dahliawolf.com/vote?q=$1">#$1</a>',$str);
    $hashified = preg_replace('/\@([a-z0-9_]+)/i', '<a href="http://www.dahliawolf.com/$1">@$1</a>', $hashified);
	return $hashified;
}

function p_r($array) {
	echo '<pre style="text-align: left; font: 10px/125% Arial, Helvetica, sans-serif;">';
	print_r($array);
	echo '</pre>';
}

function unset_action_session_keys() {
	if (isset($_SESSION)) {
		if (isset($_SESSION['errors'])) {
			unset($_SESSION['errors']);
		}
		if (isset($_SESSION['success'])) {
			unset($_SESSION['success']);
		}
	}
}

function get_cart_from_db() {

}

function get_cart() {

	$cookie = array();
	$cart = array();
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
				$_SESSION['id_cart'] = !empty($data['data']['save_cookie_cart_to_db']['data']['id_cart']) ? $data['data']['save_cookie_cart_to_db']['data']['id_cart'] : '';
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
			if (!empty($_SESSION['checkout_shipping_address_id'])) {
				$calls['get_cart_from_db']['shipping_address_id'] = $_SESSION['checkout_shipping_address_id'];
			}

			// Shipping method
			if (!empty($_SESSION['checkout_id_delivery'])) {
				$calls['get_cart_from_db']['id_delivery'] = $_SESSION['checkout_id_delivery'];
			}

			$data = commerce_api_request('cart', $calls, true);


			if (!empty($data['errors']) || !empty($data['data']['get_cart_from_db']['errors'])) {
				$_SESSION['errors'] = api_errors_to_array($data, 'get_cart_from_db');
			}
			else {
				$cart = $data['data']['get_cart_from_db']['data'];
			}
		}
	}

	if (!empty($_GET['t']) && $_GET['t'] == '1') {
		print_r($_COOKIE);
		print_r($_SESSION);
		print_r($cart);
	}

	return $cart;
}

function redirect($location) {
	$substr = substr($location, 0, 4);
	if ($substr == 'http') {
		header('location: ' . $location);
	}
	else {
		$strpos = strpos($location, '?');

		header('location: ' . HEADER_LOCATION_PREFIX . $location . (QUERY_STRING_APPEND != '' ? ($strpos === false ? '?' : '&') . QUERY_STRING_APPEND : ''));
	}
	die();
}

?>