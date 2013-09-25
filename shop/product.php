<?
    $pageTitle = "Shop - Product";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

    if (empty($_GET['id_product'])) {
        redirect('/shop');
    }

    if(!empty($_SESSION['user'])) {
        $wl_calls = array(
            'does_product_exist_in_wishlist' => array(
                'id_customer' => $_SESSION['user']['user_id']
            , 'id_product' => $_GET['id_product']
            , 'id_shop' => SHOP_ID
            , 'id_lang' => LANG_ID
            )
        );
        $wl_data = commerce_api_request('wishlist', $wl_calls, true);
        $_data['show_add_to_wishlist'] = empty($wl_data['data']['does_product_exist_in_wishlist']['data']) ? true : false;
    } else $_data['show_add_to_wishlist'] =  false;

    $calls = array(
        'get_product_details' => array(
            'id_product' => $_GET['id_product']
        , 'id_shop' => SHOP_ID
        , 'id_lang' => LANG_ID
        , 'user_id' => !empty($_GET['user_id']) ? $_GET['user_id'] : NULL
        )
    );

    $data = commerce_api_request('product', $calls, true);

    // Failed
    if (!empty($data['errors']) || !empty($data['data']['get_product_details']['errors'])) {
        $_SESSION['errors'] = api_errors_to_array($data, 'get_product_details');
    }
    else {
        $_data['product'] = $data['data']['get_product_details']['data'];

        if (empty($_data['product']) || empty($_data['product']['product'])) {
            $_SESSION['errors'] = array('Product not found');
        }
    }

    if( isset($_GET['username']) && !empty($_data['product']['product']['posts'][0]['username']) && $_GET['username'] != $_data['product']['product']['posts'][0]['username'] ) {
        echo 'This not '.$_GET['username'].'\'s Product';
        die();
    }

    $status = $_data['product']['product']['status'];
?>

