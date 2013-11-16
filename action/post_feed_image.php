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
		, 'repo_image_id' => $_POST['id']
		, 'imagename' => $feed_image['imageURL']
		, 'source' => $feed_image['source']
		, 'dimensionsX' => $feed_image['dimensionsX']
		, 'dimensionsY' => $feed_image['dimensionsY']
		, 'description' => $_POST['description']
		
		//, 'id' => $_POST['id']
	);



    // Add to image/posting
    $bank_images_params = array(
        'user_id' => $_SESSION['user']['user_id'],
        'repo_image_id' => $_POST['id'],
        'use_hmac_check' => '0',
    );

    $user_bank_images = api_request('posting', 'get_bank_images', $bank_images_params, true);
    echo "<!-- ".var_export($user_bank_images, true). " -->";


    ////
    $data = api_call('posting', 'add_post_image', $params, true);

	header('Content-Type: application/json');
	echo json_encode($data['data']);
}
?>