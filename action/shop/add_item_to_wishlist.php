<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// No inputs
if (empty($_GET)) {
	die();
}

unset_action_session_keys();

$calls = array(
		'add_wishlist' => array(
			'id_customer' => $_SESSION['user']['user_id']
			, 'id_product' => $_GET['id_product']
			, 'id_shop' => SHOP_ID
			, 'id_lang' => LANG_ID
		)
	);

	$data = commerce_api_request('wishlist', $calls, true);
	
	if (!empty($data['errors']) || !empty($data['data']['add_wishlist']['errors'])) {
		$_SESSION['errors'] = api_errors_to_array($data, 'add_wishlist');
	}

if(!$_GET['ajax']) {
    if (!empty($_SESSION['errors'])) {
        redirect($_SERVER['HTTP_REFERER']);
    }
    else {
        redirect('/shop/my-wishlist.php');
    }
} else {
    echo json_encode($data);
}
die();
?>