<style>
    .shop-wishlist-button{padding: 12px 1px;font-size: 18px;text-align: center; color: #fff; cursor: pointer;}
    .not-in-wishlist{background-color: #363636;}
    .is-in-wishlist{background-color: #f4a5b4;}
    .shop-section{width: 1000px; margin: 0px auto; position: relative;}
    #shopHeader{height: 130px;padding-top: 15px;}
    #shopHeader #shopUserData{float: left; margin-top: 35px; margin-left: 10px;}
    #shopHeader #shopUserData li{float: left; width: 100px; width: 200px; width: 100%;}
    #shopHeader .avatarFrame{float: left; overflow: hidden; border-radius: 50px; height: 100px; width: 100px;}
    #shopHeader .avatarFrame img{width: 100%;}

    #shopContent{border-top: #d5d5d5 2px solid;clear: left;}
    #shopContent .leftCol{float: left; width: 300px;}
    #shopContent .leftCol .follow{height: 30px;line-height: 30px;font-size: 15px;cursor: pointer;width: 90px;text-align: left;}
    #shopContent .leftCol .isfollowing{color: #c2c2c2;}
    #shopContent .leftCol .isnotfollowing{color: #fc2c71;}
    #shopContent .leftCol .story{font-size: 27px;border-top: #dcdcdc thin solid;padding-top: 10px;margin-bottom: 10px;}
    #shopContent .leftCol .content{font-size: 12px;line-height: 17px;}
    #shopContent .leftCol h2{font-size: 18px;margin-top: 10px;}
    #shopContent .centerCol{float: left;width: 400px;margin-left: 20px;margin-top: 30px; position: relative;}
    #shopContent .rightCol{float: left; width: 260px; margin-left: 20px;}
    #shopContent .rightCol h3{height: 30px;color: #8d8d8d;font-size: 13px;line-height: 30px;}
    #shopContent .rightCol .regularPrice{background-color: #e4e4e4;height: 50px;color: #fff;line-height: 50px;font-size: 25px;text-indent: 10px;}
    #shopContent .rightCol .presalePrice{background-color: #e4e4e4;height: 50px;color: #000;line-height: 50px;font-size: 25px;text-indent: 10px;}
    #shopContent .productImagesFrame{width: 100%; height: 600px; position: relative;border: #dcdcdc thin solid;}
    #shopContent .productImagesFrame li{width: 100%;overflow: hidden;position: absolute; display: none;}
    #shopContent .productImagesFrame li:first-child{display: block;}
    #shopContent .productImagesFrame li img{width: 100%;}
    #shopContent .rightCol .preOrderPrice{color: #fc0964;margin-left: 10px;}
    #shopContent .rightCol .strike{text-decoration:line-through;color: #fc0964; }
    #theCountdown li{float: left;width: 25%;text-align: center;font-size: 14px;color: #c7c7c7;background-color: #f4f4f4;}
    #theCountdown li p{height: 50px;line-height: 50px;font-size: 30px;}
    #theCountdown li p:first-child{height: 58px; border-bottom: #fff thin solid; line-height: 50px;font-size: 15px;}
    #theCountdown li p:last-child{color: #000;}
    #theCountdown{width: 100%;height: 65px; padding-top: 12px; color: #888888;}
    #shopOptions li{width: 100%; height: 30px; font-size: 13px; line-height: 30px;}
    .options li{float: left;width: 65px !important;text-align: center;}
    .scribble{font-family: 'Shadows Into Light', cursive;}
    #addToCart{background-color: #fc0964;text-align: center;padding: 10px 10px;font-size: 20px;width: 100%;float: left;color: #fff;margin-top: 10px;}
    #nextImage{position: absolute;right: 0px;height: 100px;width: 50px;top: 50%;z-index: 1;margin-top: -50px;font-size: 60px;text-align: center;font-weight: 100;}
    .product{ color: #c5bfbf;}

    #postShareSection{margin-right: 0px;}
</style>

<div id="shopHeader" class="shop-section">
    <div class="avatarFrame avatarShadow"><img src="<?= $_data['product']['product']['posts'][0]['avatar'] ?>&width=100" /></div>
    <ul id="shopUserData">
        <li style="font-size: 13px;">Inspiration by</li>
        <li style="font-size: 25px;" class="scribble"><a href="/<?= $_data['product']['product']['posts'][0]['username']?>"><?= $_data['product']['product']['posts'][0]['username']?></a></li>
    </ul>
    <div id="postShareSection">
        <div class="postShareTitle">SHARE THIS PRODUCT</div>
        <ul class="shareButts">
            <? $image_url = CDN_IMAGE_SCRIPT . $_data['product']['files'][0]['product_file_id'] . '&width=' . $width . '&height=' . $height; ?>

            <li class="cursor" id="shareFacebook"></li>
            <a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com;media=<?= $image_url ?>" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                <li id="sharePinterest"></li>
            </a>
            <a href="http://www.tumblr.com/share/photo?source=<?= rawurlencode( $image_url ) ?>&caption=<?= rawurlencode( "OMG Super Amazeballs" )?>&click_thru=<?= rawurlencode( "http://www.dahliawolf.com/shop/".$_data['product']['product']['id_product']) ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <li id="shareTumbler"></li>
            </a>
            <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&amp;url=http://www.dahliawolf.com/shop/<?= $_data['product']['product']['id_product'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                <li id="shareTwitter"></li>
            </a>
            <a href="https://plus.google.com/share?url=http://www.dahliawolf.com/shop/<?= $_data['product']['product']['id_product'] ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                <li id="shareGplus"></li>
            </a>
            <a href='mailto:?subject=Frickin Awesome&body=Yo check out this bangin outfit I found at http://www.dahliawolf.com/shop/<?= $_data['product']['product']['id_product'] ?>.'>
                <li id="shareEmail"></li>
            </a>
        </ul>
    </div>
</div>

<div id="shopContent" class="shop-section">
    <div class="leftCol">
        <ul>
            <li class="follow isnotfollowing">FOLLOW+</li>
            <li>
                <p class="scribble story">Story behind <?= $_data['product']['product']['product_name'] ?></p>
                <p class="content"><?= $_data['product']['product']['story_behind_design'] ?></p>
            </li>
            <li style="border-top: #dcdcdc thin solid;">
                <h2>Product Description</h2>
                <p class="content"><?= $_data['product']['product']['design_description'] ?></p>
            </li>
            <li class="product">
                <dl class="additional-info accordion">
                    <dt>Size & Fit</dt>
                    <dd><img class="sizeAndFit"src=/images/dahliawolf_sizechart.jpg></dd>
                    <dt>Shipping &amp; Returns</dt>
                    <dd></dd>
                    <dt>Fabric</dt>
                    <dd></dd>
                </dl>
            </li>
        </ul>

    </div>
    <div class="centerCol">
        <? if (!empty($_data['product']) && !empty($_data['product']['files'])): ?>
            <!--<div id="nextImage">></div>-->
            <ul class="productImagesFrame">
                <? foreach ($_data['product']['files'] as $i => $file): ?>
                    <? $image_url = CDN_IMAGE_SCRIPT . $file['product_file_id'] . '&width=' . $width . '&height=' . $height; ?>
                    <li>
                        <img src="<?= $image_url ?>" width="<?= $width ?>" />
                    </li>
                <? endforeach ?>
            </ul>
        <? endif ?>
    </div>
    <div class="rightCol">
        <h3><?= $_data['product']['product']['product_name'] ?></h3>
        <div class="regularPrice">
            <span <?= $status ? 'style="text-decoration:line-through"' : '' ?>>$<?= number_format( ($_data['product']['product']['price']), 2, '.', ',') ?></span>
            <span class="preOrderPrice"><?= $status == 'Pre Order' ? '30% Off' : ''?></span>
        </div>
        <? if( $_data['product']['product']['status'] == 'Pre Order'): ?>
            <div class="presalePrice">$<?= number_format( ($_data['product']['product']['price']*.7), 2, '.', ',') ?></div>
        <? endif ?>
        <? if( $status == 'Pre Order'): ?>
            <div id="theCountdown">
            </div>
        <? endif ?>
        <div>
            <form action="/action/shop/add_item_to_cart.php" method="post">
                <input type="hidden" name="id_product" value="<?= $_data['product']['product']['id_product'] ?>" >
                <ul id="shopOptions">
                    <li>
                        <label>Quantity</label>
                        <select name="quantity" value="1" />
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </li>
                    <li>
                        <label style="float: left;">Sizes</label>
                        <? if (!empty($_data['product']['combinations'])): ?>
                            <ul class="options">
                                <? foreach($_data['product']['combinations'] as $i => $combination): ?>
                                    <li>
                                        <input type="radio" name="id_product_attribute" id="id_product_attribute-<?= $i ?>" value="<?= $combination['id_product_attribute'] ?>"<?= ($combination['default_on'] == 1) ? ' checked="checked"' : '' ?>>
                                        <label for="id_product_attribute-<?= $i ?>"><?= str_replace('Size: ', '', $combination['attribute_names']) ?></label>
                                    </li>
                                <? endforeach ?>
                            </ul>
                        <? endif ?>
                    </li>
                </ul>
                <a onclick="$(this).closest('form').submit()">
                    <p id="addToCart" class="button">Add to Cart</p>
                </a>
            </form>
        </div>
    </div>
</div>
<script>
    console.log(<?= json_encode( $_data['product'] ) ?>);

    $(function() {
       if( $('#theCountdown').length ) {
           var productData = <?= json_encode( $_data['product'] ) ?>;
           var newYear = new Date(productData.product.commission_from_date);
           $('#theCountdown').countdown({until: newYear});
       }
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
</script>

<? include $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>