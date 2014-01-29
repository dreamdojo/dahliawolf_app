<?
if(isset($_COOKIE["dahliaUser"]) && !isset($_SESSION['user']) ){
    $_SESSION['user'] = unserialize($_COOKIE["dahliaUser"]);
    $_SESSION['token'] = $_COOKIE["token"];
}

require_once 'config/config.php';
require_once 'includes/php/initial-calls.php';

$path_parts = explode('/', $_SERVER['REQUEST_URI']);
$top_dir = $path_parts[1];

if ($top_dir == 'shop') {
	require 'includes/php/shop-initial-calls.php';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0031)http://www.dahliawolf.com/login -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" class="csstransforms csstransforms3d csstransitions"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?= isset($pageTitle) ? 'Dahlia\Wolf - '.$pageTitle : 'Dahlia Wolf' ?></title>

<meta name="description" content="Dahlia Wolf - Dahlia Wolf">
<meta name="keywords" content="Dahlia Wolf,Dahlia Wolf">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<meta name = "viewport" content = "width = 1100, initial-scale=.7, maximum-scale=.7">
<meta property="fb:app_id" content="552515884776900" />
<meta property="og:site_name" content="Dahlia Wolf">
<meta property="og:description" content="Post fashion images. Dahlia Wolf will turn them into clothing." />
<? if( !empty($_GET['posting_id']) ): ?>
	<meta property="og:image" content="<?= $_data['post']['image_url'] ?>" />
<? elseif( !empty($_GET['id_product']) ): ?>
	<meta property="og:image" content="<?= CDN_IMAGE_SCRIPT . $_data['product']['files'][0]['product_file_id'] ?>" />
<? else: ?>
	<meta property="og:image" content="http://www.dahliawolf.com/images/logo_190x190.jpg">
<? endif ?>
<meta property="og:image" content="http://www.dahliawolf.com/images/images/logo_190x190.jpg">
<link href="/css/style.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/pin-create-img-picker.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/main.css?<?= filemtime($_SERVER['DOCUMENT_ROOT'].'/css/main.css') ?>" media="screen" rel="stylesheet" type="text/css">
<link href="/css/main-custom.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/font-face.css" rel="stylesheet" type="text/css">
<link href="/css/jquery.countdown.css" rel="stylesheet" type="text/css">
<!--[if IE 7]> <link href="http://www.dahliawolf.com/css/face/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<!--[if IE 8]> <link href="http://www.dahliawolf.com/css/face/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<link href="/css/tipTip.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/jquery.fancybox.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/spine<?= !empty($_data['spine_version']) ? $_data['spine_version'] : '' ?>.css.php" media="screen" rel="stylesheet" type="text/css">
<link type="text/css" href="/css/shop.css" rel="stylesheet" media="screen" />
<!--<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>-->
<!--<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>-->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic' rel='stylesheet' type='text/css'>
<!--<script id="facebook-jssdk" src="/js/all.js"></script>-->
<!--<script src="/js/cb=gapi.loaded_0" async=""></script>-->
<script type="text/javascript" src="/js/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="/js/jquery.url.packed.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/nav.js"></script>
<script type="text/javascript" src="/js/pin.js"></script>
<script type="text/javascript" src="/js/pplFinder.js"></script>
<script type="text/javascript" src="/js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="/js/jquery.tipTip.minified.js"></script>
<script type="text/javascript">var base_url = "http://www.dahliawolf.com";</script>
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript" src="/js/postbar.js"></script>
<script src="/js/jquery.form.js"></script>
<link rel="stylesheet" type="text/css" href="/css/facebook-style.css">
<script src="/js/underscore-min.js" type="text/javascript"></script>
<script src="/js/functions.js?<?= filemtime($_SERVER['DOCUMENT_ROOT'].'/js/functions.js') ?>" type="text/javascript"></script>
<script src="/js/lazyload.js" type="text/javascript"></script>
<script src="/js/theLesson.js" type="text/javascript"></script>
<script src="/js/directMessager.js" type="text/javascript"></script>
<script src="/js/postDetail.js" type="text/javascript"></script>
<script src="/js/postDetailPosts.js" type="text/javascript"></script>
<script src="/js/shop.js" type="text/javascript"></script>
<script src="/js/inspire.js" type="text/javascript"></script>
<script src="/js/apiClass.js?<?= filemtime($_SERVER['DOCUMENT_ROOT'].'/js/apiClass.js') ?>" type="text/javascript"></script>
<script src="/js/userList.js?<?= filemtime($_SERVER['DOCUMENT_ROOT'].'/js/userList.js') ?>" type="text/javascript"></script>
<script src="/js/userProfile.js" type="text/javascript"></script>
<script src="/js/api.js" type="text/javascript"></script>
<script src="/js/jquery.stellar.min.js" type="text/javascript"></script>
<script src="/js/vote.js?<?= filemtime($_SERVER['DOCUMENT_ROOT'].'/js/vote.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
var theUser = new Object();
var LOVE_REQUIRED = 1000;
<? if (IS_LOGGED_IN): ?>
	userConfig = <?= json_encode($userConfig) ?>;
    userSession = <?= json_encode($_SESSION) ?>;
    userConfig.instagramToken = <?= ($_SESSION['user']['instagramToken'] ? 'true' : 'false') ?>;
    userConfig.twitterToken = <?= ($_SESSION['twitter']['access_token']['oauth_token'] ? 'true' : 'false') ?>;
    userConfig.tumblrToken = <?= ($_SESSION['tumblr']['access_token']['oauth_token'] ? 'true' : 'false') ?>;
    userConfig.facebookToken = <?= ($_SESSION['facebook']['access_token']['oauth_token'] ? 'true' : 'false') ?>;
    theUser.id = <?= $_SESSION['user']['user_id'] ?>;
	theUser.username = '<?= $_SESSION['user']['username'] ?>';
	theUser.friends = <? echo json_encode($friends) ?>;
	var user_id = <?= $_SESSION['user']['user_id'] ?>;
<? else: ?>
	var user_id = false;
	theUser.id = false;
	theUser.username = false;
	var userConfig = new Object();
<? endif ?>
    dahliawolf = new User(userConfig);
    dahliawolf.setFriends(theUser.friends);
    dahliawolf.cart.set(<?= json_encode($_data['cart']) ?>);
    $(function() {
        if(dahliawolf.isLoggedIn) {
            dahliawolf.activity.getNew(function(data) {
                var activity_count = Number(data.data.get_grouped_log_count.activity_count);
                if(activity_count) {
                    if(activity_count > sessionStorage.newActivity) {
                        $('.menuBars').addClass('menuBarsActive');
                    }

                    $('#menuActivity').append('<div class="newActivityCountMod">'+activity_count+'</div>');
                    $('#userMenu').one('mouseenter', function() {
                        $('.menuBarsActive').removeClass('menuBarsActive');
                        sessionStorage.newActivity = activity_count;
                    });
                } else {
                    sessionStorage.newActivity = 0;
                }
            });
        }
    });


</script>
</head>