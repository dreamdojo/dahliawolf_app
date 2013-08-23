<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';


unset_action_session_keys();

if (empty($_SESSION['user']['user_id'])) {
	$_SESSION['errors'] = array('Your session has expired. Please login to continue.');
	redirect('/login.php');
	exit();
}
else if (empty($_SESSION['id_cart'])) {
	$_SESSION['errors'] = array('Your cart is empty.');
	redirect('/shop/checkout.php');
	exit();
}
else if (empty($_SESSION['checkout_billing_address_id'])) {
	$_SESSION['errors'] = array('Billing address is not set.');
	redirect('/shop/checkout.php?step=billing');
	exit();
}
else if (empty($_SESSION['checkout_shipping_address_id'])) {
	$_SESSION['errors'] = array('Shipping address is not set.');
	redirect('/shop/checkout.php?step=billing');
	exit();
}
else if (empty($_SESSION['checkout_id_delivery'])) {
	$_SESSION['errors'] = array('Delivery method is not set.');
 	redirect('/shop/checkout.php?step=shipping');
	exit();
}
else if (empty($_SESSION['checkout_payment_method_id'])) {
	$_SESSION['errors'] = array('Payment method is not set.');
 	redirect('/shop/checkout.php?step=confirmation');
	exit();
}

$payment_info = array(
	'amount' => $_POST['amount']
	, 'payment_method_id' => $_POST['payment_method_id'] // $_SESSION['checkout_payment_method_id']
	, 'cc_name' => $_POST['cc_name']
	, 'cc_number' => $_POST['cc_number']
	, 'cc_exp_month' => $_POST['cc_exp_month']
	, 'cc_exp_year' => $_POST['cc_exp_year']
	, 'cc_cvv' => $_POST['cc_cvv']
	, 'description' => 'Purchase from ' . $_SERVER['HTTP_HOST']
);

$calls = array(
	'place_order' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'id_shop' => SHOP_ID
		, 'id_lang' => LANG_ID
		, 'id_cart' => $_SESSION['id_cart']
		, 'shipping_address_id' => $_SESSION['checkout_shipping_address_id']
		, 'billing_address_id' => $_SESSION['checkout_billing_address_id']
		, 'id_delivery' => $_SESSION['checkout_id_delivery']
		, 'payment_info' => $payment_info
	)
);

$data = commerce_api_request('orders', $calls, true);


if (!empty($data['errors']) || !empty($data['data']['place_order']['errors'])) {
    $_SESSION['errors'] = api_errors_to_array($data, 'place_order');
    if( !isset($_POST['ajax']) ) {
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        echo json_encode($data);
    }
    die();
}

//charge payment_type_id
//place order
//pay out commissions to affiliate
// Clear cookie and cart session data

setcookie(SITENAME_PREFIX . "[cart]", '', time() + 1209600, '/');
unset($_SESSION['id_cart'], $_SESSION['checkout_billing_address_id'], $_SESSION['checkout_shipping_address_id'], $_SESSION['checkout_id_delivery'], $_SESSION['checkout_payment_method_id']);

if( !isset($_POST['ajax']) ) {
    redirect('/shop/post-checkout-summary?id_order=' . $data['data']['place_order']['data']['id_order']);
    die();
} else {
    echo json_encode($data);
}
?>