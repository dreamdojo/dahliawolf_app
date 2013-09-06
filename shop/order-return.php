<?
$pageTitle = "Shop - Order Return";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<div class="shop body checkout order">
	<?
	include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
	?>

	<h2>Order #<?= !empty($_data['order']) ? $_data['order']['id_order'] : '' ?> <span style="font-weight: normal;">(<?= $_data['order']['payment_status'] ?>)</span></h2>

	<form action="<?= CR ?>/action/shop/order_return.php" method="post" class="return">
		<?
		output_order_table($_data['order'], 1);
		?>
		<fieldset>
			<p><strong>How would you like to be refunded?</strong></p>
			<ul class="radios fields">
				<?
				if (!empty($_data['return_types'])) {
					foreach ($_data['return_types'] as $i => $type) {
						$id = 'refund_type_' . $i;
						?><li>
							<input type="radio" id="<?= $id ?>" name="refund_type" value="<?= $type ?>"<?= $i == 0 ? ' checked="checked"' : '' ?> />
							<label for="<?= $id ?>"><?= $type ?></label>
						</li><?
					}
				}
				?>
			</ul>
			<input type="hidden" name="id_order" value="<?= $_data['order']['id_order'] ?>" />
			<input type="submit" value="Submit" />
		</fieldset>
	</form>
	<?
	if (!empty($_data['order_detail_returns'])) {
	   	$width = 74;
		$height = 111;
		?>
		<h3>Returns</h3><br /><a target="_blank" href="<?= CR ?>/shop/return-shipping-label.php?id_order=<?= $_data['order']['id_order'] ?>&new-label=1">Generate New Return Shipping Label</a><br /><a target="_blank" href="<?= CR ?>/shop/return-shipping-label.php?id_order=<?= $_data['order']['id_order'] ?>">Reprint Shipping Label</a>
		<table class="cart">
			<thead>
				<tr>
					<th scope="col" class="image"></th>
					<th scope="col">Product Name</th>
					<th scope="col" class="quantity no-wrap">Return Qty</th>
                    <th scope="col">Type</th>
                    <th scope="col">Exchange For</th>
					<th scope="col">Status</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?
				foreach ($_data['order_detail_returns'] as $i => $order_detail_return) {
					$image_url = cdn_product_image($order_detail_return['product_file_id'], $width, $height);
					?>
					<tr>
						<td class="image"><img src="<?= $image_url ?>" width="<?= $width ?>" height="<?= $height ?>" alt="<?= $order_detail_return['product_name'] ?>" /></td>
						<td class="product">
							<a href="<?= HEADER_LOCATION_PREFIX ?>/shop/product.php?id_product=<?= $order_detail_return['id_product'] ?>"><?= $order_detail_return['product_name'] ?></a>
							<?
							if (!empty($order_detail_return['attributes'])) {
								$attributes = explode(chr(0x1D), $order_detail_return['attributes']);
								?>
								<dl class="options">
									<?
									foreach ($attributes as $attribute) {
										$parts = explode(': ', $attribute);
										?>
										<dt><?= $parts[0] ?></dt>
										<dd><?= $parts[1] ?></dd>
										<?
									}
									?>
								</dl>
								<?
							}
							?>
						</td>
						<td class="quantity"><?= $order_detail_return['return_product_quantity'] ?></td>
                        <td><?= $order_detail_return['return_type'] ?></td>
                        <td>
                        <?
						if ($order_detail_return['return_type'] == 'Exchange') {
							if (!empty($order_detail_return['exchange_attributes'])) {
								$attributes = explode(chr(0x1D), $order_detail_return['exchange_attributes']);
								?>
								<dl class="options">
									<?
									foreach ($attributes as $attribute) {
										$parts = explode(': ', $attribute);
										?>
										<dt><?= $parts[0] ?></dt>
										<dd><?= $parts[1] ?></dd>
										<?
									}
									?>
								</dl>
								<?
							}
						}
						else {
							?>
                            N/A
                            <?
						}
						?>
                        </td>
						<td><?= $order_detail_return['status'] ?></td>
						<td class="remove">
							<?
							if ($order_detail_return['status'] == 'Pending') {
								?>
								<a href="<?= CR ?>/action/shop/cancel_return?id_order_detail_return=<?= $order_detail_return['id_order_detail_return'] ?>" class="remove">x</a>
								<?
							}
							?>
						</td>
					</tr>
					<?
				}
				?>
			</tbody>
		</table>
		<?
	}
	?>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>