<?
if(isset($_COOKIE["dahliaUser"]) && !isset($_SESSION['user']) ){
    $_SESSION['user'] = unserialize($_COOKIE["dahliaUser"]);
    $_SESSION['token'] = $_COOKIE["token"];
}

require 'config/config.php';
require 'config/mobile-detect.php';
require 'includes/php/initial-calls.php';

$path_parts = explode('/', $_SERVER['REQUEST_URI']);
$top_dir = $path_parts[1];

if ($top_dir == 'mobile') {
	$top_dir = $path_parts[2];
}

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
<meta property="og:description" content="You post fashion images we turn them into clothing." />
<? if( !empty($_GET['posting_id']) ): ?>
	<meta property="og:image" content="<?= $_data['post']['image_url'] ?>" />
<? elseif( !empty($_GET['id_product']) ): ?>
	<meta property="og:image" content="<?= CDN_IMAGE_SCRIPT . $_data['product']['product']['id_product'] ?>" />
<? else: ?>
	<meta property="og:image" content="/images/logo_190x190.jpg">
<? endif ?>
<link href="/css/style.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/pin-create-img-picker.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/main.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/main-custom.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/font-face.css" rel="stylesheet" type="text/css">
<link href="/css/jquery.countdown.css" rel="stylesheet" type="text/css">
<!--[if IE 7]> <link href="http://www.dahliawolf.com/css/face/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<!--[if IE 8]> <link href="http://www.dahliawolf.com/css/face/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<link href="/css/jquery.fancybox-1.3.4.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/tipTip.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/spine<?= !empty($_data['spine_version']) ? $_data['spine_version'] : '' ?>.css.php" media="screen" rel="stylesheet" type="text/css">
<link type="text/css" href="/css/shop.css" rel="stylesheet" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
<!--<script id="facebook-jssdk" src="/js/all.js"></script>-->
<!--<script src="/js/cb=gapi.loaded_0" async=""></script>-->
<script type="text/javascript" src="/js/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="/js/jquery.url.packed.js"></script>
<script type="text/javascript" src="/js/jquery.color-2.1.1.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/jquery.caret.1.02.min.js"></script>
<script type="text/javascript" src="/js/nav.js"></script>
<script type="text/javascript" src="/js/pin.js"></script>
<script type="text/javascript" src="/js/pplFinder.js"></script>
<script type="text/javascript" src="/js/jquery.masonry.min.js"></script>
<!--<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>-->
<script type="text/javascript" src="/js/jquery.tipTip.minified.js"></script>
<script type="text/javascript">var base_url = "http://www.dahliawolf.com";</script>
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript" src="/js/postbar.js"></script>
<script src="/js/jquery.form.js"></script>
<!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>-->
<link rel="stylesheet" type="text/css" href="/css/facebook-style.css">
<script src="/js/underscore-min.js" type="text/javascript"></script>
<script src="/js/functions.js" type="text/javascript"></script>
<script src="/js/lazyload.js" type="text/javascript"></script>
<script src="/js/theLesson.js" type="text/javascript"></script>
<script src="/js/theGrid.js" type="text/javascript"></script>
<script src="/js/directMessager.js" type="text/javascript"></script>
<script src="/js/postDetail.js" type="text/javascript"></script>
<script src="/js/postDetailPosts.js" type="text/javascript"></script>
<script src="/js/shop.js" type="text/javascript"></script>
<script src="/js/userList.js" type="text/javascript"></script>
<script src="/js/userProfile.js" type="text/javascript"></script>
<script src="/js/api.js" type="text/javascript"></script>
<script src="/js/jquery.countdown.js" type="text/javascript"></script>
<script type="text/javascript">

var theUser = new Object();
<? if (IS_LOGGED_IN): ?>
	var userConfig = <?= json_encode($userConfig) ?>;
	//console.log(userConfig);
	<? if(INSTAGRAM_IS_LOGGED_IN): ?>
		userConfig.instagramToken = '<?= $_SESSION['user']['instagramToken'] ?>';
	<? endif ?>
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

<!-- Start of Woopra Code -->
    (function(){
        var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)
    })("woopra");

    woopra.config({
        domain: 'dahliawolf.com',
        idle_timeout: 1800000
    });
    woopra.track('pv', {
        url: window.location.pathname+window.location.search,
        title: document.title
    });

    function woopraReady(tracker){
        tracker.setDomain('dahliawolf.com');
        tracker.setIdleTimeout(300000);

        tracker.addVisitorProperty('email', userConfig.email_address);
        tracker.addVisitorProperty('name', userConfig.username);

        return false;
    }

    (function(){
        var wsc=document.createElement('script');
        wsc.type='text/javascript';
        wsc.src=document.location.protocol+'//static.woopra.com/js/woopra.js';
        wsc.async=true;
        var ssc = document.getElementsByTagName('script')[0];
        ssc.parentNode.insertBefore(wsc, ssc);
    })();
<!-- End of Woopra Code -->
</script>
</head>
