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
    $counts = Array(10, 10, 10);
    $discounts = Array(50, 30, 20);


    function getMode($ts) {
        $total_sales = $ts;
        $counts = Array(10, 25, 65);

        if($total_sales < $counts[0]) {
            return 0;
        } else if($total_sales < $counts[1]) {
            return 1;
        } else if($total_sales < $counts[2]) {
            return 2;
        } else {
            return 3;
        }
    }
?>

<style>
    .sponsorItemWrap section{width: 100%; padding-bottom: 70px;}
    .sponsorItemWrap section:nth-child(odd){background-color: #ebebeb;}
    .sponsorItemWrap .mainCol{width: 850px; margin: 0px auto; color: #7d7d7d;}
    .sponsorItemWrap .left{width: 50%; float: left; position: relative;margin-right:30px;}
    .sponsorItemWrap .left .productImagesFrame{width: 100%; position: relative;height: 640px; overflow: hidden;}
    .sponsorItemWrap .left .productImagesFrame img{width: 100%; position: absolute;}
    .sponsorItemWrap .left #imgMarker{position: absolute;width: 100%;top: 94%;z-index: 111;height: 30px; text-align: center;}
    .sponsorItemWrap .left #imgMarker ul{display: inline-block; margin: 0px auto;}
    .sponsorItemWrap .left #imgMarker li{height: 15px; width: 15px; background-color: #d3d3d3; float: left;margin-left: 5px; border-radius: 10px;}
    .sponsorItemWrap .left #imgMarker .current{background-color: #74bf00;}

    .sponsorItemWrap .prodDeets{width: 100%; padding-bottom: 10px;}
    .sponsorItemWrap .prodDeets li{display: inline-block; width: 100%;}
    .sponsorItemWrap p{margin: 0px;}
    .sponsorItemWrap .prodDeets li:first-child{font-size: 18px;}
    .sponsorItemWrap .prodDeets li:last-child{font-size: 11px;}
    .sponsorItemWrap .prodDeets li:first-child p:first-child{float: left;}
    .sponsorItemWrap .prodDeets li:first-child p:last-child{float: right;}
    .sponsorItemWrap .prodDeets li:last-child p:first-child{float: left;}
    .sponsorItemWrap .prodDeets li:last-child p:last-child{float: right;}
    .sponsorItemWrap .productImagesFrame li{position: relative;}

    .sponsorItemWrap .right{width: 40%; float: left; /*margin-left: 8%;*/}
    .sponsorItemWrap .right .shareButton{text-align: right; border: #c2c2c2 thin solid; float: right;padding: 5px 12px;border-radius: 7px;}
    .sponsorItemWrap .right .sponsorDeets{background-color: #fff; margin-top: 47px;}
    .sponsorItemWrap .right .sponsorDeets .shipping{text-align: center; color: #7d7d7d;}
    .sponsorItemWrap .right .sponsorDeets .sponsors{text-align: center; color: #7d7d7d;}
    .sponsorItemWrap .right .sponsorDeets .shipping p{font-size: 11px !important;}
    .sponsorItemWrap .right .sponsorDeets h3{padding:10px 0px; text-align: center;}
    .sponsorItemWrap .right .sponsorDeets > li{min-height: 80px; width: 90%; margin-left: 5%; border-bottom: #D6D6D6 1px solid;}
    .sponsorItemWrap .right .sponsorDeets > li:last-child{border-bottom: none;}
    .sponsorItemWrap .right .sponsorDeets > li p:first-child{font-size: 28px;padding-top: 18px;}
    .sponsorItemWrap .right .sponsorDeets > li p:last-child{font-size: 14px; color: #A3A3A3;}
    .sponsorItemWrap .right .sponsorDeets .statusus ul{width: 33%;height: 46px;margin-top: 5%;float: left;border-right: #cccccc thin solid;text-align: center; font-size: 17px;}
    .sponsorItemWrap .right .sponsorDeets .statusus ul:last-child{border: none;}
    .sponsorItemWrap .right .sponsorDeets .statusus .current{color: #74bf00;}
    .sponsorItemWrap .right .sponsorDeets .statusus .closed{color: #e6e6e6; /*text-decoration: line-through;*/}
    .sponsorItemWrap .right .sponsorDeets .statusus .closed li:last-child{display: none;}
    .sponsorItemWrap .right .sponsorDeets .status li:first-child{margin-top: -6px;}
    .sponsorItemWrap .right .sponsorDeets .status li:last-child{font-size: 11px;}
    .sponsorItemWrap .right .sponsorDeets .shipping p:last-child{padding-bottom: 15px;}
    .sponsorItemWrap .right .size-o-matic{margin-top: 15px; height: 50px;}
    .sponsorItemWrap .right .sizes{width: 100%;position: relative;height: 50px;}
    .sponsorItemWrap .right .sizes li{height: 50px;line-height: 50px;text-indent: 15px;background-color: #fff; position: relative;z-index: 1000;position: absolute;top: 0px; z-index: 0; width: 100%;transition: top .5s; -webkit-transition: top .5s; cursor: pointer;}
    .sponsorItemWrap .right .sizes li:hover{background-color: #cccccc;}

    .sponsorItemWrap .right .sizes .selected{z-index: 10;}

    .sponsorItemWrap .userInfo{text-align: center; color: #b7b7b7;}
    .sponsorItemWrap .userInfo span{font-style: italic;}
    .sponsorItemWrap .userInfo ul{width: 470px; margin: 0px auto; margin-top: 100px; font-size: 14px;}
    .sponsorItemWrap .userInfo .avatar{height: 150px; width: 150px; border: #fff 2px solid; background-size: 100% auto; background-position: 50%; border-radius: 85px; margin: 10px auto; background-repeat: no-repeat;}
    .sponsorItemWrap .userInfo .desc{line-height: 24px; font-size: 13px; font-style: italic;margin-top: 40px;}

    .sponsorItemWrap .productDetails{}
    .sponsorItemWrap .mainCol h1{padding-top: 35px; margin-bottom: 35px; text-align: center; font-size: 21px;}
    .sponsorItemWrap .productDetails .left{width: 90%; float: left;}
    .sponsorItemWrap .productDetails .right{width: 100%; float: left; text-align:center;}
    .sponsorItemWrap .productDetails img{width: 100%;}
    .sponsorItemWrap .productDetails .mainCol .right p{line-height: 25px;margin-bottom: 25px; color: #9e9e9e;}

    .greenButton{color: #fff;background-color: #74bf00;text-align: center;padding: 20px; font-size:22px; border-radius: 8px;margin-top: 15px;}
    .needed{box-shadow: inset 0 0 1em red;}
    .showing{z-index: 5;}
</style>

<div class="sponsorItemWrap">
    <section>
        <div class="mainCol" style="padding-top: 40px;">
            <div class="left">
                <ul class="prodDeets">
                    <li><p><?= $_data->product->product_name ?></p><p style="text-decoration: line-through;">$<?= number_format((float)$_data->product->price, 2, '.', '') ?></p></li>
                    <li><p>Iinspiration by <a href="/<?= $_data->product->username ?>"><?= $_data->product->username ?></a></p><p ">Regular Price</p></li>
                </ul>
                <ul class="productImagesFrame" id="prodImgFrame">
                    <div id="theImages">
                        <? foreach ($_data->files as $i => $file): ?>
                            <? if($i < $total_prod_imgs): ?>
                                <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id . '&width=' . 850; ?>
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
                <!--<div class="shareButton">SHARE</div>-->
                <div style="clear: right;"></div>
                <ul class="sponsorDeets">
                    <li><p><?= round(($total_sales/30)*100) ?>%</p><p>to goal</p></li>
                    <li><p><?= getDaysLeft($_data->product->commission_from_date) ?></p><p>days left</p></li>
                    <li><p><?= $counts[getMode($total_sales)] - ($total_sales - $counts[getMode($total_sales)-1]) ?></p><p>Sponsor spots left at <?= $discounts[getMode($total_sales)] ?>% off</p></li>
                    <li class="statusus">
                        <ul class="status <?= getMode($total_sales) != 0 ? 'closed' : 'current' ?>">
                            <li>$<?= number_format((float)$_data->product->price*($discounts[0]/100), 2, '.', '') ?></li>
                            <li><?= $discounts[0] ?>% OFF</li>
                            <li><?= $total_sales < $DISCOUNTS[1] ? $DISCOUNTS[1] - $total_sales.' spots left' : 'sold out' ?></li>
                        </ul>
                        <ul class="status <?= getMode($total_sales) != 1 ? 'closed' : 'current' ?> ">
                            <li>$<?= number_format((float)$_data->product->price*(1-($discounts[1]/100)), 2, '.', '') ?></li>
                            <li><?= $discounts[1] ?>% OFF</li>
                            <li><?= $total_sales < $DISCOUNTS[2] ? $DISCOUNTS[1] - ($total_sales - $counts[1]).' spots left' : 'sold out' ?></li>
                        </ul>
                        <ul class="status <?= getMode($total_sales) != 2 ? 'closed' : 'current' ?>">
                            <li>$<?= number_format((float)$_data->product->price*(1-($discounts[2]/100)), 2, '.', '') ?></li>
                            <li><?= $discounts[2] ?>% OFF</li>
                            <li><?= $total_sales < $DISCOUNTS[3] ? $DISCOUNTS[2] - ($total_sales - $counts[2]).' spots left' : 'sold out' ?></li>
                        </ul>
                    </li>
                    <!--<li class="sponsors">
                        <h3>Sponsors</h3>
                    </li>-->
                    <li class="shipping">
                        <h3>Payments</h3>
                        <p>Help fund the development of this design by becoming a sponsor. <br><br>All sponsors are sent the <?= $_data->product->product_name ?> plus a discount for early support. <br><br>You will be charged at the time of purchase. If the design doesn't reach its funding goal you will be issued a full refund.</p>
                    </li>
                    <li class="shipping">
                        <h3>Shipping</h3>
                        <p>This item will ship 2 weeks after it has been fully sponsored.</br>Free domestic shipping (USA & Canada)</p>
                    </li>
                </ul>
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
                        <div class="greenButton">SPONSOR NOW</div>
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

    <section class="productDetails">
        <div class="mainCol">
            <h1>Product Details</h1>
            <!--<div class="left">
                <img src="<?= $_data->product->inspiration_image_url ?>">
            </div>-->
            <div class="right">
                <p><?= $_data->product->design_description ?></p>
                <img style="width:550px;" src="/images/teal_chart.png">
            </div>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section>
        <div class="mainCol" style="text-align: center;">
            <h1><?= $_data->product->product_name ?></h1>
            <? foreach ($_data->files as $i => $file): ?>
                <? if($i > 3): ?>
                    <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id  .'&width=' . 850; ?>
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
        console.log(data);
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
                $(option).css('top', (x*50)+'px').on('click', function() {
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