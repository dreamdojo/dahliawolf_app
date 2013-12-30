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
				if (!empty($_data['product']['files'])) {
					?>
					<ul class="thumbnails">
						<?
						foreach ($_data['product']['files'] as $i => $file) {
							?>
							<li>
								<a href="#image-<?= $i ?>" rel="scroll" data-offset="150"><img src="http://www.dahliawolf.com/shop/media/catalog/product/i/m/image2013-03-05-01-21-08_front.png" width="75" /></a>
							</li>
							<?
						}
						?>
					</ul>
					<?
				}
			
			/*
			<ul class="thumbnails">
				<?
				foreach (range(1, 5) as $i) {
					?>
					<li>
						<a href="#image-<?= $i ?>" rel="scroll" data-offset="150"><img src="http://www.dahliawolf.com/shop/media/catalog/product/i/m/image2013-03-05-01-21-08_front.png" width="75" /></a>
					</li>
					<?
				}
				?>
			</ul>
			*/
			?>
			<div class="info">
				<div class="user">
					<p class="title">Top Wild Member:</p>
					
					<div class="card">
						<p class="avatar"><img src="/avatar.php?user_id=65&size=75" /></p>
						
						<p class="username">Martina K.</p>
						
						<ul class="actions">
							<li class="follow"><a>Follow</a></li>
							<li class="message"><a>Message</a></li>
						</ul>
					</div>
				</div>
				
				<h3 class="name">Great Woven Blouse</h3>
				<p class="price"><del><span>$48.00</span></del> <span class="sale">50% Off</span></p>
				
				<form>
					<label>Quantity</label>
					<input type="text" name="quantity" value="1" />
					
					<label>Select Size</label>
					<ul class="options">
						<?
						$sizes = array(
							'XS'
							, 'S'
							, 'M'
							, 'L'
						);
						foreach ($sizes as $i => $size) {
							$id = 'size-' . strtolower($size);
							?>
							<li>
								<input type="radio" name="size" id="<?= $id ?>" />
								<label for="<?= $id ?>"><?= $size ?></label>
							</li>
							<?
						}
						?>
					</ul>
				</form>
				
				<p class="wishlist"><a>Add To Wishlist</a></p>
				<p class="button"><a href="/shop/checkout.php">Pre-Order</a></p>
				
				<dl class="additional-info accordion">
					<dt>Description</dt>
					<dd>description goes here description goes here description goes here description goes here description goes here </dd>
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
		if (!empty($_data['product']) && !empty($_data['product']['files'])) {
			?>
			<ul class="product-images">
				<?
				foreach ($_data['product']['files'] as $i => $file) {
					?>
					<li id="image-<?= $i ?>">
						<img src="http://www.dahliawolf.com/shop/media/catalog/product/i/m/image2013-03-05-01-21-08_front.png" width="600" />
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