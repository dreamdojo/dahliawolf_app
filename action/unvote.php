<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_REQUEST['posting_id']) || !isset($_REQUEST['vote_period_id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$params = array(
	'user_id' => $_SESSION['user']['user_id']
	, 'posting_id' => $_REQUEST['posting_id']
	, 'vote_period_id' => $_REQUEST['vote_period_id']
);
$data = api_call('posting', 'delete_post_vote', $params);

var_dump($data);
?>