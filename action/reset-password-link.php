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
	'reset_password_link' => array(
		'email' => $_POST['email']
	)
);
$data = api_request('user', $calls, true);

// Failed
if (!empty($data['errors']) || !empty($data['data']['reset_password_link']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'reset_password_link');
}
// Successful
else {
	$_SESSION['success'] = 'A link to reset your password has been emailed to you.';
}

redirect($_SERVER['HTTP_REFERER']);
die();
?>