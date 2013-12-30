<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if(isset($_COOKIE["dahliaUser"])){
	setcookie("dahliaUser", '', time()-36000000, "/");
	setcookie('token', '', time()-36000000, "/");
}

if (!empty($_SESSION['logout_url'])) {
	$logout_url = $_SESSION['logout_url'];
	session_unset();
	redirect($logout_url);
	die();
}
else {
	// API call
	if (!empty($_SESSION['user'])) {
		$calls = array(
			'logout' => array(
				'user_id' => $_SESSION['user']['user_id']
				, 'token' => $_SESSION['token']
			)
		);
		$data = api_request('user', $calls, true);
	}
	else {
		$data = NULL;
	}
	
	session_unset();
	
	//edit_action_redirect($data, 'logout', 'You have been logged out.', HEADER_LOCATION_PREFIX . '/index.php?session_type='.$_GET['session_type'].'');
	edit_action_redirect($data, 'logout', NULL, HEADER_LOCATION_PREFIX . '/index.php?session_type='.$_GET['session_type'].'');
}
?>