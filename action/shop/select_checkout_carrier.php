<?
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
else { // Set session delivery id
	$_SESSION['checkout_id_delivery'] = $_POST['id_delivery'];
	redirect('/shop/checkout.php?step=confirmation');
	exit();
}

redirect($_SERVER['HTTP_REFERER']);
exit();
?>