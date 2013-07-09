<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_POST) || empty($_SESSION['user'])) {
	die();
}

// Avatar
$avatar_destination = NULL;
if (!empty($_FILES['avatar']['name'])) {
	$path = DR . AVATARPATH;
	$maxSize = str_replace('M', '', ini_get('upload_max_filesize')) * 1000 * 1024; // bytes
	$uploadResults = file_upload('avatar', $path, $maxSize, array('jpg', 'jpeg', 'png', 'gif'));
	if (!is_array($uploadResults)) { // upload failed
		$_SESSION['errors'] = 'Upload failed due to error: ' . $uploadResults;
	}
	else {
		$destination = $path . $_SESSION['user']['user_id'];
		if (file_exists(destination)) {
			unlink($destination);
		}
		rename($uploadResults[0], $destination);

		$avatar_destination = AVATARFILE . $_SESSION['user']['user_id'];
	}
}

// API call
$calls = array(
	'save_user' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'first_name' => $_POST['first_name']
		, 'last_name' => $_POST['last_name']
		, 'date_of_birth' => !empty($_POST['date_of_birth']) ? date('Y-m-d', strtotime($_POST['date_of_birth'])) : NULL
		, 'gender' => $_POST['gender']
		, 'email' => $_POST['email']
		, 'username' => $_POST['username']
		//, 'password' => $_POST['user_password']
		, 'api_website_id' => API_WEBSITE_ID
	)
);
$data = api_request('user', $calls, true);

// Failed save
if (!empty($data['errors']) || !empty($data['data']['save_user']['errors'])) {
	$_SESSION['errors'] = api_errors_to_array($data, 'save_user');
}
// Successful save
else {
	// Update session
	// loop through session['user'] keys to update values
	foreach ($_SESSION['user'] as $key => $value) {
		if (isset($_POST[$key])) {
			$_SESSION['user'][$key] = $_POST[$key];
		}
	}

	// Save to local db
	$user_params = array(
		'user_id' => $_SESSION['user']['user_id']
		, 'username' => $_POST['username']
		, 'email_address' => $_POST['email']
		, 'first_name' => $_POST['first_name']
		, 'last_name' => $_POST['last_name']
		, 'gender' => $_POST['gender']
		, 'date_of_birth' => !empty($_POST['date_of_birth']) ? date('Y-m-d', strtotime($_POST['date_of_birth'])) : NULL
		, 'about' => $_POST['about']
		, 'location' => $_POST['location']
		, 'website' => $_POST['website']

		, 'facebook_post' => $_POST['facebook_post']
		, 'instagram_import' => $_POST['instagram_import']
		, 'instagram_username' => $_POST['instagram_username']
		, 'pinterest_username' => $_POST['pinterest_username']
		//, 'comment_notifications' => $_POST['comment_notifications']
		//, 'like_notifications' => $_POST['like_notifications']
		, 'notification_interval' => $_POST['notification_interval']
	);
	if (!empty($avatar_destination)) {
		$user_params['avatar'] = $avatar_destination;
	}

	$data = api_call('user', 'update_user', $user_params);

	$_SESSION['success'] = 'Account settings have been updated.';
}

redirect($_SERVER['HTTP_REFERER']);
die();
?>