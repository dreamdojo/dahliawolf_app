<?
	require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
	//require '/includes/php/initial-calls.php';
	
	$api_function = 'all_posts';
		
	$params = array(
		'limit' => $_GET['limit']
	);
	
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	
	// Username is used for profile page
	if (!empty($_GET['username'])) {
		$user_params = array(
			'username' => $_GET['username']
		);
		$data = api_call('user', 'get_user', $user_params, true);
		$user = $data['data'];
	
		$params['user_id'] = $user['user_id'];
	}
	
	if (!empty($_GET['offset'])) {
		$params['offset'] = $_GET['offset'];
	}
	
	// Timestamp
	if (!empty($_GET['timestamp'])) {
		$params['timestamp'] = $_GET['timestamp'];
	}
	
	// Sort
	if (!empty($_GET['sort'])) {
		if ($_GET['sort'] == 'top' || $_GET['sort'] == 'hot') {
			$params['order_by'] = 'total_likes';
			if ($_GET['sort'] == 'hot') {
				$params['like_day_threshold'] = '30';
			}
		}
	}
	
	// Search
	if (!empty($_GET['q'])) {
		$params['q'] = $_GET['q'];
		
		// Also get users
		$users_params = array(
			'username_like' => $_GET['q']
		);
		if (IS_LOGGED_IN) {
			$users_params['viewer_user_id'] = $_SESSION['user']['user_id'];
		}
		$users_data = api_call('user', 'get_users', $users_params, true);
		$_data['users'] = $users_data['data'];
	}
	// Wild-4
	if (!empty($_GET['view']) && $_GET['view'] == 'wild-4s') {
		$api_function = 'get_liked_posts';
	}
	
	$data = api_call('posting', $api_function, $params, true);
	$_data['posts'] = $data['data'];
	
	$result = json_encode($_data['posts']);

	echo $result;
?>