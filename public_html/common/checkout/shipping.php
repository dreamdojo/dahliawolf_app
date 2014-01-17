<?
if (empty($_data['cart']['carrier_options'])) {
	?>
    <h3>Shipping Options</h3>
    <form id="carrierForm" action="/public_html/action/shop/select_checkout_carrier.php" class="Form StaticForm shipping" method="post">
    <div id="alisBeeper"><img src="/images/checkoutLoad.gif"></div>
    <input type="hidden" name="ajax" value="true">
    <select name="id_delivery" id="shippingOptions">
        <option>No options Avaliable</option>
    </select>
    </form>
	<?
}
else {
	?>
	<h3>Shipping Options</h3>
    <form id="carrierForm" action="/public_html/action/shop/select_checkout_carrier.php" class="Form StaticForm shipping" method="post">
        <div id="alisBeeper"><img src="/images/checkoutLoad.gif"></div>
        <input type="hidden" name="ajax" value="true">
        <select name="id_delivery" id="shippingOptions">
            <?
            // Group shipping options by carrier
            $carrier_option_groups = array();
			foreach ($_data['cart']['carrier_options'] as $i => $carrier) {
				if (empty($carrier_option_groups[$carrier['carrier_name']])) {
					$carrier_option_groups[$carrier['carrier_name']] = array();
				}
				array_push($carrier_option_groups[$carrier['carrier_name']], $carrier);
			}
			ksort($carrier_option_groups);

			foreach ($carrier_option_groups as $carrier_name => $carrier_options) {
				?>
					<?
					foreach ($carrier_options as $i => $carrier) {
						$cart_carrier_id_delivery = !empty($_data['cart']['cart']['carrier']) ? $_data['cart']['cart']['carrier']['id_delivery'] : NULL;
						$carrier_checked = !empty($cart_carrier_id_delivery) && $cart_carrier_id_delivery == $carrier['id_delivery'] ? ' selected' : '';
						$id = 'id_delivery_' . $carrier['id_delivery'];
						?>
							<option id="<?= $id ?>" value="<?= $carrier['id_delivery'] ?>"<?= $carrier_checked ?> /><?= $carrier['carrier_name'] ?> - <?= $carrier['delay'] ?> $<?= number_format($carrier['price'], 2) ?></option>
						<?
						$last_carrier_name = $carrier['carrier_name'];
					}
					?>
				<?
			}

			/*
            $last_carrier_name = NULL;
            foreach ($_data['cart']['carrier_options'] as $i => $carrier) {
				$cart_carrier_id_delivery = !empty($_data['cart']['cart']['carrier']) ? $_data['cart']['cart']['carrier']['id_delivery'] : NULL;
				$carrier_checked = !empty($cart_carrier_id_delivery) && $cart_carrier_id_delivery == $carrier['id_delivery'] ? ' checked="checked"' : '';
				$id = 'id_delivery_' . $carrier['id_delivery'];
				?>
				<ul class="radios">
					<li>
						<input type="radio" id="<?= $id ?>" name="id_delivery" value="<?= $carrier['id_delivery'] ?>"<?= $carrier_checked ?> />
						<label for="<?= $id ?>"><strong><?= $carrier['carrier_name'] ?></strong> - <?= $carrier['delay'] ?> $<?= number_format($carrier['price'], 2) ?></label>
					</li>
				</ul>
				<?
				$last_carrier_name = $carrier['carrier_name'];
			}
			*/

           	if (!empty($_GET['session_type'])) {
                ?>
                <input type="hidden" name="session_type" value="<?= $_GET['session_type']?>" />
                <?
            }
            ?>
        </select>
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
            <input type="submit" value="Next Step &gt" style="visibility: hidden;" />
        </fieldset>
    </form>
    <?
}
?>