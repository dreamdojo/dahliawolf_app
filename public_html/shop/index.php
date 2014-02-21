<?
    $pageTitle = "Shop Dahlia Wolf";
    $pageDesc = 'Browse the newest member inspired clothes available for purchase at Dahlia Wolf';
    $pageKey = 'Dahlia Wolf Shop';

    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

    if(!empty($_GET['username'])) {
        $user_params = array(
            'username' => $_GET['username']
        );
        $data = api_call('user', 'get_user', $user_params, true);
        $user = $data['data'];
    }
    include $_SERVER['DOCUMENT_ROOT'] . "/blocks/shopFilter.php";
?>

<style>
    #emptyShop li{margin: 15px 1px; float: left;}
    #emptyShop li:hover{opacity: .7;}
    #shopOwnerHeader{width: 1000px;margin: 0px auto;position: relative;margin-top: 10px;overflow: hidden;}
    #shopOwnerHeader img{width: 100%;}
    .shopOwnerTitle{position: absolute;margin-top: 90px;left: 71px;font-size: 30px; text-transform: uppercase; font-weight: bolder !important; width: 528px;text-align: center;overflow: hidden;text-overflow: ellipsis;}
    .shopEmpty{font-size: 20px; text-align: center; margin-top: 15px;}
    body{text-align: center;}
    .takeTwo{position: absolute;top: 0px;left: -100%; z-index: 11111;width: 100%;transition: left .25s;-webkit-transition: left .25s; background-color: #fff;height: 100%;}
    .takeTwo img{width: 70%; margin-left: 15%;}
    .product-details:hover .takeTwo{left: 0%;}

    #productPage{position: fixed; width: 100%; height: 100%; left: 0px; top: 0px; background-color: #fff; z-index: 1000; overflow: scroll;}
</style>

<? if( !empty($user['username']) ): ?>
    <div id="shopOwnerHeader">
        <div class="shopOwnerTitle"><a href="/<?= $user['username'] ?>"><?= $user['username'] ?>'s</a> designs </div>
        <img src="/images/emptyShopBanner.jpg">

    </div>
<? endif ?>
<!-- This version of the embed code is no longer supported. Learn more: https://vimeo.com/s/tnm --> <object width="990" height="478" style="margin-top: 25px;margin-bottom:-15px;"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=80430372&amp;force_embed=1&amp;server=vimeo.com&amp;color=ffffff&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=80430372&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="990" height="556"></embed></object>
<div id="dahliawolfShop" style="max-width: 990px;"></div>

<?
    //include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
$(function() {
    dahliawolfShop = new shop(<?= json_encode($user) ?>);
});
</script>