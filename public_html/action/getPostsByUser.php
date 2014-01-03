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

        if (!empty($_POST['order_by'])) {
            $params['order_by'] = $_POST['order_by'];
        }

        if(!empty($_POST['filter'])) {
            $params['filter'] = $_POST['filter'];
        }
		
		if (IS_LOGGED_IN) {
			$params['viewer_user_id'] = $_SESSION['user']['user_id'];
		}
		
		if($_POST['feed'] == 'loves') {
            $posts_data = api_call('posting', 'get_liked_posts', $params, true);
        } else {
            $posts_data = api_call('posting', 'all_posts', $params, true);
        }
		
		header('Content-Type: application/json');
		
		echo json_encode($posts_data);
	}
?>