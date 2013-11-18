<?
$self = $_SERVER['PHP_SELF'];

// Mobile should use same logic per page
$self = str_replace('/mobile', '', $self);

function default_redirect() {
	header ("Location: error_pages/404.html");
	die();
}

$_data = array();

$_data['cart'] = get_cart();

if (IS_LOGGED_IN) {
	/*$params = array(
		'user_id' => $_SESSION['user']['user_id'],
	);
	$data = api_call('activity_log', 'get_num_grouped_unread', $params, true);
	$new_activity = $data['data'];*/

	$friends = array();
	$params = array(
		'username' => $_SESSION['user']['username'],
		'viewer_user_id' => $_SESSION['user']['user_id']
	);

	$data = api_call('user', 'get_following', $params, true);
	$friends = $data['data'];

	$params = array(
		'user_id' => $_SESSION['user']['user_id']
	);
	$userConfig = api_call('user', 'get_user', $params, true);
	$userConfig = $userConfig['data'];
}

?>