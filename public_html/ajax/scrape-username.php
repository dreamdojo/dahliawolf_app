<?
if (empty($_GET['user_id'])) {
	die();
}

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$params = array(
	'user_id' => $_GET['user_id']
	, 'username' => $_GET['username']
	, 'domain_keyword' => !empty($_GET['domain_keyword']) ? $_GET['domain_keyword'] : NULL
);
$data = api_call('feed_image', 'scrape_username', $params, true);
?>