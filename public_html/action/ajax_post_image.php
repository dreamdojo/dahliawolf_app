<?php
//http://api.dahliawolf.com/api.php?api=posting&function=add_post_image&userid=&imagename=&source=

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (!isset($_REQUEST['src']) || !isset($_SESSION) || !isset($_SESSION['user'])) {
	die();
}

$userId = $_SESSION['user']['user_id'];
$img = $_REQUEST['src'];
$name = $_REQUEST['name'];
$tags = $_REQUEST['description'];

$params = array();
	$params = array(
		'user_id' => $userId,
		'imagename' => $name,
		'source' => $img,
		'description' => $tags
	);
	
$data = api_call('posting', 'add_post_image', $params);

var_dump($data);
?>