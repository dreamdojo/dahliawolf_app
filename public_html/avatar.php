<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$user_id = !empty($_GET['user_id']) ? $_GET['user_id'] : NULL;
$width = !empty($_GET['width']) ? (int)$_GET['width'] : NULL;
$height = !empty($_GET['height']) ? (int)$_GET['height'] : NULL;
$size = !empty($_GET['size']) ? (int)$_GET['size'] : NULL;

if ($size) {
	$width = $size;
	$height = $size;
}

//output_avatar($user_id, $size);
output_avatar($user_id, $width, $height);
?>