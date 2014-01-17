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
    .shopCol{width: 900px; margin: 0px auto; margin-top: 90px; padding-bottom: 200px;}
    .shopCol a{color: #666;}
    .productDetails{width: 60%; float: left; position: relative;}
    .productCTA{width: 40%; float: left;}
    .productDeets{margin-top: 7px;}
    .productDeets .prodName{font-size: 18px;}
    .productDeets .inspBy{font-size: 12px;}
    .productImagesFrame{width: 100%; position: relative;height: 600px;}
    .productImagesFrame li{position: absolute; width: 100%;text-align: center; display: none;}
    .productImagesFrame li img{width: 70%;margin: 0px auto;}
    #thumbs{position: relative; width: 86%; margin-left: 14%; display: inline-block;}
    #thumbs li{float: left;width: 75px;}
    #thumbs li img{width: 100%;}
    #nextImage{position: absolute;right: 0px;top: 50%;z-index: 2;}
    .needSection li{padding: 6px 0px;}

    .productCTA{text-align: center;}
    .needSection .nMo{font-size: 25px;padding-bottom: 0px;}
    .needSection .nMoDesc{font-style: italic;color: #c2c2c2;font-size: 13px;}

    #needsBar{position: relative;height: 40px;background-color: #c2c2c2;border-radius: 12px;line-height: 40px;box-shadow: inset 0 0 8px #858585;}
    #needsBar li{padding: 0px;}
    #needsBar .pComp{position: absolute;text-align: right;width: 80%;background: #f03e63; /* Old browsers */
        background: -moz-linear-gradient(left,  #f03e63 0%, #f9b3b3 0%, #f03e63 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right top, color-stop(0%,#f03e63), color-stop(0%,#f9b3b3), color-stop(100%,#f03e63)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(left,  #f03e63 0%,#f9b3b3 0%,#f03e63 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(left,  #f03e63 0%,#f9b3b3 0%,#f03e63 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(left,  #f03e63 0%,#f9b3b3 0%,#f03e63 100%); /* IE10+ */
        background: linear-gradient(to right,  #f03e63 0%,#f9b3b3 0%,#f03e63 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f03e63', endColorstr='#f03e63',GradientType=1 ); /* IE6-9 */
        border-radius: inherit;color: #fff;font-size: 15px;z-index: 3;direction: rtl;text-indent: 14px;letter-spacing: 2px;
        overflow: hidden;
    }
    #needsBar .pMo{position: absolute;text-align: right;width: 100%;direction: rtl;text-indent: 20px;font-size: 12px;}
    .optionsSection{display: inline-block;width: 100%;padding: 10px 0px;}
    .optionsSection li input{display: none;}
    .optionsSection .options li{width: 31.333%; color: #c2c2c2; height: 40px;border: #d3d3d3 thin solid;line-height: 40px;text-align: center;text-indent: 0px;float: left;font-size: 18px; margin-right: 2%; cursor: pointer;}
    .optionsSection .options li:last-child{margin-right: 0px;}
    .optionsSection .optionLabel{float: left;width: 100%;text-align: left;font-size: 15px;height: 25px;}

    #addToCart{height: 60px;line-height: 60px; background-color: #76bd22;color: #fff;font-size: 18px;margin-top: 10px; text-transform: uppercase;}
    .etaDate{font-style: italic;}

    .prodStyle{width: 60%;float: left;}

    .prodStyle .storyHeader{width: 90%;height: 86px;margin: 0px auto;margin-top: 10px;margin-bottom: 10px;position: relative;}
    .prodStyle .storyHeader p{line-height: 50px;font-size: 14px;text-transform: uppercase;background-color: #F1F1F1;float: left;margin-top: 18px;position: absolute;width: 90%;text-indent: 66px;z-index: -1;margin-left: 10%;color: #A5A5A5;}
    .prodStyle .storyDetails{width: 90%; margin: 0px auto;}
    .prodStyle .uName{font-size: 18px;margin-top: -2px;margin-bottom: 5px;}
    .prodStyle .postDetailAvatarFrame{margin-left: 0px !important;}
    .prodStyle .storyBehind{line-height: 20px;}

    .prodInfo{width: 40%; float: left;}
    .prodInfo ul{padding: 2% 6%;border-left: #c2c2c2 thin solid;border-bottom: #c2c2c2 thin solid;min-height: 40px;padding: 7% 6%;}
    .prodInfo ul:last-child{border-bottom: none;}
    .prodInfo .title{font-size: 13px;color: #666;padding-bottom: 5px;}
    .bottomCol{border-top: #c2c2c2 thin solid;margin-top: 20px; color: #9e9e9e; font-size: 12px;}
    .prodInfo .showChart{cursor: pointer; color: #666;}

    .priceSection{border-top: #c2c2c2 thin solid;border-bottom: #c2c2c2 thin solid;padding-bottom: 10px;margin-top: 10px;margin-bottom: 5px;}
    .priceSection .productPrice{font-size: 25px;height: 50px;line-height: 50px;}
    .priceSection .regPrice{color: #c2c2c2;}
    .showing{display: block !important;}

    .scribble{font-family: 'Shadows Into Light', cursive;}

    #sizeChart{display: none; position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; z-index: 10; display: none;}
    .theHaze{position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; background-color: #fff; opacity: .7;}
    #sizeChart img{position: absolute;width: 700px;top: 50%;margin-top: -300px;left: 50%;margin-left: -350px;z-index: 11;}

    .prodShareButts{display: inline-block;}
    .prodShareButts li{height: 50px; width: 60px; float: left; background-image: url("/images/prodShare.png"); background-repeat: no-repeat;background-size: auto 94%;}
</style>

<div class="shopCol">
    <div class="productDetails">
        <ul class="productDeets">
            <li class="prodName"><?= $_data->product->product_name ?><a class="fashiolista-love-button" href="http://www.fashiolista.com/item_add_oe/" data-url="http://www.dahliawolf.com/shop/<?= $_data->product->id_product ?>" data-version="simple" data-layout="2" data-counter="0"><img style="margin-left: 10px;" src="http://u.fashiocdn.com/images/fashiolista-button-2.png" alt="Love it" width="24" height="24"></a></li>
            <li class="inspBy"><span class="dahliaPink">Inpiration by</span> <a href="/<?= $_data->product->username ?>"><?= $_data->product->username ?></a></li>
        </ul>
        <? if (!empty($_data->product) && !empty($_data->files)): ?>
                <ul class="productImagesFrame" id="prodImgFrame">
                    <? foreach ($_data->files as $i => $file): ?>
                        <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id . '&width=' . 500; ?>
                        <li <?= $i == 0 ? 'class="showing"' : '' ?> >
                            <img class="small" id="image-<?= $i ?>" src="<?= $image_url ?>" />
                        </li>
                    <? endforeach ?>
                </ul>
            <? if (!empty($_data->product) && !empty($_data->files)): ?>
                <ul id="thumbs">
                    <? foreach ($_data->files as $i => $file): ?>
                        <? $image_url = CDN_IMAGE_SCRIPT . $file->product_file_id . '&width=100&height=' . $height; ?>
                        <li>
                            <img src="<?= $image_url ?>" />
                        </li>
                    <? endforeach ?>
                </ul>
            <? endif ?>
        <? endif ?>
    </div>

    <div class="productCTA">
        <div class="needSection">
            <ul class="prodShareButts">
                <li class="cursor" id="shareFacebook"></li>
                <a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com;media=http://content.dahliawolf.com/shop/product/image.php?file_id=<?= $_data->product->product_file_id ?>&amp;width=&amp;height=" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                    <li id="sharePinterest"></li>
                </a>
                <a href="http://www.tumblr.com/share/photo?source=http%3A%2F%2Fcontent.dahliawolf.com%2Fshop%2Fproduct%2Fimage.php%3Ffile_id=<?= $_data->product->product_file_id ?>%26width%3D%26height%3D&amp;caption=Check%20this%20out%20at%20%23Dahliawolf&amp;click_thru=http%3A%2F%2Fwww.dahliawolf.com%2Fshop%2F<?= $_data->product->id_product ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                    <li id="shareTumbler"></li>
                </a>
                <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&amp;url=http://www.dahliawolf.com/shop/<?= $_data->product->id_product ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                    <li id="shareTwitter"></li>
                </a>
                <a href="https://plus.google.com/share?url=http://www.dahliawolf.com/shop/<?= $_data->product->id_product ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                    <li id="shareGplus"></li>
                </a>
                <a href="mailto:?subject=Check out Dahliawolf.com&amp;body=Check this out at http://www.dahliawolf.com/shop/<?= $_data->product->id_product ?>.">
                    <li id="shareEmail"></li>
                </a>
            </ul>

            <!--<ul>
                <li class="nMo"><?= $percentage ?>% OF GOAL</li>
                <li class="nMoDesc">20 pre sales needed to begin production on this item</li>
                <li>
                    <ul id="needsBar">
                        <li class="pComp" style="width: <?php echo ($total_sales/20)*100 ?>%;"><?= $total_sales ?>/20</li>
                        <li class="pMo">only <?= $sales_needed ?> MORE</li>
                    </ul>
                </li>
            </ul>-->
        </div>
        <div class="priceSection">
            <ul>
                <li class="productPrice">$<?= $_data->product->on_sale ? number_format((float)$_data->product->sale_price, 2, '.', '') : number_format((float)$_data->product->price, 2, '.', '') ?></li>
                <?php if($_data->product->on_sale): ?>
                    <li class="regPrice">Regular Price $<?=  number_format((float)$_data->product->price, 2, '.', '') ?> SAVE 30%</li>
                <? endif ?>
            </ul>
        </div>
        <form id="addItemToCartForm" action="/action/shop/add_item_to_cart.php" method="post">
            <input type="hidden" name="ajax" value="true">
            <input type="hidden" name="id_product" value="<?= $_data->product->id_product ?>" >
            <input type="hidden" name="quantity" value="1" style="font-size: 20px;" />
            <div class="optionsSection">
                <? if (!empty($_data->combinations)): ?>
                    <ul class="options">
                        <? foreach($_data->combinations as $i => $combination): ?>
                            <li>
                                <input type="radio" name="id_product_attribute" id="id_product_attribute-<?= $i ?>" value="<?= $combination->id_product_attribute ?>"<?= ($combination->default_on == 1) ? ' checked="checked"' : '' ?>>
                                <label for="id_product_attribute-<?= $i ?>"><?= str_replace('Size: ', '', $combination->attribute_names) ?></label>
                            </li>
                        <? endforeach ?>
                    </ul>
                <? endif ?>
            </div>
            <div class="orderButton">
                <a onclick="$(this).closest('form').submit()">
                    <p id="addToCart" class="button"><?= $_data->product->on_sale ? 'Sponsor Now' : 'Add To Bag' ?></p>
                </a>
            </div>
            <div class="etaDate">*Estimated Shipping Date: <?= $_data->product->commission_to_date ? $_data->product->commission_to_date : ' Immediately' ?></div>
        </form>
    </div>
    <div style="clear: left;"></div>

    <div class="prodStyle bottomCol">
        <ul class="storyHeader">
            <li></li>
            <li id="avatarSpot"><p><span class="scribble">THE STORY</span>: <?= $_data->product->product_name ?></p></li>
        </ul>
        <ul class="storyDetails">
            <li class="dahliaPink scribble" style="font-size: 13px;">inpiration by</li>
            <li class="uName"><a href="/<?= $_data->product->username ?>"><?= $_data->product->username ?></a></li>
            <li class="storyBehind"><?= $_data->product->story_behind_design ?></li>
        </ul>
    </div>
    <div class="prodInfo bottomCol">
        <ul>
            <li class="title">Product Details</li>
            <li><?= $_data->product->design_description ?></li>
        </ul>
        <ul>
            <li class="title">Size & Fit</li>
            <li>Take a look at our awesome <span class="showChart">chart</span> to make sure its the perfect fit</li>
        </ul>
        <ul>
            <li class="title">Shipping & Returns</li>
            <li>14 days after purchase</li>
        </ul>
        <ul>
            <li class="title">Fabric</li>
            <li><?= $_data->product->reference ?></li>
        </ul>
    </div>
    <div style="clear: left;"></div>
</div>
<div id="sizeChart">
    <div class="theHaze"></div>
    <img src="/images/dahliawolf_sizechart.jpg">
</div>

<script>
    $(function() {
        var data = <?= json_encode( $_data->product ) ?>;
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
        dahliawolf.member.get({user_id:data.user_id, username:data.username, viewer_user_id:(dahliawolf.isLoggedIn ? dahliawolf.userId : '')}, function(data) {
            $('#avatarSpot').prepend(new dahliawolf.$hoverAvatar(data.data.get_user));
        });

        $('.showChart').on('click', function() {
             $('#sizeChart').fadeIn(200).on('click', function() {
                 $(this).fadeOut(200);
             });
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

    $('#prodFollow').on('click', function() {
       var $el = $(this);

       if( $el.hasClass('isnotfollowing') ) {
           $el.html('FOLLOWING').removeClass('isnotfollowing');
       } else {
           $el.html('FOLLOW+').addClass('isnotfollowing');
       }
    });
</script>

<? include $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>