<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_REQUEST['activity_log_id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$params = array(
	'user_id' => $_SESSION['user']['user_id']
	,'activity_log_id' => $_GET['activity_log_id']
);
$data = api_call('activity_log', 'mark_read', $params);
var_dump($data);
?>