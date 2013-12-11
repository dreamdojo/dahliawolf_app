<?
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

date_default_timezone_set('America/Los_Angeles');

define('API_KEY_DEVELOPER', 'b968a167feba0990b283f0cd65757a60');
define('PRIVATE_KEY_DEVELOPER', '796323f65ce5f0178dc15e8181c17247');
define('API_WEBSITE_ID', 2);

//twitter
define('CONSUMER_KEY', 'xVzOVRVsutyv6M5zTBblVg');
define('CONSUMER_SECRET', 'QgiSMOFeNLOrpJdIl7ejZeDU6vFCUqMPTKzu66r5wk');
define('OAUTH_CALLBACK', 'http://www.dahliawolf.com/callback.php');

define('IMAGE_UPLOAD_DIR', '/postings/uploads/');

define('DR', $_SERVER['DOCUMENT_ROOT']);
define('AVATARPATH', '/uploads/avatars/');
define('AVATARFILE', 'http://' . $_SERVER['SERVER_NAME'] . '/avatar.php?user_id=');

define('CDN', 'http://content.dahliawolf.com');
define('CDN_IMAGE_SCRIPT', CDN . '/shop/product/image.php?file_id=');

define('SHOP_ID', 3);
define('LANG_ID', 1);

define('SITENAME_PREFIX', 'dh');
define('DAHLIAWOLF_MOBILE', 'http://'.$_SERVER['SERVER_NAME'].'/mobile/');


require $_SERVER['DOCUMENT_ROOT'] . '/lib/php/API.php';
require $_SERVER['DOCUMENT_ROOT'] . '/lib/php/Commerce_API.php';
require $_SERVER['DOCUMENT_ROOT'] . '/lib/php/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/functions-format.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/functions-api.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/functions-markup.php';
require_once( $_SERVER['DOCUMENT_ROOT'] . '/lib/twitteroauth/twitteroauth.php');

// Mobile
$path_parts = explode('/', $_SERVER['REQUEST_URI']);
$top_dir = $path_parts[1];
$ref_top_dir = NULL;
if (!empty($_SERVER['HTTP_REFERER'])) {
	$ref_uri_parts = explode($_SERVER['SERVER_NAME'], $_SERVER['HTTP_REFERER']);
	if (!empty($ref_uri_parts[1])) {
		$ref_uri = $ref_uri_parts[1];
		$ref_path_parts = explode('/', $ref_uri);
		$ref_top_dir = $ref_path_parts[1];
	}
}
define('IS_MOBILE', $top_dir == 'mobile' || $ref_top_dir == 'mobile');
define('HEADER_LOCATION_PREFIX', IS_MOBILE ? '/mobile' : '');
define('CR', HEADER_LOCATION_PREFIX);

$_GET['session_type'] = !empty($_GET['session_type']) ? $_GET['session_type'] : '';

$query_string_append = '';
if (!empty($_GET['session_type'])) {
	$query_string_append .= 'session_type=' . $_GET['session_type'];
}

define('QUERY_STRING_APPEND', $query_string_append);

// Token login
if (!empty($_GET['user_id']) && !empty($_GET['token'])) {
	$params = array(
		'user_id' => $_GET['user_id']
		, 'token' => $_GET['token']
	);
	$data = api_call('user', 'token_login', $params, true);
	$_SESSION['user'] = $data['data']['user'];
	$_SESSION['token'] = $data['data']['token'];
}

define('IS_LOGGED_IN', !empty($_SESSION) && !empty($_SESSION['user']) && !empty($_SESSION['token']));
define('TWITTER_IS_LOGGED_IN', !empty($_SESSION) && !empty($_SESSION['access_token']));
define('INSTAGRAM_IS_LOGGED_IN', !empty($_SESSION) && !empty($_SESSION['user']['instagramToken']));
?>