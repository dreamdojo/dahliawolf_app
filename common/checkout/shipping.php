<?
if (empty($_data['cart']['carrier_options'])) {
	?>
	<p>We're sorry, there are no shipping options available for your specified location.</p>
	<?
}
else {
	?>
    <form action="/action/shop/select_checkout_carrier.php" class="Form StaticForm shipping">
        <fieldset>
            <?
            foreach ($_data['cart']['carrier_options'] as $i => $carrier) {
				$cart_carrier_id_delivery = !empty($_data['cart']['cart']['carrier']) ? $_data['cart']['cart']['carrier']['id_delivery'] : NULL;
				$carrier_checked = !empty($cart_carrier_id_delivery) && $cart_carrier_id_delivery == $carrier['id_delivery'] ? ' checked="checked"' : '';
				?>
				<h3><?= $carrier['carrier_name'] ?></h3>
				<ul class="radios">
					<li>
						<input type="radio" name="id_delivery" value="<?= $carrier['id_delivery'] ?>"<?= $carrier_checked ?> />
						<label for=""><?= $carrier['delay'] ?> $<?= number_format($carrier['price'], 2) ?></label>
					</li>
				</ul>
				<?
			}
                
           	if (!empty($_GET['session_type'])) {
                ?>
                <input type="hidden" name="session_type" value="<?= $_GET['session_type']?>" />
                <?
            }
            ?>
        </fieldset>
        <?
        /*
        <fieldset>
            <h3>**FREE SHIPPING**</h3>
            <ul class="radios">
                <li>
                    <input type="radio" id="" name="" />
                    <label for="">USPS First Class Mail $0.00</label>
                </li>
            </ul>
        </fieldset>
        <fieldset>
            <h3>UPS (United Parcel Service)</h3>
            <ul class="radios">
                <li>
                    <input type="radio" id="" name="" />
                    <label for="">3 Day Select $14.38</label>
                </li>
                <li>
                    <input type="radio" id="" name="" />
                    <label for="">2nd Day Air $20.24</label>
                </li>
                <li>
                    <input type="radio" id="" name="" />
                    <label for="">Next Day Air $31.94</label>
                </li>
            </ul>
        </fieldset>
        */
        ?>
        <fieldset>
            <input type="submit" value="Next Step &gt" />
        </fieldset>
    </form>
    <?
}
?>