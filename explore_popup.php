<?php
include 'config/config.php';

$calls = array(
	'get_product_details' => array(
		'id_product' => $_GET['id_product']
		, 'id_shop' => SHOP_ID
		, 'id_lang' => LANG_ID
		//, 'user_id' => !empty($user) ? $user : NULL
	)
);

$data = commerce_api_request('product', $calls, true);

$product = $data['data']['get_product_details']['data'];
$inspirations = $product['product']['posts'];

$inspirations = array_reverse($inspirations);

$left_col = array();
$right_col = array();
foreach($inspirations as  $i=>$prod){
    if($prod['username'] == $product['product']['username']){
        array_unshift($left_col, $prod);
    } else {
        if(($i % 2) == 0){
            $left_col[] = $prod;
        }else{
            $right_col[] = $prod;
        }
    }
}

foreach($product['files'] as $file){
	$images[] = $file['product_file_id'];
}
$cheater = 50;
?>

<script>console.log(<?=  json_encode($data) ?>);</script>
<div id="thewrap">
<div id="product-details">
    <div id="pull-me">VIEW INSPIRATION</div>
    <div class="product-image-frame">
    	<img id="theMainArrow" src="/images/next-arrow.png" />
    	<img id="theMainProductImage" src="<?= $image_url = CDN_IMAGE_SCRIPT . $product['files'][0]['product_file_id'] ?>" />
        <div id="share-menu">
            <ul>
                <li onclick="postToFacebook();">FACEBOOK</li>
                <a href="https://twitter.com/intent/tweet?text=<?= $product['product']['product_name'] ?>&url=http://www.dahliawolf.com/explore?product_id=<?= $product['product']['id_product'] ?>&via=Dahliawolf">
                    <li>TWITTER</li>
                </a>
                <a href="<?= 'http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com&media='.$image_url = CDN_IMAGE_SCRIPT . $product['files'][0]['product_file_id'].'&description='.$product['product']['product_name'] ?>">
                    <li>PINTEREST</li>
                </a>
            </ul>
        </div>
        <div id="product-options">
            <img id="share-img" src="/images/share.png" />
            <? if($product['product']['status'] == 'Live'): ?>
                <a href="/shop/<?= $product['product']['id_product'] ?>"><div class="buy-butt">BUY</div></a>
            <? endif ?>
            <? if($product['product']['status'] == 'Pre Order'): ?>
                <a href="/shop/<?= $product['product']['id_product'] ?>"><div class="buy-butt">Pre-Order</div></a>
            <? endif ?>
            <? if($product['product']['status'] == 'Coming Soon' || $product['product']['status'] == 'Live' || $product['product']['status'] == 'Pre Order'): ?>
                <a href="/action/shop/add_item_to_wishlist.php?id_product=<?= $product['product']['id_product'] ?>"><div class="wl-butt">WISHLIST</div></a>
            <? endif ?>
        </div>
    </div>
    <div id="product-description">
    	<p class="product-details-title">
        	DESIGN DESCRIPTION
        </p>
        <p class="product-details-content">
			<?= $product['product']['design_description'] ?>
        </p>
        <p class="product-details-title">
        	THE STORY BEHIND DESIGN
        </p>
        <p class="product-details-content">
        	<?= $product['product']['story_behind_design'] ?>
        </p>
    </div>
</div>

