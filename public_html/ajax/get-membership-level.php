<?
if (empty($_GET['user_id'])) {
	die();
}

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$params = array(
	'user_id' => (int)$_GET['user_id']
);
$data = api_call('user', 'get_membership_level', $params, true);

if (!empty($data['data'])) {
	echo json_encode($data['data']);
}
?>