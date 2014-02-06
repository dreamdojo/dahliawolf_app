<?
$pageTitle = "Shop - Product";
if( !isset($_GET['ajax']) ) {
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
} else {
    define('CDN_IMAGE_SCRIPT', 'http://content.dahliawolf.com/shop/product/image.php?file_id=');
}

if (empty($_GET['id_product'])) {
    redirect('/shop');
}

$url = 'http://dev.commerce.offlinela.com/1-0/product.json?function=get_product_details&id_product='.$_GET['id_product'].'&use_hmac_check=0';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = json_decode(curl_exec ($ch));
curl_close ($ch);

$_data = $result->data->get_product_details->data;

if (empty($_data->product)) {
    $_SESSION['errors'] = array('Product not found');
}

if( isset($_GET['username']) && !empty($_data->product->posts[0]->username) && $_GET['username'] != $_data['product']['product']['posts'][0]['username'] ) {
    echo 'This not '.$_GET['username'].'\'s Product';
    die();
}

$status = $_data->product->status;
$total_sales = $_data->product->total_sales;
$percentage = round(($total_sales/20)*100);
$sales_needed = 20 - $total_sales;
$total_prod_imgs = 4;
?>

<style>
    .shopItemWrap{}
    .shopItemWrap section{width: 100%; padding-bottom: 70px;}
    .shopItemWrap section:nth-child(odd){background-color: #ebebeb;}
    .shopItemWrap .mainCol{width: 850px; margin: 0px auto; color: #7d7d7d;}
    .shopItemWrap .left{width: 50%; float: left; position: relative;}
    .shopItemWrap .left .productImagesFrame{width: 100%; position: relative;height: 640px; overflow: hidden;}
    .shopItemWrap .left .productImagesFrame img{width: 100%; position: absolute;}
    .shopItemWrap .left #imgMarker{position: absolute;width: 100%;top: 94%; z-index: 111;height: 30px; text-align: center;}
    .shopItemWrap .left #imgMarker ul{display: inline-block; margin: 0px auto;}
    .shopItemWrap .left #imgMarker li{height: 15px; width: 15px; background-color: #f8f7f3; float: left;margin-left: 5px; border-radius: 10px;}
    .shopItemWrap .left #imgMarker .current{background-color: #74bf00;}
    .shopItemWrap .prodDeets{width: 100%; padding-bottom: 10px;}
    .shopItemWrap .prodDeets li{display: inline-block; width: 100%;}
    .shopItemWrap p{margin: 0px;}
    .shopItemWrap .prodDeets li:first-child{font-size: 18px;}
    .shopItemWrap .prodDeets li:last-child{font-size: 11px;}
    .shopItemWrap .prodDeets li:first-child p:first-child{float: left;}
    .shopItemWrap .prodDeets li:first-child p:last-child{float: right;}
    .shopItemWrap .prodDeets li:last-child p:first-child{float: left;}
    .shopItemWrap .prodDeets li:last-child p:last-child{float: right;}
    .shopItemWrap .productImagesFrame li{position: relative;}

    .shopItemWrap .right{width: 40%; float: left; margin-left: 3%;position: relative;background-color: #fff;padding: 15px;border-top-right-radius: 8px;border-bottom-right-radius: 8px;}
    .shopItemWrap .right .shareButton{text-align: right; border: #c2c2c2 thin solid; float: right;padding: 5px 12px;border-radius: 7px;position: absolute;right: 0px;bottom: 102%;}
    .shopItemWrap .right .theDeets{border-bottom: #c2c2c2 thin solid;padding: 15px 0px;}
    .shopItemWrap .right .theDeets .prodName{font-size: 18px;}
    .shopItemWrap .right .theDeets .prodInsp{font-size: 11px;}
    .shopItemWrap .right .theDeets .prodPrice{font-size: 18px; padding-top: 20px;}
    .shopItemWrap .right #prodDeets{text-align: left;}
    .shopItemWrap .right #prodDeets .details{min-height: 280px;}
    .shopItemWrap .right #prodDeets h3{text-align: center;padding: 20px 0px;font-size: 13px;}
    .shopItemWrap .right .prodShipping{border-top: #E2E2E2 thin solid;text-align: center;font-size: 11px;}

    .shopItemWrap .right .sponsorDeets{background-color: #fff; margin-top: 16px;}
    .shopItemWrap .right .sponsorDeets .shipping{text-align: center; color: #b7b7b7;}
    .shopItemWrap .right .sponsorDeets .sponsors{text-align: center; color: #b7b7b7;}
    .shopItemWrap .right .sponsorDeets .shipping p{font-size: 12px !important;}
    .shopItemWrap .right .sponsorDeets ul{height: 50px;}
    .shopItemWrap .right .sponsorDeets .statusus ul{width: 33%;height: 46px;margin-top: 5%;float: left;border-right: #cccccc thin solid;text-align: center; font-size: 17px;}
    .shopItemWrap .right .sponsorDeets .statusus ul:last-child{border: none;}
    .shopItemWrap .right .sponsorDeets .statusus .current{color: #74bf00;}
    .shopItemWrap .right .sponsorDeets .statusus .closed{color: #b7b7b7; text-decoration: line-through;}
    .shopItemWrap .right .sponsorDeets .status li:first-child{margin-top: -6px;}
    .shopItemWrap .right .sponsorDeets .status li:last-child{font-size: 11px;}
    .shopItemWrap .right .sponsorDeets .shipping p:last-child{padding-bottom: 15px;}
    .shopItemWrap .right .size-o-matic{margin-top: 15px; height: 50px; border: #c2c2c2 thin solid;}
    .shopItemWrap .right .sizes{width: 100%;position: relative;height: 50px;}
    .shopItemWrap .right .sizes li{height: 50px;line-height: 50px;text-indent: 15px;background-color: #fff;position: relative;z-index: 1000;position: absolute;top: 0px; z-index: 0; width: 100%;transition: top .5s; -webkit-transition: top .5s; cursor: pointer;}
    .shopItemWrap .right .sizes li:hover{background-color: #cccccc;}

    .shopItemWrap .right .sizes .selected{z-index: 10;}

    .shopItemWrap .userInfo{text-align: center; color: #b7b7b7;}
    .shopItemWrap .userInfo span{font-style: italic;}
    .shopItemWrap .userInfo ul{width: 470px; margin: 0px auto; margin-top: 100px; font-size: 14px;}
    .shopItemWrap .userInfo .avatar{height: 150px; width: 150px; border: #fff 2px solid; background-size: auto 100%; background-position: 50%; border-radius: 85px; margin: 10px auto;}
    .shopItemWrap .userInfo .desc{line-height: 24px; font-size: 13px; font-style: italic;margin-top: 40px;}

    .shopItemWrap .productDetails{}
    .shopItemWrap .mainCol h1{padding-top: 35px; margin-bottom: 35px; text-align: center; font-size: 21px;}
    .shopItemWrap .productDetails .left{width: 40%; float: left;}
    .shopItemWrap .productDetails .right{width: 56%; float: left;}
    .shopItemWrap .productDetails img{width: 100%;}
    .shopItemWrap .productDetails .mainCol .right p{line-height: 35px;margin-bottom: 25px; color: #9e9e9e;}

    .greenButton{color: #fff;background-color: #74bf00;text-align: center;padding: 20px; font-size:22px; border-radius: 8px;margin-top: 15px;}
    .needed{box-shadow: inset 0 0 1em red;}
    .showing{z-index: 5;}
</style>
<div class="shopItemWrap" <?= isset($_GET['ajax']) ? 'style="padding-top: 93px;"' : '' ?>>
    <section>
        <div class="mainCol" style="padding-top: 70px;">
            <div class="left">
                <ul class="productImagesFrame" id="prodImgFrame">
                    <div id="theImages">
                        <? foreach ($_data->files as $i => $file): ?>
                            <? if($i < $total_prod_imgs): ?>
                                <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id . '&width=' . 500; ?>
                                <li <?= $i == 0 ? 'class="showing"' : '' ?> >
                                    <img class="small" id="image-<?= $i ?>" src="<?= $image_url ?>" />
                                </li>
                            <? endif ?>
                        <? endforeach ?>
                    </div>
                </ul>
                <div id="imgMarker">
                    <ul>
                        <? foreach ($_data->files as $i => $file): ?>
                            <? if($i < $total_prod_imgs): ?>
                                <li <? if($i == 0): ?>class="current"<? endif ?>></li>
                            <? endif ?>
                        <? endforeach ?>
                    </ul>
                </div>
            </div>
            <div class="right">
                <div class="shareButton">SHARE</div>
                <div style="clear: right;"></div>
                <div id="prodDeets">
                    <ul class="theDeets">
                        <li class="prodName"><?= $_data->product->product_name ?></li>
                        <li class="prodInsp">Inspiration by <a href="/<?= $_data->product->username ?>"><?= $_data->product->username ?></a></li>
                        <li class="prodPrice">$<?= number_format($_data->product->price, 2); ?></li>
                    </ul>
                    <ul class="details">
                        <li><h3>Product Details</h3></li>
                        <li style="font-size: 10pt;padding-bottom: 20px;"><?= $_data->product->design_description ?></li>
                    </ul>
                    <ul class="prodShipping">
                        <li><h3>Shipping</h3></li>
                        <li>14 Days after purchase</li>
                    </ul>
                </div>
                <form id="addItemToCartForm" action="/action/shop/add_item_to_cart.php" method="post">
                    <input type="hidden" name="ajax" value="true">
                    <input type="hidden" name="id_product" value="<?= $_data->product->id_product ?>" >
                    <input type="hidden" name="quantity" value="1" />

                    <ul class="sponsorDeets size-o-matic">
                        <ul class="sizes">
                            <li style="z-index: 10;">SIZE</li>
                            <? foreach($_data->combinations as $i => $combination): ?>
                                <li>
                                    <input style="display: none;" type="radio" name="id_product_attribute" id="id_product_attribute-<?= $i ?>" value="<?= $combination->id_product_attribute ?>"<?= ($combination->default_on == 1) ? ' checked="checked"' : '' ?>>
                                    <label for="id_product_attribute-<?= $i ?>"><?= str_replace('Size: ', '', $combination->attribute_names) ?></label>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </ul>
                    <a onclick="$(this).closest('form').submit()">
                        <div class="greenButton">ADD TO BAG</div>
                    </a>
                </form>
            </div>
            <div style="clear: left;"></div>
        </div>
    </section>

    <section class="userInfo">
        <ul>
            <li><span>Inspired by</span> <a href="/<?= $_data->product->username ?>"><?= $_data->product->username ?></a></li>
            <li><?= $_data->product->location ?></li>
            <li class="avatar avatarShadow" style="background-image: url('<?= $_data->product->posts[0]->avatar ?>');"></li>
            <li class="desc"><?= $_data->product->story_behind_design ?></li>
        </ul>
    </section>
    <section>
        <div class="mainCol" style="text-align: center;">
            <h1><?= $_data->product->product_name ?></h1>
            <? foreach ($_data->files as $i => $file): ?>
                <? if($i > 3): ?>
                    <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id . '&width=' . 500; ?>
                    <li <?= $i == 0 ? 'class="showing"' : '' ?> >
                        <img id="image-<?= $i ?>" src="<?= $image_url ?>" />
                    </li>
                <? endif ?>
            <? endforeach ?>
        </div>
    </section>
</div>

<? //include $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>

<script>
    $(function() {
        var data = <?= json_encode( $_data->product ) ?>;
        var lengtho = 200;
        holla.log(data);

        $('#daysLeft').html(getDaysLeft(data.commission_from_date));

        $('<div id="leftArrow" class="arrow spriteBG"></div>').prependTo( $('.productImagesFrame')).on('click', function() {
            var $sel = $('.showing');
            var $cur = $('.current');
            if($sel.prev().length) {
                $sel.removeClass('showing').fadeOut(lengtho).prev().addClass('showing').fadeIn(lengtho);
                $cur.removeClass('current').prev().addClass('current');
            }
        });

        $('<div id="rightArrow" class="arrow spriteBG"></div>').appendTo( $('.productImagesFrame')).on('click', function() {
            var $sel = $('.showing');
            var $cur = $('.current');
            if($sel.next().length) {
                $sel.removeClass('showing').fadeOut(lengtho).next().addClass('showing').fadeIn(lengtho);
                $cur.removeClass('current').next().addClass('current');
            } else {

            }
        });

        $('#addItemToCartForm').on('submit', dahliawolf.shop.addProductToCart);

        $('.sizes').hover(function() {
            var $sizes = $(this).find('li');
            $.each($sizes, function(x, option) {
                $(option).css('top', ((x*50)+(x*0))+'px').on('click', function() {
                    $(this).addClass('selected').find('input').attr('checked', 'checked');
                    $sizes.css('top', 0);
                });
            });
        }, function() {
            $(this).find('li').css('top', 0+'px');
        });
    });

    $(document).on('click', '.shop-wishlist-button', function() {
        var $button = $(this);
        var id = Number( $button.data('id') );

        if($button.hasClass('not-in-wishlist') ) {
            $button.removeClass('not-in-wishlist').addClass('is-in-wishlist').html('Item Is In Wishlist');
            $.ajax('/action/shop/add_item_to_wishlist.php?id_product='+id+'&ajax=true');
        } else {
            $button.addClass('not-in-wishlist').removeClass('is-in-wishlist').html('Add To Wishlist');
            $.ajax('/action/shop/remove_item_from_wishlist.php?id_favorite_product='+id+'&ajax=true');
        }
    });

    $('.optionsSection .options li').on('click', function() {
        $(this).css('background-color', '#e4e4e4').siblings().css('background-color', '#fff');
        $(this).find('input').attr('checked', 'checked');
    });
</script>