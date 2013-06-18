<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_POST['emails']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$_REQUEST['emails'] = array_filter($_REQUEST['emails']);

$params = array(
	'emails' => $_REQUEST['emails']
	, 'user_id' => $_SESSION['user']['user_id']
);
$data = api_call('social', 'invite', $params, true);

//var_dump($data);

// Failed
if (!empty($data['errors'])) {
	$_SESSION['errors'] = $data['errors'];
}
else {
	$_SESSION['success'] = 'Your invitiation has been sent.';
}

redirect($_SERVER['HTTP_REFERER']);
die();
?>