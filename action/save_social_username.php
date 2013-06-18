<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST) || empty($_SESSION['user'])) {
	die();
}

if (!empty($_POST['instagram_username']) || !empty($_POST['pinterest_username'])) {
	// Save to local db
	$user_params = array(
		'user_id' => $_SESSION['user']['user_id']
	);
	if (!empty($_POST['instagram_username'])) {
		$user_params['instagram_username'] = $_POST['instagram_username'];
	}
	if (!empty($_POST['pinterest_username'])) {
		$user_params['pinterest_username'] = $_POST['pinterest_username'];
	}
	
	$data = api_call('user', 'update_user_optional', $user_params, true);
}
die();
?>