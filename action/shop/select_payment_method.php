<?
die();

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (empty($_SESSION['id_cart'])) {
	$_SESSION['errors'] = array('Your session has expired.');
}
else if (empty($_SESSION['checkout_shipping_address_id'])) {
	$_SESSION['errors'] = array('Shipping address is not set.');
}
else if (empty($_SESSION['checkout_billing_address_id'])) {
	$_SESSION['errors'] = array('Billing address is not set.');
}
else if (empty($_POST['payment_method_id'])) {
	$_SESSION['errors'] = array('Payment method is not set.');
}
else { // Set session delivery id

	$_SESSION['checkout_payment_method_id'] = $_POST['payment_method_id'];
	redirect('/shop/checkout.php?step=confirmation');
	exit();
}

redirect($_SERVER['HTTP_REFERER']);
exit();
?>