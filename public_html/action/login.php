<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST)) {
	die();
}

unset_action_session_keys();

$params = array(
	'email' => $_POST['identity'],
	'password' => $_POST['credential']
);
$data = api_call('user', 'login', $params, true);

// Failed login
if (!empty($data['errors'])) {
	$_SESSION['errors'] = $data['errors'];
}
else {
	// Make sure customer exists on commerce
	$calls = array(	
		'get_customer' => array(
			'user_id' => $data['data']['user']['user_id']
		)	
	);
	$data_customer = commerce_api_request('customer', $calls, true);
	if (!empty($data_customer['errors']) || !empty($data_customer['data']['get_customer']['errors'])) {
		$_SESSION['errors'] = !empty($data_customer['errors']) ? $data_customer['errors'] : $data_customer['data']['get_customer']['errors'];
		
		// Log out of admin
		$calls = array(
			'logout' => array(
				'user_id' => $data['data']['user']['user_id']
				, 'token' => $data['data']['token']
			)
		);
		$data = api_request('user', $calls, true);
	}
	else if (empty($data_customer['data']['get_customer']['data'])) {
		$_SESSION['errors'] = array('User is not a customer.');
		
		// Log out of admin
		$calls = array(
			'logout' => array(
				'user_id' => $data['data']['user']['user_id']
				, 'token' => $data['data']['token']
			)
		);
		$data = api_request('user', $calls, true);
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
	}
}

setcookie("dahliaUser", serialize($_SESSION['user']), time()+36000000, "/");


// If errors, send user back to login form
if (!empty($_SESSION['errors'])) {
    if(empty($_POST['ajax'])) {
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        echo json_encode($_SESSION['errors']);
        unset($_SESSION['errors']);
    }

}
else {
	// Send to account page
	if(empty($_POST['ajax'])) {
        if (isset($_SESSION['redirect'])) {
            $redirect = $_SESSION['redirect'];
            unset($_SESSION['redirect']);

            redirect($redirect);
            die();
        }
        redirect('/');
    } else {
        echo json_encode(array('success', true));
    }
}
die();
?>