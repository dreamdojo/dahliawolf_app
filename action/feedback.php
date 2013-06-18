<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}
if (!isset($_POST['message']) || $_POST['message'] == '') {
	$_SESSION['errors'] = array('Feedback was blank.');
	redirect($_SERVER['HTTP_REFERER']);
	die();
}


$params = array(
	'user_id' => $_SESSION['user']['user_id']
	, 'message' => $_POST['message']
);
$data = api_call('social', 'feedback', $params, true);

//var_dump($data);die();

// Failed
if (!empty($data['errors'])) {
	$_SESSION['errors'] = $data['errors'];
	redirect($_SERVER['HTTP_REFERER']);
	die();
}

redirect($_SERVER['HTTP_REFERER'] . '?sent=1');
die();
?>