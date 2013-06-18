<?
$pageTitle = "Explore - Dahlia\Wolf";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";   

if(isset($_GET['index'])){
	$item = $_GET['index'];
}else{$item = 0;}

if(isset($_SESSION['guide_shop']) && $_SESSION['guide_shop']){
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/guide_pop.php";
	$_SESSION['guide_shop'] = false;
}
$image_width = 400;
?>
<style>
#main-col{width:98%; margin:0px auto; position:relative;}
.product-box{ width: 100%; text-align:center; overflow:hidden; position: relative; background-color:#fff; border-bottom:#c2c2c2 1px solid;}
.pb-inner-frame{width:90%; background-color:#fff; margin:0px auto; height:97%; -moz-box-shadow: 10px 10px 5px rgb(177, 177, 177); -webkit-box-shadow: 10px 10px 5px rgb(177, 177, 177);box-shadow: 10px 10px 5px rgb(177, 177, 177);}
.pb-top-row{width: 100%; height: 11%; padding-top:2%; margin-left: 1%;text-align:left;position: relative;display: inline-block;}
.avatar-frame{ float: left;height: 100%;display: inline-block;width: 15%;display: inline-block;overflow: hidden;}
.avatar-frame img{ width:100%;}
.prod-deets{float: left;margin-left: 1%;width: 75%;}
.insp-by{color:#e28395;}
.prod-title{ color:#959595;text-align: left;font-size: 1em;}
.prod-img-frame{width:98%; height: 77%; overflow:hidden; text-align: center;margin: 0px auto; border:#c2c2c2 thin solid; position:relative}
.prod-butt{width:49.9%; float:left; background-color:#FFF; color:rgb(122, 122, 122); height: 100%;}
.prod-butt p{margin-top: 5%;font-size: 1.5em;width: 100%;font-weight: lighter;font-family: helvetica;}
.want-it img{float:left;height: 100%;}
.vote-box{height: 12%;display: inline-block;width: 100%;}
.prod-inner-frame{ position:relative;height: 100%;overflow: hidden;width: 100%;}
.prod-inner-frame img{min-height: 100%;width: 100%;}
.prod-images{position: absolute; width: 100%;}
.chillen{display:none};
</style>
<div id="blackOut"></div>
<div id="main-col">
	<? foreach($_data['posts'] as $product): ?>
		<? //var_dump($product) ?>
        <div class="product-box" id="product-box-<?= $product['posting_id'] ?>" data-id="<?= $product['posting_id'] ?>">
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
                <div class="prod-img-frame" data-id="<?= $product['posting_id'] ?>">
                	<div id="product-image-<?= $product['posting_id'] ?>" class="prod-images optimize-me">
                    	<div class="prod-inner-frame" data-id="<?= $product['posting_id'] ?>">
                        	<img src="<?= $product['image_url'] ?>&width=<?= $image_width ?>" />
                        </div>
                    </div>    
                    <div id="inspiration-image-<?= $product['posting_id'] ?>" class="chillen prod-images optimize-me">
                    	<div class="prod-inner-frame" data-id="<?= $product['posting_id'] ?>">
                        	<img src="<?= $product['inspiration_image_url'] ?>&width=<?= $image_width ?>" />
                        </div>
                    </div>
                </div>
                <div class="vote-box">
                    <div style="border-right: 1px solid #c2c2c2;"class="buy-it prod-butt" onclick="sendUserMessage('Shop is coming soon');">
                        <p>Buy</p>
                    </div>
                    <div class="want-it prod-butt" onclick="sendUserMessage('Added to wishlist');">
                        
                        <p style="color:#e74867;">Wishlist</p>
                    </div>
                </div>
		</div>
	<? endforeach ?>
    <div style="height:50px;"></div>
</div>
<script src="js/jquery.event.move.js"></script>
<script src="js/explore.js"></script>
<script>	
    explore.init(<?= $_data['posts'][0]['posting_id'] ?>);
</script>