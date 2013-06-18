<?
$pageTitle = "Explore - Dahlia\Wolf";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";   

if(isset($_GET['index'])){
	$item = $_GET['index'];
}else{$item = 0;}

function loadPost($id){
	$calls = array(
		'get_product_details' => array(
			'id_product' => $id
			, 'id_shop' => SHOP_ID
			, 'id_lang' => LANG_ID
			//, 'user_id' => !empty($user) ? $user : NULL
		)
	);

	$blop = commerce_api_request('product', $calls, true);
	
	return $blop['data']['get_product_details']['data'];
}

?>
<style>
#main-col{width:98%; margin:0px auto; position:relative;}
.product-box{ width: 100%; text-align:center; overflow:hidden; position: relative; background-color:#fff; border-bottom:#c2c2c2 1px solid;}
.pb-inner-frame{width:90%; background-color:#fff; margin:0px auto; height:97%; -moz-box-shadow: 10px 10px 5px rgb(177, 177, 177); -webkit-box-shadow: 10px 10px 5px rgb(177, 177, 177);box-shadow: 10px 10px 5px rgb(177, 177, 177);}
.pb-top-row{width: 100%; height: 12%; padding-top:3%; margin-left: 1%;text-align:left;position: relative;display: inline-block;}
.avatar-frame{ float: left;width: 8%;display: inline-block;}
.avatar-frame img{ width:100%;}
.prod-deets{float: left;margin-left: 1%;width: 75%;}
.insp-by{color:#e28395;}
.prod-title{ color:#959595;text-align: left;font-size: 1em;}
.prod-img-frame{width:98%; height: 75%; overflow:hidden; text-align: center;margin: 0px auto; border:#c2c2c2 thin solid; position:relative}
.prod-butt{width:49.9%; float:left; background-color:#FFF; color:#c2c2c2; height: 100%;}
.prod-butt p{margin-top: 7%;font-size: 1em;width: 100%;}
.prod-butt img{max-height:100px;}
.want-it img{float:left;height: 100%;}
.vote-box{height: 10%;display: inline-block;width: 100%;}
.prod-inner-frame{position: absolute;height: 100%;overflow: hidden;width: 100%;}
.prod-inner-frame img{min-height: 100%;width: 100%;}
.chillen{display:none};
</style>
<div id="blackOut"></div>
<div id="main-col">
	<? foreach($_data['posts'] as $product): ?>
		<?php 	
			$info = loadPost($product['product_id']); 
			$width = 500;
		?>
		<? var_dump($product) ?>
        <div class="product-box" id="product-box-<?= $product['posting_id'] ?>" data-total="<?= count($images['product']) + count($images['inspirations']) ?>">
                <div class="pb-top-row">
                    <div class="avatar-frame">
                        <img src="<?= $product['avatar'] ?>" />
                    </div>
                    <div class="prod-deets">
                        <div class="insp-by" onclick="goHere('profile.php?username=<?= $product['username'] ?>', false);">
                            Inspired by <?= $product['username'] ?>
                        </div>
                        <div class="prod-title">
                            <?= $product['product_name'] ?>
                        </div>
                    </div>
                </div>
                <div class="prod-img-frame">
                	<div id="product-image-<?= $product['posting_id'] ?>">
                    	<img src="" />
                    </div>    
                    <div id="inspiration-image-<?= $product['posting_id'] ?>">
                    	<img src="" />
                    </div>
                </div>
                <div class="vote-box">
                    <div class="buy-it prod-butt" onclick="sendUserMessage('Shop is coming soon');">
                        <p>BUY IT</p>
                    </div>
                    <div class="want-it prod-butt" onclick="sendUserMessage('Added to wishlist');">
                        <img src="images/explore-star.png" />
                        <p style="width:70%">WANT IT</p>
                    </div>
                </div>
		</div>
	<? endforeach ?>
</div>
<script src="js/jquery.event.move.js"></script>
<script>

function animateImages(x){
	if(shop.leftImage && shop.rightImage){
		lft = (shop.leftImage.offset().left - shop.leftImageOffset) + (x - shop.tmplft);
		rt = (shop.rightImage.offset().left - shop.rightImageOffset) + (x - shop.tmplft);
		shop.activeImage.css('left', x+'px');
		shop.rightImage.css('left', rt+'px');
		shop.leftImage.css('left', lft +'px');
		shop.tmplft = x;
	}
}
//*************************************** MAIN LOOP *********************
$('.prod-inner-frame').on('movestart', function(e){
	if(!shop.busy){
		g = $(e.target.parentNode);
		shop.setImages(g);
		shop.startY = e.distY;
	}
}).bind('move', function(e) {
	if(!shop.busy){
		if ((e.distX > e.distY && e.distX < -e.distY) || (e.distX < e.distY && e.distX > -e.distY)) {
			e.preventDefault();
	  	}else{
			g = $(e.target.parentNode);
			shop.animateImages(e.distX);
		}
	}
}).bind('moveend', function(e) {
	if(!shop.busy){
		if ((e.distX > e.distY && e.distX < -e.distY) || (e.distX < e.distY && e.distX > -e.distY)) {
			id = $(e.target.parentNode).attr('data-id');
			i = shop.posts.indexOf(id);
			if((shop.startY - e.distY) < shop.startY){
				i--;
			}else{
				i++;
			}
			shop.center(shop.posts[i]);
		}else if(!shop.busy){
			shop.finishMove()
		}
	}
});

</script>