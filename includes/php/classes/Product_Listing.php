<?
class Product_Listing {
	private $class = 'products';
	private $empty_msg = '<img src="/images/pre-order-placeholder.png" alt="Empty" width="100%" />';
	
	private $options = array(
		'image_dimensions' => array(240, 360)
	);
	
	public function __construct($options = array()) {
		$this->options = array_merge($this->options, $options);
	}
	
	public function output($products) {
		if (empty($products)) {
			?>
			<p><?= $this->empty_msg ?></p>
			<?
		}
		else {
			$width = $this->options['image_dimensions'][0];
			$height = $this->options['image_dimensions'][1];
			?>
			<ul class="<?= $this->class ?>">
				<?
				foreach ($products as $i => $product) {
					$product_url = CR . '/shop/product.php?id_product=' . $product['id_product'];
					$image_url = cdn_product_image($product['product_file_id'], $width, $height);
					?><li>
						<p class="image">
							<a href="<?= $product_url ?>">
								<img src="<?= $image_url ?>" alt="<?= $product['product_name'] ?>" width="<?= $width ?>" height="<?= $height ?>" />
							</a>
						</p>
						<?
						if (!empty($product['is_new'])) {
							?>
							<p class="new"><a href="<?= $product_url ?>">New</a></p>
							<?
						}
						?>
						<div class="info">
							<h3 class="name"><a href="<?= $product_url ?>"><?= $product['product_name'] ?></a></h3>
							<p class="price"<?= $product['on_sale'] == '1' ? ' style="text-decoration: line-through;"' : '' ?>>$<?= number_format($product['price'], 2, '.', ',') ?></p>
                            
							<?
							if ($product['on_sale'] == '1') {
								?>
								<p class="sale-price">$<?= number_format($product['sale_price'], 2, '.', ',') ?></p>
								<?
							}
							
							if (!empty($product['username'])) {
								?>
								<p class="user"><?= $product['username'] ?></p>
								<?
							}
							
							if (!empty($product['status'])) {
								?>
                            	<div class="up-info"><a href="#"><?= $product['status'] ?></a></div>
                                <?
							}
							
							if (array_key_exists('is_wishlist', $this->options) && $this->options['is_wishlist'] == true) {
								?>
                                <div class="remove"><a href="/action/shop/remove_item_from_wishlist.php?id_favorite_product=<?= $product['id_favorite_product'] ?>">Remove</a></div>
                                <?
							}
							
							?>
						</div>
					</li><?
				}
				?>
			</ul>
			<?
		}
	}
	
}
?>