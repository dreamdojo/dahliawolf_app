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
    .shopOwnerTitle{position: absolute;margin-top: 80px;left: 100px;font-size: 30px;}
</style>

<? if( !empty($user['user_id']) ): ?>
    <div id="shopOwnerHeader">
        <div class="shopOwnerTitle"><?= $user['username'] ?>'s Shop </div><img src="/images/emptyShopBanner.jpg">
    </div>
</div>
<? endif ?>

<ul id="sortBar">
    <li>sort products by: </li>
    <li data-sort="Newest">newest / </li>
    <li data-sort="Coming Soon">samples / </li>
    <li data-sort="Live">available / </li>
    <li data-sort="Pre Order" class="dahliaPink">pre-order 50% off</li>
</ul>

<div id="dahliawolfShop"></div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
$(function() {
    dahliawolfShop = new shop(<?= json_encode($user) ?>);
});
</script>