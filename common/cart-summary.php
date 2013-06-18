<div class="heading-bar">
	<div class="heading-categories">
		<dl>
			<dt>Categories</dt>
			<dd>
				<?
				if (!empty($_data['categories'])) {
					?>
					<ul>
						<?
						foreach ($_data['categories'] as $category) {
							?>
							<li>
								<a href="<?= CR ?>/shop/?id_category=<?= $category['id_category'] ?>"><?= $category['name'] ?></a>
							</li>
							<?
						}
						?>
					</ul>
					<?
				}
				?>
			</dd>
		</dl>
	</div>
	<div class="cart-summary">
		<dl>
			<dt>Shopping Cart<span class="divider">-</span><span class="cart-subtotal">$<?= !empty($_data['cart']) ? number_format($_data['cart']['cart']['totals']['grand_total'], 2, '.', ',') : '0.00' ?></span></dt>
			<dd>
					<?
					if (!empty($_data['cart']['products'])) {
						?>
						<div class="inner">
							<ul id="heading-cart-products" class="cart-products">
								<?
								foreach ($_data['cart']['products'] as $product) {
		  							$id_product = $product['id_product'];
									$image_url = cdn_product_image($product['product_info']['product_file_id'], 33, 50);
									$name = $product['product_info']['product_lang_name'];
									$quantity = $product['quantity'];
									$price = $product['product_info']['price'];
									?>
									<li>
										<p class="image"><img src="<?= $image_url ?>" alt="<?= $name ?>" /></p>
										<p class="name"><a href="<?= CR ?>/shop/product.php?id_product=<?= $id_product ?>"><?= $name ?></a></p>
										<p class="quantity price"><strong><?= $quantity ?></strong> x $<?= number_format($price, 2) ?></p>
										
										<?
										if (!empty($product['attributes'])) {
				          					$attributes = explode(chr(0x1D), $product['attributes']);
				          					?>
				          					<ul class="options">
					          					<?
					          					foreach ($attributes as $attribute) {
					          						$parts = explode(': ', $attribute);
					          						?>
					          						<li><?= $parts[0] ?>: <?= $parts[1] ?></li>
													<?
												}
												?>
											</ul>
											<?
										}
										?>
									</li>
									<?
								}
								?>
							</ul>
							
							<a href="<?= CR ?>/shop/checkout.php" class="checkout">Checkout</a>
						</div>
						<?
					}
					?>
			</dd>
		</dl>
	</div>
</div>