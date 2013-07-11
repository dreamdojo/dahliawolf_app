<?
session_start();
define('IS_LOGGED_IN', !empty($_SESSION) && !empty($_SESSION['user']) && !empty($_SESSION['token']));

if (IS_LOGGED_IN) {
	require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/functions-api.php';
	
	$user_id = $_SESSION['user']['user_id'];
	$upload_dir = '/postings/uploads/';
	$source = 'http://' . $_SERVER['HTTP_HOST'] . $upload_dir;
	
	// get contents of remote file & save
	$imagename = time() . basename($_POST['image_src']);
	$image_url = $_SERVER['DOCUMENT_ROOT'] . $upload_dir . $imagename;
	
	// Grab and save remote image
	$image = @file_get_contents($_POST['image_src']);
	
	if ($image) {
		file_put_contents($image_url, $image);
		$dimensions = @getimagesize($image_url);
		
		// make api to add_post_image
		$params = array(
			'imagename' => $imagename
			, 'source' => $source
			, 'user_id' => $user_id
			, 'description' => $_POST['description']
            , 'domain' => $_POST['domain']
            , 'attribution_url' => $_POST['sourceurl']
			, 'dimensionsX' => $dimensions[0]
			, 'dimensionsY' => $dimensions[1]
		);
		$data = api_call('posting', 'add_post_image', $params);
		header('Content-Type: application/json');
		echo json_encode($data);	
	}
}else{
	echo 'better login foo';
}?>