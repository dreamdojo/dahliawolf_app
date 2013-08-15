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
?>

<style>
    .shop-wishlist-button{padding: 12px 1px;font-size: 18px;text-align: center; color: #fff; cursor: pointer;}
    .not-in-wishlist{background-color: #363636;}
    .is-in-wishlist{background-color: #f4a5b4;}
</style>

<?
if( isset($_GET['username']) && !empty($_data['product']['product']['posts'][0]['username']) && $_GET['username'] != $_data['product']['product']['posts'][0]['username'] ) {
    echo 'This not '.$_GET['username'].'\'s Product';
    die();
} ?>


<div class="shop body">
	<div class="product">
		<div class="product-details">
			<? include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php"; ?>
			
			<h2>Shop</h2>
			<? if ( !empty($_data['product']) ): ?>
			    <script>console.log(<?= json_encode( $_data['product'] ) ?>);</script>
                <? $width = 74; $height = 111; ?>
				<? if (!empty($_data['product']['files'])): ?>
					    <ul class="thumbnails">
					    	<? foreach ($_data['product']['files'] as $i => $file): ?>
						    	<? $image_url = CDN_IMAGE_SCRIPT . $file['product_file_id'] . '&amp;width=' . $width . '&amp;height=' . $height; ?>

                                <li>
                                    <a href="#image-<?= $i ?>" rel="scroll" data-offset="150">
                                        <img src="<?= $image_url ?>" width="<?= $width ?>" height="<?= $height ?>" />
                                    </a>
                                </li>
                            <? endforeach ?>
                        </ul>
				<? endif ?>
			<div class="info">
            	<? if( !empty($_data['product']['product']['username']) ): ?>
                    <div class="user">
                        <p class="title"><img src="/mobile/images/wild-img.png" alt="Top Wild Member:" /></p>
                        
                        <div class="card">
                            <p class="avatar"><img src="<?= $_data['product']['product']['posts'][0]['avatar'] ?>&amp;width=75" /></p>

                            <p class="username"><?= $_data['product']['product']['posts'][0]['username']?></p>
                            
                            <ul class="actions">
                            	<? if (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] != $_data['product']['product']['user_id']): ?>
                                    <? $is_followed = !empty($_data['user']['is_followed']); ?>
                                    <li class="follow">
                                        <div class="sysBoardFollowAllButton<?= $is_followed ? ' hidden' : '' ?>" id="FADD97">
                                            <a href="/action/follow.php?user_id=<?= $_data['product']['product']['user_id'] ?>" class="Button12 Button OrangeButton" rel="follow">
                                                <strong>Follow</strong><span></span>
                                            </a>
                                        </div>
									 	<div class="sysBoardUnFollowAllButton<?= !$is_followed ? ' hidden' : '' ?>" id="FREM97">
						                	<a href="/action/unfollow.php?user_id=<?= $_data['product']['product']['user_id'] ?>" class="Button12 Button OrangeButton disabled" rel="unfollow">
						                		<strong>Unfollow</strong><span></span>
						                	</a>
						                </div>
						            </li>
							    <? endif ?>
                            </ul>
                        </div>
                    </div>
                <? endif ?>

				<h3 class="name"><?= $_data['product']['product']['product_name'] ?></h3>
				<? if( $_data['product']['product']['status'] == 'Pre Order'): ?>
                    <p class="price"><del><span>$<?= number_format( ($_data['product']['product']['price']), 2, '.', ',') ?></span></del> <span class="sale">Pre Order 50% Off</span></p>
                <? else: ?>
                    <p class="price"<?= $_data['product']['product']['on_sale'] == '1' ? ' style="text-decoration: line-through;"' : '' ?>><span>$<?= number_format($_data['product']['product']['price'], 2, '.', ',') ?></span></p>
                <? endif ?>

                <? if ($_data['product']['product']['on_sale'] == '1'): ?>
					<p class="sale-price">$<?= number_format($_data['product']['product']['sale_price'], 2, '.', ',') ?></p>
				<? endif ?>
				
				<? if( $_data['product']['product']['status'] != 'Coming Soon' ): ?>
                    <form action="/action/shop/add_item_to_cart.php" method="post">
                        <input type="hidden" name="id_product" value="<?= $_data['product']['product']['id_product'] ?>" >
                        <label>Quantity</label>
                        <input type="text" name="quantity" value="1" />
                        <label>Select Size</label>
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
                        <p class="button"><a onclick="$(this).closest('form').submit()">Add to Cart</a></p>
                    </form>
                <? endif ?>
                <div>
                    <? if ( $_data['show_add_to_wishlist'] ): ?>
                        <p class="shop-wishlist-button not-in-wishlist" data-id="<?= $_data['product']['product']['id_product'] ?>">Add To Wishlist</p>
                    <? else: ?>
                        <p class="shop-wishlist-button is-in-wishlist" data-id="<?= $_data['product']['product']['id_product'] ?>">Item Is In Wishlist</p>
                    <? endif ?>
                </div>

				<dl class="additional-info accordion">
					<dt>Description</dt>
					<dd><?= $_data['product']['product']['design_description'] ?></dd>
					<dt>Size &amp; Fit</dt>
					<dd><img class="sizeAndFit"src=/images/dahliawolf_sizechart.jpg></dd>
					<dt>Shipping &amp; Returns</dt>
					<dd></dd>
					<dt>Fabric</dt>
					<dd></dd>
					<dt>Share</dt>
					<dd></dd>
				</dl>
			</div>
			<? endif?>
		</div>
		<? $width = 600; $height = 900; ?>
		<? if (!empty($_data['product']) && !empty($_data['product']['files'])): ?>
			<ul class="product-images">
				<? foreach ($_data['product']['files'] as $i => $file): ?>
					<? $image_url = CDN_IMAGE_SCRIPT . $file['product_file_id'] . '&amp;width=' . $width . '&amp;height=' . $height; ?>
					<li id="image-<?= $i ?>">
						<img src="<?= $image_url ?>" width="<?= $width ?>" />
					</li>
				<? endforeach ?>
			</ul>
	    <? endif ?>
	</div>
</div>

<script>
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