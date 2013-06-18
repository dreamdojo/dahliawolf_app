<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_POST['posting_id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$params = array(
	'user_id' => $_SESSION['user']['user_id']
	, 'posting_id' => $_POST['posting_id']
	, 'comment' => $_POST['comment']
);
$data = api_call('comment', 'add_comment', $params);

//var_dump($data);
if (!isset($_POST['ajax'])) {
	redirect($_SERVER['HTTP_REFERER']);
}
else {
	header('Content-Type: application/json');
	echo json_encode($data);
}
?>