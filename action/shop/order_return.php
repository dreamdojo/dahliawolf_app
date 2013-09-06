<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$calls = array(
	'order_return' => array(
		'id_order' => $_POST['id_order']
		, 'type' => $_POST['refund_type']
		, 'quantities_map' => $_POST['id_order_detail']
		, 'product_attribute_id_map' => $_POST['product_attribute_id']
	)
);
$data = commerce_api_request('orders', $calls, true);

$errors = api_errors_to_array($data);
if (!empty($errors)) {
	$_SESSION['errors'] = $errors;
}
else {
	$_SESSION['success'] = 'Return request has been submitted.';
}

redirect($_SERVER['HTTP_REFERER']);

die();

?>