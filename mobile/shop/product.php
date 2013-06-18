<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Product Details - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>
<div class="shop body">
	<?
	include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
	?>
	
	<h2>Shop</h2>
	
	<div class="product">
		<div class="product-details">
			<? 
			if (!empty($_data['product']) ) {
				?>
				<div class="info">
	            	<?
					if(!empty($_data['product']['product']['username'])) {
						?>
	                    <div class="user">
	                        <p class="title"><img src="/mobile/images/wild-img.png" alt="Top Wild Member:" /></p>
	                        
	                        <div class="card">
	                            <p class="avatar"><img src="/avatar.php?user_id=<?= $_data['product']['product']['user_id'] ?>&size=75" /></p>
	                            
	                            <p class="username"><?= $_data['product']['product']['username'] ?></p>
	                            
	                            <ul class="actions">
	                            	<?
										// Or follow/unfollow
										if (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] != $_data['product']['product']['user_id']) {
											$is_followed = !empty($_data['user']['is_followed']);
										 	?>
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
										 	<?
										}
						        		?>
	                            	
	                              
	                                <!--<li class="message"><a>Message</a></li>-->
	                            </ul>
	                        </div>
	                    </div>
	                    <?
					}
					?>
					
					<h3 class="name"><?= $_data['product']['product']['product_name'] ?></h3>
					<!--<p class="price"><del><span>$<?= $_data['product']['product']['price'] ?></span></del> <span class="sale">50% Off</span></p> //-->
					<p class="price"><span>$<?= number_format($_data['product']['product']['price'], 2, '.', ',') ?></span></p>
					
					<form action="/action/shop/add_item_to_cart.php" method="post">
						<?
						if (!empty($_GET['session_type'])) {
							?>
							<input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
							<?
						}	
						?>
						<input type="hidden" name="id_product" value="<?= $_data['product']['product']['id_product'] ?>" >
						<label>Quantity</label>
						<input type="text" name="quantity" value="1" />
						<label>Select Size</label>
						<?
						if (!empty($_data['product']['combinations'])) {
							?>
							<ul class="options">
								<?
					   			foreach($_data['product']['combinations'] as $i => $combination) {
					   				?> 
					   				<li>
					   					<input type="radio" name="id_product_attribute" id="id_product_attribute-<?= $i ?>" value="<?= $combination['id_product_attribute'] ?>"<?= ($combination['default_on'] == 1) ? ' checked="checked"' : '' ?>>
					   					<label for="id_product_attribute-<?= $i ?>"><?= str_replace('Size: ', '', $combination['attribute_names']) ?></label>
					   				</li>
					   				<?
					   			} 
								?>
							</ul>
							<?
						}
				   		
	                    if ($_data['show_add_to_wishlist']) {
	                        ?>
	                        <p class="wishlist"><a href="/action/shop/add_item_to_wishlist.php?id_product=<?= $_GET['id_product'] ?>">Add To Wishlist</a></p>
	                        <?
	                    }
	                    ?>
	                    <!-- <p class="button"><a href="/shop/checkout.php">Pre-Order</a></p> //-->
	                    <p class="button"><a onclick="$(this).closest('form').submit()">Add to Cart</a></p>
					</form>
					
					<dl class="additional-info accordion">
						<dt>Description</dt>
						<dd><?= $_data['product']['product']['description'] ?></dd>
						<dt>Size &amp; Fit</dt>
						<dd></dd>
						<dt>Shipping &amp; Returns</dt>
						<dd></dd>
						<dt>Fabric</dt>
						<dd></dd>
						<dt>Share</dt>
						<dd></dd>
					</dl>
				</div>
				<?
				}
			?>
		</div>
		<?
		$width = 360;
		$height = 540;
		if (!empty($_data['product']) && !empty($_data['product']['files'])) {
			?>
			<ul class="product-images">
				<?
				foreach ($_data['product']['files'] as $i => $file) {
					$image_url = CDN_IMAGE_SCRIPT . $file['product_file_id'] . '&amp;width=' . $width . '&amp;height=' . $height;
					?>
					<li id="image-<?= $i ?>">
						<img src="<?= $image_url ?>" width="<?= $width ?>" height="<?= $height ?>" />
					</li>
					<?
				}
				?>
			</ul>
			<?
		}
		?>
	</div>
</div>
<? 
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>