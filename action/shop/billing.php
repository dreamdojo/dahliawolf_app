<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	die();
}
else if (empty($_SESSION['user'])) {
	$_SESSION['errors'] = array('Please login to continue');
	redirect('/login.php');
}

unset_action_session_keys();

// save addresses
if (is_numeric($_POST['billing_address_id'])) {
	$billing_address_id = $_POST['billing_address_id'];
}
else {
	$calls = array(
		'create_billing_address' => array(
			'user_id' => $_SESSION['user']['user_id']
			, 'first_name' => $_POST['billing_first_name']
			, 'last_name' => $_POST['billing_last_name']
			, 'company' => $_POST['billing_company']
			, 'street' => $_POST['billing_address']
			, 'street_2' => $_POST['billing_address_2']
			, 'city' => $_POST['billing_city']
			, 'zip' => $_POST['billing_zip']
			, 'state' => $_POST['billing_state']
			, 'country' => 'US'//$_POST['billing_country']
		)
	);
	$data = api_request('address', $calls, true);
	if (!empty($data['errors']) || !empty($data['data']['create_billing_address']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'create_billing_address');
	}
	
	$billing_address_id = $data['data']['create_billing_address']['data']['address_id'];
}

$_SESSION['checkout_billing_address_id'] = $billing_address_id;


if (is_numeric($_POST['shipping_address_id'])) {
	$shipping_address_id = $_POST['shipping_address_id'];
}
else {
	$calls = array(
		'create_shipping_address' => array(
			'user_id' => $_SESSION['user']['user_id']
			, 'first_name' => $_POST['shipping_first_name']
			, 'last_name' => $_POST['shipping_last_name']
			, 'company' => $_POST['shipping_company']
			, 'street' => $_POST['shipping_address']
			, 'street_2' => $_POST['shipping_address_2']
			, 'city' => $_POST['shipping_city']
			, 'zip' => $_POST['shipping_zip']
			, 'state' => $_POST['shipping_state']
			, 'country' => 'US'
		)
	);
	$data = api_request('address', $calls, true);
	if (!empty($data['errors']) || !empty($data['data']['create_shipping_address']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'create_shipping_address');
	}
	
	$shipping_address_id = $data['data']['create_shipping_address']['data']['address_id'];
}

$_SESSION['checkout_shipping_address_id'] = $shipping_address_id;

if( !isset($_POST['ajax']) ) {
    if (!empty($_SESSION['errors'])) {
        redirect($_SERVER['HTTP_REFERER']);
    }
    else {
        redirect('/shop/checkout.php?step=shipping');
    }
    die();
} else {
    if (!empty($_SESSION['errors'])) {
        echo json_encode( $_SESSION['errors'] );
    }
    else {
        if (is_numeric($_POST['billing_address_id'])) {
            echo $billing_address_id;
        } else {
            echo json_encode($data);
        }
    }
    die();
}
?>