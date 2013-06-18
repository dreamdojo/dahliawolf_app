<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/php/Mobile_Detect.php';
$detect = new Mobile_Detect();
$layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');

if ($layout == 'mobile') {
	header('Location: /mobile' . $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') === false ? '?' : '&') . 'session_type=web');
}
?>