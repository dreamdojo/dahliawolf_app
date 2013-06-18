<?
$pageTitle = "Post";
include "head.php";
include "header.php";
include "post_slideout.php";

	require DR . '/includes/php/classes/Spine-1.1.php';
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

//require 'includes/php/classes/Spine' . $_data['spine_version'] . '.php';
$Spine = new Spine();

if(isset($_GET['q']) && count($_data['users'])):?>
<div class="user-results">
	<div class="results-title">USERS:</div>
	<?php list_users($_data['users']) ?>
</div>
<? endif ?>
<?php
$Spine->output($_data['posts']);
?>
<?php include "footer.php" ?>
