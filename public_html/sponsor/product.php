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
?>

<style>
    .sponsorItemWrap section{width: 100%; padding-bottom: 70px;}
    .sponsorItemWrap section:nth-child(odd){background-color: #ebebeb;}
    .sponsorItemWrap .mainCol{width: 900px; margin: 0px auto; color: #7d7d7d;}
    .sponsorItemWrap .left{width: 58%; float: left;}
    .sponsorItemWrap .left .productImagesFrame{width: 100%; position: relative;height: 640px; overflow: hidden;}
    .sponsorItemWrap .left .productImagesFrame img{width: 85%; position: absolute; left: 7.5%;}
    .sponsorItemWrap .prodDeets{width: 100%; padding-bottom: 10px;}
    .sponsorItemWrap .prodDeets li{display: inline-block; width: 100%;}
    .sponsorItemWrap p{margin: 0px;}
    .sponsorItemWrap .prodDeets li:first-child{font-size: 18px;}
    .sponsorItemWrap .prodDeets li:last-child{font-size: 11px;}
    .sponsorItemWrap .prodDeets li:first-child p:first-child{float: left;}
    .sponsorItemWrap .prodDeets li:first-child p:last-child{float: right;}
    .sponsorItemWrap .prodDeets li:last-child p:first-child{float: left;}
    .sponsorItemWrap .prodDeets li:last-child p:last-child{float: right;}

    .sponsorItemWrap .right{width: 38%; float: left; margin-left: 4%;}
    .sponsorItemWrap .right .shareButton{text-align: right; border: #c2c2c2 thin solid; float: right;padding: 5px 12px;border-radius: 7px;}
    .sponsorItemWrap .right .sponsorDeets{background-color: #fff; border-radius: 9px; margin-top: 16px;}
    .sponsorItemWrap .right .sponsorDeets .shipping{text-align: center; color: #b7b7b7;}
    .sponsorItemWrap .right .sponsorDeets .sponsors{text-align: center; color: #b7b7b7;}
    .sponsorItemWrap .right .sponsorDeets .shipping p{font-size: 12px !important;}
    .sponsorItemWrap .right .sponsorDeets h3{padding:10px 0px; text-align: center;}
    .sponsorItemWrap .right .sponsorDeets > li{min-height: 80px; width: 90%; margin-left: 5%; border-bottom: #ebebeb 1px solid;}
    .sponsorItemWrap .right .sponsorDeets > li:last-child{border-bottom: none;}
    .sponsorItemWrap .right .sponsorDeets > li p:first-child{font-size: 28px;padding-top: 18px;}
    .sponsorItemWrap .right .sponsorDeets > li p:last-child{font-size: 14px; color: #b7b7b7;}
    .sponsorItemWrap .right .sponsorDeets .statusus ul{width: 33%;height: 46px;margin-top: 5%;float: left;border-right: #cccccc thin solid;text-align: center; font-size: 17px;}
    .sponsorItemWrap .right .sponsorDeets .statusus .current{color: #74bf00;}
    .sponsorItemWrap .right .sponsorDeets .statusus .closed{color: #b7b7b7; text-decoration: line-through;}
    .sponsorItemWrap .right .sponsorDeets .status li:first-child{margin-top: -6px;}
    .sponsorItemWrap .right .sponsorDeets .status li:last-child{font-size: 11px;}
    .sponsorItemWrap .right .sponsorDeets .shipping p:last-child{padding-bottom: 15px;}
    .sponsorItemWrap .right .size-o-matic{margin-top: 15px; height: 50px;}
    .sponsorItemWrap .right .sizes{width: 100%;position: relative;height: 50px;}
    .sponsorItemWrap .right .sizes li{height: 50px;line-height: 50px;text-indent: 15px;background-color: #fff;border-radius: 10px;position: relative;z-index: 1000;position: absolute;top: 0px; z-index: 0; width: 100%;transition: top .5s; -webkit-transition: top .5s; cursor: pointer;}
    .sponsorItemWrap .right .sizes li:hover{background-color: #cccccc;}

    .sponsorItemWrap .right .sizes .selected{z-index: 10;}

    .sponsorItemWrap .userInfo{text-align: center; color: #b7b7b7;}
    .sponsorItemWrap .userInfo span{font-style: italic;}
    .sponsorItemWrap .userInfo ul{width: 470px; margin: 0px auto; margin-top: 100px; font-size: 14px;}
    .sponsorItemWrap .userInfo .avatar{height: 150px; width: 150px; border: #fff 2px solid; background-size: 100% auto; background-position: 50%; border-radius: 85px; margin: 10px auto;}
    .sponsorItemWrap .userInfo .desc{line-height: 24px; font-size: 13px; font-style: italic;margin-top: 40px;}

    .sponsorItemWrap .productDetails{}
    .sponsorItemWrap .productDetails h1{padding-top: 35px; margin-bottom: 35px; text-align: center; font-size: 21px;}
    .sponsorItemWrap .productDetails .left{width: 40%; float: left;}
    .sponsorItemWrap .productDetails .right{width: 56%; float: left;}
    .sponsorItemWrap .productDetails img{width: 100%;}

    .greenButton{color: #fff;background-color: #74bf00;text-align: center;padding: 20px; font-size:22px; border-radius: 8px;margin-top: 15px;}
</style>
<div class="sponsorItemWrap">
    <section>
        <div class="mainCol" style="padding-top: 70px;">
            <div class="left">
                <ul class="prodDeets">
                    <li><p><?= $_data->product->product_name ?></p><p>$<?= number_format((float)$_data->product->price, 2, '.', '') ?></p></li>
                    <li><p>Iinspiration by <?= $_data->product->username ?></p><p>Regular Price</p></li>
                </ul>
                <ul class="productImagesFrame" id="prodImgFrame">
                    <? foreach ($_data->files as $i => $file): ?>
                        <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id . '&width=' . 500; ?>
                        <li <?= $i == 0 ? 'class="showing"' : '' ?> >
                            <img class="small" id="image-<?= $i ?>" src="<?= $image_url ?>" />
                        </li>
                        <? if($i >= 5) {
                            break;
                        } ?>
                    <? endforeach ?>
                </ul>
            </div>
            <div class="right">
                <div class="shareButton">SHARE</div>
                <div style="clear: right;"></div>
                <ul class="sponsorDeets">
                    <li><p>13%</p><p>to goal</p></li>
                    <li><p>17</p><p>days left</p></li>
                    <li><p>22</p><p>sponsors spots left</p></li>
                    <li class="statusus">
                        <ul class="status closed">
                            <li>$50.00</li>
                            <li>50% OFF</li>
                            <li>sold out</li>
                        </ul>
                        <ul class="status current">
                            <li>$70.00</li>
                            <li>30% OFF</li>
                            <li>22 spots left</li>
                        </ul>
                        <ul class="status pending">
                            <li>$80.00</li>
                            <li>20% OFF</li>
                            <li>22 spots left</li>
                        </ul>
                    </li>
                    <li class="sponsors">
                        <h3>Sponsors</h3>
                    </li>
                    <li class="shipping">
                        <h3>Shipping</h3>
                        <p>If this product gets fully funded, it'll ship in mid May.</br>We also off FREE UPS domestic shipping.</p>
                    </li>
                </ul>
                <ul class="sponsorDeets size-o-matic">
                    <ul class="sizes">
                        <li>SIZE</li>
                        <? foreach($_data->combinations as $i => $combination): ?>
                            <li>
                                <input style="display: none;" type="radio" name="id_product_attribute" id="id_product_attribute-<?= $i ?>" value="<?= $combination->id_product_attribute ?>"<?= ($combination->default_on == 1) ? ' checked="checked"' : '' ?>>
                                <label for="id_product_attribute-<?= $i ?>"><?= str_replace('Size: ', '', $combination->attribute_names) ?></label>
                            </li>
                        <? endforeach ?>
                    </ul>
                </ul>
                <div class="greenButton">SPONSOR NOW</div>
            </div>
            <div style="clear: left;"></div>
        </div>
    </section>

    <section class="userInfo">
        <ul>
            <li><span>Inspired by</span> <?= $_data->product->username ?></li>
            <li><?= $_data->product->location ?></li>
            <li class="avatar avatarShadow" style="background-image: url('<?= $_data->product->posts[0]->avatar ?>');"></li>
            <li class="desc"><?= $_data->product->story_behind_design ?></li>
        </ul>
    </section>

    <section class="productDetails">
        <div class="mainCol">
            <h1>Product Details</h1>
            <div class="left">
                <img src="<?= $_data->product->inspiration_image_url ?>">
            </div>
            <div class="right">
                <p><?= $_data->product->design_description ?></p>
                <img src="/images/dahliawolf_sizechart.jpg">
            </div>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section>
        <div class="mainCol">
            <h1><?= $_data->product->product_name ?></h1>
            <? foreach ($_data->files as $i => $file): ?>
                <? if($i > 5): ?>
                    <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id . '&width=' . 500; ?>
                    <li <?= $i == 0 ? 'class="showing"' : '' ?> >
                        <img class="small" id="image-<?= $i ?>" src="<?= $image_url ?>" />
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
        holla.log(data);
        $('#daysLeft').html(getDaysLeft(data.commission_from_date));

        var thumbs = $('#thumbs li');
        var lengtho = 200;
        if(thumbs.length) {
            //$(thumbs[0]).addClass('showing');
            $.each(thumbs, function(x, thumb) {
                $(thumb).hover(function() {
                    if(!$($('.productImagesFrame li')[x]).hasClass('showing')) {
                        $('.showing').fadeOut(lengtho).removeClass('showing');
                        $( $('.productImagesFrame li')[x] ).addClass('showing').fadeIn(lengtho);
                    }
                }, function() {
                    //console.log('df');
                });
            });
            $('<div id="leftArrow" class="arrow"></div>').prependTo( $('.productDetails')).on('click', function() {
                var $sel = $('.showing');
                if($sel.prev().length) {
                    $sel.removeClass('showing').fadeOut(lengtho).prev().addClass('showing').fadeIn(lengtho);
                }
            });
            $('<div id="rightArrow" class="arrow"></div>').appendTo( $('.productDetails')).on('click', function() {
                var $sel = $('.showing');
                if($sel.next().length) {
                    $sel.removeClass('showing').fadeOut(lengtho).next().addClass('showing').fadeIn(lengtho);
                } else {

                }
            });
        }

        $('#addItemToCartForm').on('submit', dahliawolf.shop.addProductToCart);

        $('.sizes').hover(function() {
            $.each( $(this).find('li'), function(x, option) {
                 $(option).css('top', ((x*50)+(x*10))+'px').on('click', function() {
                     $(this).addClass('selected');
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