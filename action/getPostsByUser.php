<?
	require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

	if( !empty($_POST['post_user_id']) ){
	
		if (IS_LOGGED_IN) {
			$params['viewer_user_id'] = $_SESSION['user']['user_id'];
		}
			
		// View Posts / Wild 4s
		$params = array(
			'user_id' => $_POST['post_user_id']
			, 'limit' => $_POST['limit']
		);
		
		if (!empty($_POST['offset'])) {
			$params['offset'] = $_POST['offset'];
		}
		
		if (IS_LOGGED_IN) {
			$params['viewer_user_id'] = $_SESSION['user']['user_id'];
		}
		
		$posts_data = api_call('posting', 'all_posts', $params, true);
		
		header('Content-Type: application/json');
		
		echo json_encode($posts_data);
	}
?>