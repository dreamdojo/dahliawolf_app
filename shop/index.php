<?
    $pageTitle = "Shop";
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
</style>

<? if( !empty($user['username']) ): ?>
    <div id="shopOwnerHeader">
        <div class="shopOwnerTitle"><a href="/<?= $user['username'] ?>"><?= $user['username'] ?>'s</a> boutique </div>
        <img src="/images/emptyShopBanner.jpg">
    </div>
<? endif ?>

<div id="dahliawolfShop"></div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
$(function() {
    dahliawolfShop = new shop(<?= json_encode($user) ?>);
});
</script>