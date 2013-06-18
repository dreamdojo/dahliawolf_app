<?
if (empty($_GET['user_id'])) {
	die();
}

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$params = array(
	'user_id' => $_GET['user_id']
);
$data = api_call('user', 'get_points', $params, true);

if (!empty($data['data'])) {
	echo $data['data'];
}
?>