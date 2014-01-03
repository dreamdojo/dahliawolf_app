<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_REQUEST['posting_id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$params = array(
	'user_id' => $_SESSION['user']['user_id']
	, 'posting_id' => $_REQUEST['posting_id']
);
$data = api_call('posting', 'delete_post', $params, true);

//print_r($data);die();
if (!empty($data['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, NULL);
}
else {
	$_SESSION['success'] = 'Post has been deleted.';
}

redirect($_SERVER['HTTP_REFERER']);
?>