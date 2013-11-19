<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_POST) || !isset($_POST['id']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$get_bank_images_calls = array(
    'get_bank_images' => array(
        'user_id' => $_SESSION['user']['user_id'],
        'repo_image_id' => $_POST['id'],
        'use_hmac_check' => 0,
        'limit_per_day' => 1
    )
);

$user_bank_images = api_request('posting', $get_bank_images_calls, true);
//echo "<!-- ".var_export($user_bank_images, true). " -->";

if($user_bank_images && $user_bank_images != null && @count($user_bank_images['data']['get_bank_images']['data']) >= 5 )
{
    //sorry pal no mo images fo u!!!
    echo json_encode( array(
                        'error' => "Sorry due to high demand we have temporally limited the number of images you can post from the D\W Image Bank to 5 per day",
                        'data' => null,
                        'posting_id' => null
    ));
}else
{
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

        ////post the image
        $data = api_call('posting', 'add_post_image', $params, true);

        header('Content-Type: application/json');
        echo json_encode($data['data']);

    }
}
?>