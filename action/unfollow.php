<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_REQUEST['user_id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$params = array(
	'user_id' => $_REQUEST['user_id']
	, 'follower_user_id' => $_SESSION['user']['user_id']
);
$data = api_call('user', 'unfollow', $params);

//var_dump($data);
?>