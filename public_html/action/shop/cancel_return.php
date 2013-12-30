<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

unset_action_session_keys();

if (empty($_SESSION['user']['user_id'])) {
	$_SESSION['errors'] = array('Your session has expired. Please login to continue.');
	redirect('/login.php');
	exit();
}

$calls = array(
	'cancel_order_return' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'id_order_detail_return' => $_GET['id_order_detail_return']
	)
);
$data = commerce_api_request('orders', $calls, true);

$errors = api_errors_to_array($data);
if (!empty($errors)) {
	$_SESSION['errors'] = $errors;
}
else {
	$_SESSION['success'] = 'Return request has been cancelled.';
}

redirect($_SERVER['HTTP_REFERER']);

die();
?>