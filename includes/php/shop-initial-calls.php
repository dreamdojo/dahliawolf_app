<?
$self = $_SERVER['PHP_SELF'];

// Mobile should use same logic per page
$self = str_replace('/mobile', '', $self);

if (empty($_data)) {
	$_data = array();
}

// Get Cart (already gets called in initial-calls.php)
//$_data['cart'] = get_cart();
if (isset($_GET['t'])) {
	die('shop-initial-calls.php:14');
}

// Get Categories
$calls = array(
	'get_shop_categories' => array(
		'id_shop' 		=> SHOP_ID
		, 'id_lang' 	=> LANG_ID

	)
);
$data = commerce_api_request('category', $calls, true);
$_data['categories'] = $data['data']['get_shop_categories']['data'];

if ($self == '/shop/index.php') {
    /*
	if (!empty($_GET['id_category'])) {
		$calls = array(
			'get_category' => array(
				'id_shop' 		=> SHOP_ID
				, 'id_lang' 	=> LANG_ID
				, 'id_category'	=> $_GET['id_category']
			)
			, 'get_products_in_category' => array(
				'id_shop' 		=> SHOP_ID
				, 'id_lang' 	=> LANG_ID
				,'id_category'	=> $_GET['id_category']
				, 'user_id' => !empty($_GET['user_id']) ? $_GET['user_id'] : NULL
			)
		);
		$data = commerce_api_request('category', $calls, true);

		if (!empty($data['errors']) || !empty($data['data']['get_category']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_category');
		}
		else if (!empty($data['data']['get_products_in_category']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_products_in_category');
		}
		else {
			$_data['category'] = $data['data']['get_category']['data'];
			$_data['products'] = $data['data']['get_products_in_category']['data'];
		}
	}
	else {
		$calls = array(
			'get_products' => array(
				'id_shop' => SHOP_ID
				, 'id_lang' => LANG_ID
				, 'user_id' => !empty($_GET['user_id']) ? $_GET['user_id'] : NULL
			)
		);

		$data = commerce_api_request('product', $calls, true);

		if (!empty($data['errors']) || !empty($data['data']['get_products']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_products');
		}
		else {
			$_data['products'] = $data['data']['get_products']['data'];
		}
	}*/
}
else if ($self == '/shop/my-wishlist.php') {
	if(!empty($_SESSION['user'])) {
		$wl_calls = array(
			'get_wishlist' => array(
				'id_customer' => $_SESSION['user']['user_id']
				, 'id_shop' => SHOP_ID
				, 'id_lang' => LANG_ID
			)
		);
		$wl_data = commerce_api_request('wishlist', $wl_calls, true);

	}
}
else if ($self == '/shop/product.php') {
	/*if (empty($_GET['id_product'])) {
		redirect('/shop');
	}

	if(!empty($_SESSION['user'])) {
		$wl_calls = array(
			'does_product_exist_in_wishlist' => array(
				'id_customer' => $_SESSION['user']['user_id']
				, 'id_product' => $_GET['id_product']
				, 'id_shop' => SHOP_ID
				, 'id_lang' => LANG_ID
			)
		);
		$wl_data = commerce_api_request('wishlist', $wl_calls, true);
		$_data['show_add_to_wishlist'] = empty($wl_data['data']['does_product_exist_in_wishlist']['data']) ? true : false;
	} else $_data['show_add_to_wishlist'] =  false;

	$calls = array(
		'get_product_details' => array(
			'id_product' => $_GET['id_product']
			, 'id_shop' => SHOP_ID
			, 'id_lang' => LANG_ID
			, 'user_id' => !empty($_GET['user_id']) ? $_GET['user_id'] : NULL
		)
	);

	$data = commerce_api_request('product', $calls, true);

	// Failed
	if (!empty($data['errors']) || !empty($data['data']['get_product_details']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'get_product_details');
	}
	else {
		$_data['product'] = $data['data']['get_product_details']['data'];

		if (empty($_data['product']) || empty($_data['product']['product'])) {
			$_SESSION['errors'] = array('Product not found');
		}
	}*/
}
else if ($self == '/shop/checkout.php') {
	// Set session delivery id
	if (empty($_SESSION['checkout_id_delivery']) && !empty($_data['cart']['cart']['carrier'])) {
		$_SESSION['checkout_id_delivery'] = $_data['cart']['cart']['carrier']['id_delivery'];
	}

	if (!empty($_GET['step']) && ($_GET['step'] == 'billing' || $_GET['step'] == 'shipping' || $_GET['step'] == 'payment' || $_GET['step'] == 'confirmation')) {
		if (empty($_SESSION['user'])) {
			$_SESSION['errors'] = array('Your session has expired. Please login to continue.');
			redirect('/login.php');
			die();
		}
		else if (empty($_SESSION['id_cart']) || empty($_data['cart']) || empty($_data['cart']['products'])) {
			$_SESSION['errors'] = array('Your cart is empty.');
			redirect('/shop/checkout.php');
			die();
		}
	}

	if (!empty($_GET['step']) && $_GET['step'] == 'billing') {
		$calls = array(
			'get_user_billing_addresses' => array(
				'user_id' => $_SESSION['user']['user_id']
			)
			, 'get_user_shipping_addresses' => array(
				'user_id' => $_SESSION['user']['user_id']
			)
			, 'get_countries' => NULL
			, 'get_states' => NULL
		);
		$data = api_request('address', $calls, true);

		if (!empty($data['errors']) || !empty($data['data']['get_user_billing_addresses']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_user_billing_addresses');
		}
		else {
			$_data['billing_addresses'] = $data['data']['get_user_billing_addresses']['data'];
		}

		if (!empty($data['errors']) || !empty($data['data']['get_user_shipping_addresses']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_user_shipping_addresses');
		}
		else {
			$_data['shipping_addresses'] = $data['data']['get_user_shipping_addresses']['data'];
		}

        $id_lang =  defined('ID_LANG') ? ID_LANG : 1;
        $id_country =  defined('ID_COUNTRY') ? ID_COUNTRY : 3;

		// Countries & default states
		$calls = array(
			'get_countries' => array(
				'id_lang' => $id_lang
			)
			, 'get_states' => array(
				'id_country' => $id_country
			)
		);
		$data = commerce_api_request('address', $calls, true);


        //echo sprintf("<pre>%s</pre>", var_export($data, true));

		$_data['states'] = $data['data']['get_states']['data'];
		$_data['countries'] = $data['data']['get_countries']['data'];


        foreach($_data['countries'] as $country)
        {
            if( $country['iso_code'] == 'US') array_unshift($_data['countries'], $country);
        }

	}
	else if (!empty($_GET['step']) && $_GET['step'] == 'confirmation') {
		if (empty($_SESSION['checkout_billing_address_id'])) {
			$_SESSION['errors'] = array('Billing address is not set.');
			redirect('/shop/checkout.php?step=billing');
			die();
		}
		else if (empty($_SESSION['checkout_shipping_address_id'])) {
			$_SESSION['errors'] = array('Shipping address is not set.');
			redirect('/shop/checkout.php?step=billing');
			die();
		}
		else if (empty($_SESSION['checkout_id_delivery'])) {
			$_SESSION['errors'] = array('Delivery method is not set.');
			redirect('/shop/checkout.php?step=shipping');
			die();
		}

		// Get user shipping address and states/countries
		$calls = array(
			'get_user_address' => array(
				'user_id' => $_SESSION['user']['user_id']
				, 'address_id' => $_SESSION['checkout_shipping_address_id']
			)
			, 'get_countries' => NULL
			, 'get_states' => NULL
		);
		$data = api_request('address', $calls, true);

		$_data['states'] = $data['data']['get_states']['data'];
		$_data['countries'] = $data['data']['get_countries']['data'];

		// Failed
		if (!empty($data['errors']) || !empty($data['data']['get_user_address']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_user_address');
		}
		else {
			$_data['shipping_address'] = $data['data']['get_user_address']['data'];
		}

		// Get user billing address
		$calls = array(
			'get_user_address' => array(
				'user_id' => $_SESSION['user']['user_id']
				, 'address_id' => $_SESSION['checkout_billing_address_id']
			)
		);
		$data = api_request('address', $calls, true);

		// Failed
		if (!empty($data['errors']) || !empty($data['data']['get_user_address']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_user_address');
		}
		else {
			$_data['billing_address'] = $data['data']['get_user_address']['data'];
		}

		// Get payment methods
		$calls = array(
			'get_payment_methods' => NULL
			, 'get_months' => NULL
			, 'get_years' => NULL
		);
		$data = api_request('payment', $calls, true);

		if (!empty($data['errors']) || !empty($data['data']['get_payment_methods']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_payment_methods');
		}
		else {
			$_data['payment_methods'] = $data['data']['get_payment_methods']['data'];
			// Set default payment method id
			if (empty($_SESSION['checkout_payment_method_id']) && !empty($_data['payment_methods'])) {
				$_SESSION['checkout_payment_method_id'] = $_data['payment_methods'][0]['payment_method_id'];
			}
		}

		$_data['months'] = $data['data']['get_months']['data'];

		$_data['years'] = $data['data']['get_years']['data'];

	}
}
else if ($self == '/shop/my-orders.php') {
	if (empty($_SESSION['user'])) {
		$_SESSION['errors'] = array('Please login to continue.');
		redirect('/login.php');
		die();
	}

	$calls = array(
		'get_user_orders' => array(
			'user_id'		=> $_SESSION['user']['user_id']
			, 'id_shop' 	=> SHOP_ID
			, 'id_lang' 	=> LANG_ID
		)
	);
	$data = commerce_api_request('orders', $calls, true);
	if (!empty($data['errors']) || !empty($data['data']['get_user_orders']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'get_user_orders');
	}
	else {
		$_data['orders'] = $data['data']['get_user_orders']['data'];
	}
}
else if ($self == '/shop/order-details.php') {
	if (empty($_SESSION['user'])) {
		$_SESSION['errors'] = array('Please login to continue.');
		redirect('/login.php');
		die();
	}
	else if (empty($_GET['id_order'])) {
		$_SESSION['errors'] = array('Order not found.');
	}
	else {
		$calls = array(
			'get_user_order_details' => array(
				'user_id'		=> $_SESSION['user']['user_id']
				, 'id_shop' 	=> SHOP_ID
				, 'id_lang' 	=> LANG_ID
				, 'id_order' 	=> $_GET['id_order']
			)
		);
		$data = commerce_api_request('orders', $calls, true);
		if (!empty($data['errors']) || !empty($data['data']['get_user_order_details']['errors'])) {
			$_SESSION['errors'] = api_errors_to_array($data, 'get_user_order_details');
		}
		else {
			$_data['order'] = $data['data']['get_user_order_details']['data'];
		}

	}
}


?>