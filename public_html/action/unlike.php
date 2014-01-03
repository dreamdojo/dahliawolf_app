<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_REQUEST['posting_id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$params = array(
	'user_id' => $_SESSION['user']['user_id']
	, 'posting_id' => $_REQUEST['posting_id']
	, 'like_type_id' => 1
);
$data = api_call('posting', 'delete_post_like', $params);

if (isset($_REQUEST['ajax'])) {
	echo $data;
}

//var_dump($data);
?>