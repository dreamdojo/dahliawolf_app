<?
$self = $_SERVER['PHP_SELF'];

// Mobile should use same logic per page
$self = str_replace('/mobile', '', $self);

function default_redirect() {
	header ("Location: error_pages/404.html");
	die();
}

$_data = array();
//$_data['spine_version'] = isset($_GET['t']) ? '-1.1' : '';
$_data['spine_version'] = '-1.1';
$_data['cart'] = get_cart();

if (IS_LOGGED_IN) {
	//http://api.dahliawolf.com/api.php?api=activity_log&user_id=658&function=get_num_grouped_unread
	$params = array(
		'user_id' => $_SESSION['user']['user_id'],
	);
	$data = api_call('activity_log', 'get_num_grouped_unread', $params, true);
	$new_activity = $data['data'];

	$friends = array();
	$params = array(
		'username' => $_SESSION['user']['username'],
		//'viewer_user_id' => $_SESSION['user']['user_id']
	);

	$data = api_call('user', 'get_following', $params, true);
	$friends = $data['data'];

	$params = array(
		'user_id' => $_SESSION['user']['user_id']
	);
	$userConfig = api_call('user', 'get_user', $params, true);
	$userConfig = $userConfig['data'];
}

if ($self == '/spine.php' || $self == '/spine-chunk.php'  || $self == '/post-feed.php') {
	require DR . '/includes/php/classes/Spine' . $_data['spine_version'] . '.php';
	$spine_limit = Spine::get_spine_limit();

	$api_function = 'all_posts';

	$params = array(
		'limit' => $spine_limit
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
		else if ($_GET['sort'] == 'following' && !empty($_SESSION['user'])) {
			$params['filter_by'] = 'following';
			$params['follower_user_id'] = $_SESSION['user']['user_id'];
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

	// Spine needs pinterest/instagram username for Posting
	if (IS_LOGGED_IN && $self == '/spine.php') {
		$user_params = array(
			'user_id' => $_SESSION['user']['user_id']
		);
		$data = api_call('user', 'get_user', $user_params, true);
		$_data['user'] = $data['data'];
	}
}
else if ($self == '/post-details.php' || $self ==  '/post-details-pop.php') {
	// Post
	if(isset($_GET['posting_id'])){
		$params = array(
			'posting_id' => $_GET['posting_id']
		);
	}
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	$data = api_call('posting', 'get_post', $params, true);
	$_data['post'] = $data['data'];

	// Likes
	$data = api_call('posting', 'get_post_likes', $params, true);
	$_data['post_likes'] = $data['data'];

	// Comments
	$data = api_call('comment', 'get_post_comments', $params, true);
	$_data['comments'] = $data['data'];
}
else if ($self == '/vote.php' || $self == '/explore.php' || $self == '/welcome_two.php') {
	require DR . '/includes/php/classes/Spine' . $_data['spine_version'] . '.php';
	$spine_limit = Spine::get_spine_limit();

	// Get vote posts for current voting period
	$params = array(
		//'limit' => $spine_limit
	);
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	$data = api_call('posting', 'get_vote_posts', $params, true);
	$_data['posts'] = $data['data'];
}
else if ($self == '/profile.php') {
	require DR . '/includes/php/classes/Spine' . $_data['spine_version'] . '.php';
	$spine_limit = Spine::get_spine_limit();

	if (empty($_GET['username'])) {
		default_redirect();
	}

	$params = array(
		'username' => strtolower($_GET['username'])
		, 'limit' => $spine_limit
	);

	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	$data = api_call('user', 'get_user', $params, true);
	$_data['user'] = $data['data'];
	if (empty($_data['user'])) {
		default_redirect();
	}

	// View Posts / Wild 4s
	$_data['view'] = isset($_GET['view']) ? $_GET['view'] : 'posts';
	$params = array(
		'user_id' => $_data['user']['user_id']
		, 'limit' => $spine_limit
	);
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	// Posts
	if ($_data['view'] == 'posts') {
		$posts_data = api_call('posting', 'all_posts', $params, true);

		$_data['spine_chunk_url'] = '/spine-chunk.php';
	}
	// Wild 4s
	else if ($_data['view'] == 'wild-4s') {
		$posts_data = api_call('posting', 'get_liked_posts', $params, true);

		$_data['spine_chunk_url'] = '/spine-chunk.php?type=wild-4';
	}
	if (!empty($posts_data)) {
		$_data['posts'] = $posts_data['data'];
	}

	// My Runway
	$calls = array(
		'get_products' => array(
			'id_shop' => SHOP_ID
			, 'id_lang' => LANG_ID
			, 'user_id' => $_data['user']['user_id']
		)
	);

	$data = commerce_api_request('product', $calls, true);
	$_data['products'] = $data['data']['get_products']['data'];
}
else if ($self == '/my-runway.php') {
	if (empty($_GET['username'])) {
		default_redirect();
	}

	// Get user_id
	$params = array(
		'username' => $_GET['username']
	);
	$data = api_call('user', 'get_user', $params, true);

	// Get products
	$calls = array(
		'get_products' => array(
			'id_shop' => SHOP_ID
			, 'id_lang' => LANG_ID
			, 'user_id' => $data['data']['user_id']
		)
	);

	$data = commerce_api_request('product', $calls, true);
	$_data['products'] = $data['data']['get_products']['data'];
}
else if ($self == '/followers.php') {
	if (empty($_GET['username'])) {
		default_redirect();
	}

	$params = array(
		'username' => $_GET['username']
	);
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	$data = api_call('user', 'get_followers', $params, true);
	$_data['followers'] = $data['data'];
	$_data['user']['username'] = $_GET['username'];
}
else if ($self == '/following.php') {
	if (empty($_GET['username'])) {
		default_redirect();
	}

	$params = array(
		'username' => $_GET['username']
	);
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	$data = api_call('user', 'get_following', $params, true);
	$_data['following'] = $data['data'];
	$_data['user']['username'] = $_GET['username'];
}
else if ($self == '/account/posts.php') {
	if (empty($_SESSION['user']) || empty($_SESSION['user']['user_id'])) {
		default_redirect();
	}

	require DR . '/includes/php/classes/Spine' . $_data['spine_version'] . '.php';
	$spine_limit = Spine::get_spine_limit();

	$params = array(
		'user_id' => $_SESSION['user']['user_id']
		, 'limit' => $spine_limit
	);
	$data = api_call('posting', 'all_posts', $params, true);
	$_data['posts'] = $data['data'];
}
else if ($self == '/account/wild-4s.php') {
	if (empty($_SESSION['user']) || empty($_SESSION['user']['user_id'])) {
		default_redirect();
	}

	require DR . '/includes/php/classes/Spine' . $_data['spine_version'] . '.php';
	$spine_limit = Spine::get_spine_limit();

	$params = array(
		'user_id' => $_SESSION['user']['user_id']
		, 'limit' => $spine_limit
	);
	$data = api_call('posting', 'get_liked_posts', $params, true);
	$_data['posts'] = $data['data'];
}
else if ($self == '/account/settings.php') {
	if (empty($_SESSION['user']) || empty($_SESSION['user']['user_id'])) {
		default_redirect();
	}

	$params = array(
		'user_id' => $_SESSION['user']['user_id']
	);
	$data = api_call('user', 'get_user', $params, true);
	$_data['user'] = $data['data'];
}
else if ($self == '/wolf-pack.php') {
	$params = array(
		'limit' => 100
	);
	$data = api_call('user', 'get_top_ranked', $params, true);
	$_data['users'] = $data['data'];

	$params = array(
		'user_id' => $_SESSION['user']['user_id']
	);
	$data = api_call('user', 'get_rank', $params, true);
	$_data['rank'] = $data['data'];
}
?>