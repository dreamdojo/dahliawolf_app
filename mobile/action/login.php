<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	die();
}

unset_action_session_keys();

$params = array(
	'email' => $_POST['identity']
	, 'password' => $_POST['credential']
);
$data = api_call('user', 'login', $params, true);
$return_data = $data;

// Failed login
if (!empty($data['errors'])) {
	$_SESSION['errors'] = $data['errors'];
}
else {
	// Save user info to session
	$_SESSION['user'] = $data['data']['user'];
	$_SESSION['token'] = $data['data']['token'];
	setcookie("dahliaUser", serialize($_SESSION['user']), time()+36000000, "/");
	setcookie('token', $_SESSION['token'], time()+36000000, "/");
	
	// Save cart to db
	$cookie = array();
	if (!empty($_COOKIE[SITENAME_PREFIX]) && !empty($_COOKIE[SITENAME_PREFIX]['cart'])) {
		$cookie = $_COOKIE[SITENAME_PREFIX]['cart'];
	}
	$calls = array(	
		'save_cookie_cart_to_db' => array(
			'user_id'		=> $_SESSION['user']['user_id']
			, 'cart_cookie'	=> $cookie
			, 'id_shop' 	=> SHOP_ID
			, 'id_lang' 	=> LANG_ID
		)	
	);
	$data = commerce_api_request('cart', $calls, true);
	if (!empty($data['errors']) || !empty($data['data']['save_cookie_cart_to_db']['errors'])) {
		$_SESSION['errors'] = !empty($data['errors']) ? $data['errors'] : $data['data']['save_cookie_cart_to_db']['errors'];
	}
	else { // Save cart id to session
		$_SESSION['id_cart'] = $data['data']['save_cookie_cart_to_db']['data']['id_cart'];
	}
	
	// Send to account page
	if (isset($_SESSION['redirect'])) {
		$redirect = $_SESSION['redirect'];
		unset($_SESSION['redirect']);
		if( !isset($_POST['ajax']) ) {
			redirect($redirect);
			die();
		} else {
			echo json_encode($return_data);
			die();
		}
	}
	if( !isset($_POST['ajax']) ) {
		redirect('/post-details.php?session_type=web');
		die();
	} else {
		echo json_encode($return_data);
		die();
	}
}

if( !isset($_POST['ajax']) ) {
	if (!empty($_SESSION['errors'])) {
		redirect($_SERVER['HTTP_REFERER']);
	}
} else {
	echo json_encode($return_data);
}
?>