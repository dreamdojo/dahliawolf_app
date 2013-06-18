<?
if (empty($_GET['posting_id'])) {
	die();
}

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$params = array(
	'posting_id' => $_GET['posting_id']
	, 'vote_period_id' => $_GET['vote_period_id']
);
$data = api_call('posting', 'get_num_post_votes', $params, true);

if (!empty($data['data'])) {
	echo $data['data'];
}
?>