<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Valid login
if (!empty($_GET['authen'])) {
	// Save user info to session
	$_SESSION['user'] = $_GET['user'];
	$_SESSION['token'] = $_GET['token'];
	$_SESSION['logout_url'] = $_GET['logout_url'];
	setcookie("dahliaUser", serialize($_SESSION['user']), time()+36000000, "/");
	setcookie('token', $_SESSION['token'], time()+36000000, "/");

	// Send to account page
	if (isset($_SESSION['redirect'])) {
		$redirect = $_SESSION['redirect'];
		unset($_SESSION['redirect']);
		
		header('location: ' . $redirect);
		die();
	}
	// If register
	if (!empty($_GET['register'])) {
		if(IS_MOBILE){
			$_SESSION['guide_post'] = true;
			$_SESSION['guide_shop'] = true;
			$_SESSION['guide_vote'] = true;
            header('location: ' . CR . '/mobile/dahliawolf');
		}
		header('location: ' . CR . '/?facebookregistration=true');
	}
	// Else regular login
	else {
		header('location: ' . CR . '/');
	}
	die();
}

if (empty($_GET['social_network'])) {
	header('Location: ' . CR . '/vote?modal=signup');
	die();
}

// Redirect url
$redirect_url = 'http://' . $_SERVER['SERVER_NAME'] . CR . $_SERVER['PHP_SELF'];
$logout_redirect_url = 'http://' . $_SERVER['SERVER_NAME'] . CR;

$api_domain = strpos($_SERVER['SERVER_NAME'], 'dev')>-1? "dev.api.dahliawolf.com" : "api.dahliawolf.com";

header("Location: http://{$api_domain}/social-login.php?redirect_url=" . $redirect_url . '&logout_redirect_url=' . $logout_redirect_url . '&api_website_id=' . API_WEBSITE_ID . '&social_network=' . $_GET['social_network']);
die();
?>