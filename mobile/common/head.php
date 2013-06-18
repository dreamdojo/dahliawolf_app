<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mobile/config/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/initial-calls.php';

$path_parts = explode('/', $_SERVER['REQUEST_URI']);
$top_dir = $path_parts[1];

if ($top_dir == 'mobile') {
	$top_dir = $path_parts[2];
}

if ($top_dir == 'shop') {
	require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/shop-initial-calls.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
<title><?= !empty($pageTitle) ? $pageTitle . ' - ' : '' ?> - Dahlia\Wolf</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Help - Dahlia Wolf - Dahlia Wolf">
<meta name="keywords" content="Help,Dahlia Wolf,Dahlia Wolf">
<link rel="icon" href="http://www.dahliawolf.com/favicon.ico" type="image/x-icon" />
<meta property="fb:app_id" content="552515884776900"/>
<meta property="og:site_name" content="Dahlia Wolf"/>
<meta property="og:image" content="http://www.dahliawolf.com/img/logo_190x190.jpg"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="apple-touch-icon" href="/icon.png"/>
<link rel="apple-touch-startup-image" href="/load_screen.jpg" />
<meta name="apple-mobile-web-app-capable" content="yes" /> 
 
<link href="/mobile/css/style.css" rel="stylesheet" type="text/css" />
<link href="/mobile/css/styles.css" rel="stylesheet" type="text/css" /> 
<link href="/css/style.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/css/pin-create-img-picker.css" media="screen" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=La+Belle+Aurore' rel='stylesheet' type='text/css'>
<!--[if IE 7]> <link href="/css/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<!--[if IE 8]> <link href="/css/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<link href="/css/jquery.fancybox-1.3.4.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/css/tipTip.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/mobile/css/main-custom.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/mobile/css/spine.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/mobile/css/shop.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/mobile/css/main_mobile.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/mobile/css/form.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script src="/mobile/js/m_functions.js"></script>
<script src="/mobile/js/functions.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/jquery.caret.1.02.min.js"></script>
<script type="text/javascript" src="/js/nav.js"></script>
<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="/js/jquery.tipTip.minified.js"></script>
<script type="text/javascript">var base_url = "http://dev.dahliawolf.com";</script>
<script type="text/javascript" src="/js/custom.js"></script>
<script src='http://connect.facebook.net/en_US/all.js'></script>
<script src="/js/jquery.form.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/mobile/js/inspire.js"></script>
<script type="text/javascript" src="/mobile/js/postDetail.js"></script>
<script type="text/javascript" src="js/jquery.event.move.js"></script>
<script type="text/javascript" src="js/jquery.event.swipe.js"></script>
<script type="text/javascript" src="/mobile/js/jquery.mobile-events.min.js"></script>
<script type="text/javascript">
        $(function() {
          $('a').click(function() {
            document.location = $(this).attr('href');
            return false;
          });
        });
    </script>
<?
if (IS_LOGGED_IN) {
	?>
<script type="text/javascript">
	var user_id = <?= $_SESSION['user']['user_id'] ?>;
	var theUser = new Object();
	theUser.id = <?= $_SESSION['user']['user_id'] ?>;
</script>
	<?
}
?>
</head>
