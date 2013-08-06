<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

unset_action_session_keys();

// No inputs
if (empty($_GET['id_favorite_product'])) {
	redirect($_SERVER['HTTP_REFERER']);
	die();
}

if (empty($_SESSION['user'])) {
	$_SESSION['errors'] = array('Your session has expired. Please login to continue.');
	redirect('/login.php');
	die();
}

$calls = array(
	'delete_from_wishlist' => array(
		'user_id' => $_SESSION['user']['user_id']
		, 'id_favorite_product' => $_GET['id_favorite_product']
	)
);

$data = commerce_api_request('wishlist', $calls, true);

if(!$_GET['ajax']) {
    if (!empty($data['errors']) || !empty($data['data']['delete_from_wishlist']['errors'])) {
        $_SESSION['errors'] = api_errors_to_array($data, 'delete_from_wishlist');
    }

    if (!empty($_SESSION['errors'])) {
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['success'] = 'Item removed from wishlist.';
        redirect('/shop/my-wishlist.php');
    }
} else {
    echo json_encode($data);
}

die();
?>