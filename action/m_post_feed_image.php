<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_POST) || !isset($_POST['id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

// Get feed image info
$params = array(
	'id' => $_POST['id']
);
$data = api_call('feed_image', 'get_feed_image', $params, true);

if (empty($data['errors'])) {
	$feed_image = $data['data'];
	
	// Add to image/posting
	$params = array(
		'user_id' => $_SESSION['user']['user_id']
		, 'imagename' => $feed_image['imageURL']
		, 'source' => $feed_image['source']
		, 'dimensionsX' => $feed_image['dimensionsX']
		, 'dimensionsY' => $feed_image['dimensionsY']
		, 'description' => $_POST['description']
		
		, 'id' => $_POST['id']
	);
	$data = api_call('posting', 'add_post_image', $params, true);
}
//var_dump($data);
//header( 'Location: ../mobile/post-bank.php?session_type=web' ) ;
?>