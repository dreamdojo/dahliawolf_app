<?
$pageTitle = "Shop - Products";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

require DR . '/includes/php/classes/Product_Listing.php';
?>
<div class="shop body">
	<?
	include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
	?>
	
	<h2>Shop</h2>
	
	<?
	
	$Product_Listing = new Product_Listing();
	$Product_Listing->output($_data['products']);
	/*if (!empty($_data['products'])) {
		foreach ($_data['products'] as $product) {
			$product_url = '/shop/product.php?id_product=' . $product['id_product'];
			?>
			<li>
				<p class="image">
					<a href="<?= $product_url ?>">
						<img src="http://www.dahliawolf.com/shop/media/catalog/product/i/m/image2013-03-05-01-21-08_front.png" width="240" />
					</a>
				</p>
				<p class="new"><a href="<?= $product_url ?>">New</a></p>
				<div class="info">
					<h3 class="name"><a href="<?= $product_url ?>"><?= $product['product_lang_name'] ?></a></h3>
					<p class="price">$<?= number_format($product['price'], 2, '.', ',') ?></p>
					<p class="user">Justin Mavandi</p>
				</div>
			</li>
			<?
		}
	}*/
	
	/*
	foreach (range(1, 8) as $i) {
		$product_url = '/shop/product.php';
		?>
		<li>
			<p class="image">
				<a href="<?= $product_url ?>">
					<img src="http://www.dahliawolf.com/shop/media/catalog/product/i/m/image2013-03-05-01-21-08_front.png" width="240" />
				</a>
			</p>
			<p class="new"><a href="<?= $product_url ?>">New</a></p>
			<div class="info">
				<h3 class="name"><a href="<?= $product_url ?>">Dress It</a></h3>
				<p class="price">$48.00</p>
				<p class="user">Justin Mavandi</p>
			</div>
		</li>
		<?
	}
	*/
	?>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>