<div id="inspiration">
    <div id="left-eye" class="eye">
		<? foreach($left_col as $g=>$prod): ?>
            <div class="prod-frame">
            	<img class="inspiration-image" src="<?= $prod['source'].$prod['imagename'] ?>" />
				<? if($g == 0): ?>
                    <div id="winner-box">
                        <div class="avatar-box">
                            <a href="/<?= $prod['username'] ?>"><img src="<?= $prod['avatar'] ?>" /></a>
                        </div>
                        <div class="winner-orange">
                            <p><span>WINNER</span> with <?= ($prod['total_likes']+$cheater+30) ?> votes</p>
                        </div>
                        <div class="winner-gray">
                            <p><a href="/profile?username=<?= $prod['username'] ?>"><?= $prod['username'] ?></a></p>
                        </div>
                    </div>
                <? else: ?>
                    <div class="winner-box">
                        <div class="avatar-box">
                            <img src="<?= $prod['avatar'] ?>" />
                        </div>
                        <div class="non-winner-name">
                            <p><a href="/<?= $prod['username'] ?>"><?= $prod['username'] ?></a></p>
                        </div>
                        <div class="non-winner-votes">
                            <p><?= ($prod['total_likes']+$cheater) ?> votes</p>
                        </div>
                	</div>             
                <? endif ?>
            </div> 
        <? endforeach ?>
    </div>
    <div id="right-eye" class="eye">
    	<? foreach($right_col as $prod): ?>
            <div class="prod-frame">
            	<img class="inspiration-image" src="<?= $prod['source'].$prod['imagename'] ?>" />
                <div class="winner-box">
                    <div class="avatar-box">
                        <a href="/<?= $prod['username'] ?>"><img src="<?= $prod['avatar'] ?>" /></a>
                    </div>
                    <div class="non-winner-name">
                        <p><a href="/<?= $prod['username'] ?>"><?= $prod['username'] ?></a></p>
                    </div>
                    <div class="non-winner-votes">
                        <p><?= ($prod['total_likes']+$cheater) ?> votes</p>
                    </div>
                </div>             
            </div>
        <? endforeach ?>
    </div>
</div>
</div>
<script>
var imgMoney = Object();
imgMoney.images = Array();
imgMoney.images = <? echo json_encode($images) ?>;
imgMoney.product = <? echo json_encode($product['product']) ?>;
imgMoney.imgUrl = "http://content.dahliawolf.com/shop/product/image.php?file_id=";
imgMoney.index = 0;
imgMoney.outlet = $('#theMainProductImage');
imgMoney.arrow = $('#theMainArrow');
imgMoney.activateButton = $('#pull-me');
imgMoney.descriptionBox = $('#product-details');
imgMoney.inspirationBox = $('#inspiration');
imgMoney.isInspirationOpen = false;
imgMoney.inspirationSpeed = 200;

imgMoney.getImgUrl = getImgUrl;
imgMoney.getNextImg = getNextImg;
imgMoney.getCurrentImageId = getCurrentImageId;
imgMoney.init = imgMoneyInit;
imgMoney.toggleInspiration = toggleInspiration;

function toggleInspiration(){
	if(!imgMoney.isInspirationOpen){
		imgMoney.inspirationBox.show();
		imgMoney.descriptionBox.animate({'margin-left': 0+'%'}, imgMoney.inspirationSpeed);
		imgMoney.inspirationBox.animate({'margin-left': 50+'%'}, imgMoney.inspirationSpeed);
		imgMoney.isInspirationOpen = true;
		imgMoney.activateButton.hide();
	}else{
		imgMoney.descriptionBox.animate({'margin-left': 25+'%'}, imgMoney.inspirationSpeed);
		imgMoney.inspirationBox.animate({'margin-left': 25+'%'}, imgMoney.inspirationSpeed);
		imgMoney.isInspirationOpen = false;
	}
}

function getCurrentImageId(){
	return imgMoney.images[this.index];
}

function getNextImg(){
	imgMoney.index++;
	(imgMoney.index > (imgMoney.images.length-1) ? imgMoney.index = 0 : '');
	imgMoney.outlet.attr('src', imgMoney.getImgUrl());
}

function getImgUrl(){
	return imgMoney.imgUrl+this.getCurrentImageId()+'&width=400&height=600';
}

function imgMoneyInit(){
    window.history.replaceState( {} , 'Post Detail', '/shop/'+imgMoney.product.id_product );
	imgMoney.arrow.bind('click', imgMoney.getNextImg);
	imgMoney.activateButton.bind('click', imgMoney.toggleInspiration);
    sendToAnal({name:'Viewing shop item', item:'<?= $product['product']['product_name'] ?>'});
    imgMoney.toggleInspiration();
}

imgMoney.init();

$('#share-img, #share-menu').hover(function(){
	$('#share-menu').show()
},
function(){
	$('#share-menu').hide()
});
</script>