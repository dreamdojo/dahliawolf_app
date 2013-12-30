<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	die();
}

// API call
$calls = array(
	'save_password' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'password' => $_POST['password']
		, 'password_old' => $_POST['password_old']
	)
);

$data = api_request('user', $calls, true);

// Failed saving pw
if (!empty($data['errors']) || !empty($data['data']['save_password']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'save_password');
}
// Successful
else {
	$_SESSION['success'] = 'Password has been changed.';
	
	// Send to account page
	redirect('/account/settings.php');
}

// If errors, send user back to change pw form
if (!empty($_SESSION['errors'])) {
	redirect($_SERVER['HTTP_REFERER']);
}
?>