<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	die();
}



unset_action_session_keys();

// Save user (handles admin + commerce)
$user_params = array(
	//'first_name' => $_POST['user_fname']
	//, 'last_name' => $_POST['user_lname']
	 'email' => $_POST['user_email']
	, 'username' => $_POST['user_username']
	, 'password' => $_POST['user_password']
	, 'api_website_id' => API_WEBSITE_ID
);
$data = api_call('user', 'register', $user_params, true);
/*if($_POST['user_captcha_solution'] != $_SESSION['rand_code']) {
	//throw captcha error
	$data['errors'][] = "incorrect image code";
}*/
if (!empty($data['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, NULL);

	redirect('/signup.php');
	die();
}

$user = $data['data']['user'];
$token = $data['data']['token'];

// Save cart to db
$cookie = array();
if (!empty($_COOKIE[SITENAME_PREFIX]) && !empty($_COOKIE[SITENAME_PREFIX]['cart'])) {
	$cookie = $_COOKIE[SITENAME_PREFIX]['cart'];
}
$calls = array(
	'save_cookie_cart_to_db' => array(
		'user_id'		=> $user['user_id']
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
	$_SESSION['id_cart'] = !empty($data['data']['save_cookie_cart_to_db']['data']) ? $data['data']['save_cookie_cart_to_db']['data']['id_cart'] : NULL;
}

// Save user info to session
$_SESSION['user'] = $user;
$_SESSION['token'] = $token;

// Send to account page
redirect('/');
?>