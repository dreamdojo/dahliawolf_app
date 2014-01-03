<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST) || empty($_POST['email'])) {
	$_SESSION['errors'] = array('Email is required.');
	redirect('/reset-password-link');
	die();
}

// API call
$calls = array(
	'reset_password' => array(
		'email' => $_POST['email']
		, 'password' => $_POST['password']
		, 'key' => $_POST['key']
	)
);
$data = api_request('user', $calls, true);

// Failed
if (!empty($data['errors']) || !empty($data['data']['reset_password']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'reset_password');
}
// Successful
else {
	$_SESSION['success'] = 'Password has been reset.';
	redirect('/login');
	die();
}

redirect($_SERVER['HTTP_REFERER']);
die();
?>