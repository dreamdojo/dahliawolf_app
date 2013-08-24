<?
    $pageTitle = "Shop";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

    $user_params = array(
        'username' => $_GET['username']
    );
    $data = api_call('user', 'get_user', $user_params, true);
    $user = $data['data'];
?>
<style>
    #emptyShop li{margin: 15px 1px; float: left;}
    #emptyShop li:hover{opacity: .7;}
    #shopOwnerHeader{width: 1000px;margin: 0px auto;position: relative;margin-top: 10px;overflow: hidden;}
    #shopOwnerHeader img{width: 100%;}
    .shopOwnerTitle{position: absolute;margin-top: 90px;left: 71px;font-size: 30px; text-transform: uppercase; font-weight: bolder !important; width: 528px;text-align: center;overflow: hidden;text-overflow: ellipsis;}
    .shopEmpty{font-size: 20px; text-align: center; margin-top: 15px;}
    body{text-align: center;}
</style>
<img style="text-align: center; margin: 0px auto;" src="/images/COMINGSOON.png">
<!--
<? if( empty($user['user_id']) ): ?>
    <ul id="sortBar">
        <li>sort products by: </li>
        <li data-sort="Newest">newest / </li>
        <li data-sort="Coming Soon">samples / </li>
        <li data-sort="Live">available / </li>
        <li data-sort="Pre Order" class="dahliaPink">pre-order 50% off</li>
    </ul>
<? endif ?>

<? if( !empty($user['user_id']) ): ?>
    <div id="shopOwnerHeader">
        <div class="shopOwnerTitle"><a href="/<?= $user['username'] ?>"><?= $user['username'] ?>'s</a> boutique </div>
        <img src="/images/emptyShopBanner.jpg">
    </div>
<? endif ?>

<div id="dahliawolfShop"></div>
-->
<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
$(function() {
    //dahliawolfShop = new shop(<?= json_encode($user) ?>);
});
</script>