<?
$pageTitle = "Shop - Product";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>
<div class="shop body">
	<div class="product">
		<div class="product-details">
			<?
			include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
			?>
			
			<h2>Shop</h2>
			<? 
			if (!empty($_data['product']) ) {
				$width = 74;
				$height = 111;
				if (!empty($_data['product']['files'])) {
					?>
					<ul class="thumbnails">
						<?
						foreach ($_data['product']['files'] as $i => $file) {
							$image_url = CDN_IMAGE_SCRIPT . $file['product_file_id'] . '&amp;width=' . $width . '&amp;height=' . $height;
							?>
							<li>
								<a href="#image-<?= $i ?>" rel="scroll" data-offset="150">
									<img src="<?= $image_url ?>" width="<?= $width ?>" height="<?= $height ?>" />
								</a>
							</li>
							<?
						}
						?>
					</ul>
					<?
				}
			?>
			<div class="info">
            	<?
				if(!empty($_data['product']['product']['username'])) {
					?>
                    <div class="user">
                        <p class="title"><img src="/mobile/images/wild-img.png" alt="Top Wild Member:" /></p>
                        
                        <div class="card">
                            <p class="avatar"><img src="<?= $_data['product']['product']['posts'][0]['avatar'] ?>&amp;width=75" /></p>

                            <p class="username"><?= $_data['product']['product']['posts'][0]['username']?></p>
                            
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
				<? if( $_data['product']['product']['status'] == 'Pre Order'): ?>
                    <p class="price"><del><span>$<?= number_format( ($_data['product']['product']['price'] * 2), 2, '.', ',') ?></span></del> <span class="sale">Pre Order 50% Off</span></p>
                <? endif ?>
				<p class="price"><span>$<?= number_format($_data['product']['product']['price'], 2, '.', ',') ?></span></p>
				
				<form action="/action/shop/add_item_to_cart.php" method="post">
					<input type="hidden" name="id_product" value="<?= $_data['product']['product']['id_product'] ?>" >
					<label>Quantity</label>
					<input type="text" name="quantity" value="1" />
					<label>Select Size</label>
					<?
					//var_dump($data);
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
					<dd><?= $_data['product']['product']['design_description'] ?></dd>
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
		$width = 600;
		$height = 900;
		if (!empty($_data['product']) && !empty($_data['product']['files'])) {
			?>
			<ul class="product-images">
				<?
				foreach ($_data['product']['files'] as $i => $file) {
					$image_url = CDN_IMAGE_SCRIPT . $file['product_file_id'] . '&amp;width=' . $width . '&amp;height=' . $height;
					?>
					<li id="image-<?= $i ?>">
						<img src="<?= $image_url ?>" width="<?= $width ?>" />
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
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>