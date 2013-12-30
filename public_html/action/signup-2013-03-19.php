<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	die();
}

unset_action_session_keys();

// API call
$calls = array(
	'save_user' => array(
		'first_name' => $_POST['user_fname']
		, 'last_name' => $_POST['user_lname']
		//, 'date_of_birth' => $dob
		, 'email' => $_POST['user_email']
		, 'username' => $_POST['user_username']
		, 'password' => $_POST['user_password']
		, 'api_website_id' => API_WEBSITE_ID
	)
);

$data = api_request('user', $calls, true);

// Failed registration
if (!empty($data['errors']) || !empty($data['data']['save_user']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'save_user');
}
// Successful registration
// Login the user
else {
	$user_id = $data['data']['save_user']['data']['user_id'];
	// Create customer
	$calls = array(	
		'save_customer' => array(
			'user_id' => $user_id
			, 'firstname' => $_POST['user_fname']
			, 'lastname' => $_POST['user_lname']
			, 'email' => $_POST['user_email']
			, 'username' => $_POST['user_username']
		)
	);
	
	$data = commerce_api_request('customer', $calls, true);
	if (!empty($data['errors']) || !empty($data['data']['save_customer']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'save_customer');
		redirect($_SERVER['HTTP_REFERER']);
		exit();
	}
	else {
		// Save cart to db
		$cookie = array();
		if (!empty($_COOKIE[SITENAME_PREFIX]) && !empty($_COOKIE[SITENAME_PREFIX]['cart'])) {
			$cookie = $_COOKIE[SITENAME_PREFIX]['cart'];
		}
		$calls = array(	
			'save_cookie_cart_to_db' => array(
				'user_id'		=> $user_id
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

		$calls = array(
			'login' => array(
				'email' => $_POST['user_email']
				, 'password' => $_POST['user_password']
			)
		);
		$data = api_request('user', $calls, true);
		
		// Save user info to session
		$_SESSION['user'] = $data['data']['login']['data']['user'];
		$_SESSION['token'] = $data['data']['login']['data']['token'];
		
		// Save user to local db
		$user_params = array(
			'user_id' => $_SESSION['user']['user_id']
			, 'username' => $_POST['user_username']
			, 'email_address' => $_POST['user_email']
		);
		$data = api_call('user', 'add_user', $user_params);
	}
	
	// Send to account page
	redirect('/spine.php');
}

// If errors, send user back to registration form
if (!empty($_SESSION['errors'])) {
	redirect($_SERVER['HTTP_REFERER']);
}
?>