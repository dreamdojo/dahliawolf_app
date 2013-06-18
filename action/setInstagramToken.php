<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if( isset($_POST['token']) ){
	$_SESSION['user']['instagramToken'] = $_POST['token'];
}
?>