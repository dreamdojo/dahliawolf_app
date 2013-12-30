

<form action="/public_html/action/shop/select_payment_method.php" class="Form StaticForm payment" method="post">
	<fieldset>
		<h3>Payment Method</h3>
        <?
		if (!empty($_data['payment_methods'])) {
			?>
			<ul class="radios">
            <?
			foreach ($_data['payment_methods'] as $i => $payment_method) {
				$checked = (!empty($_SESSION['checkout_payment_method_id']) && $_SESSION['checkout_payment_method_id'] == $payment_method['payment_method_id'])? ' checked="checked"' : '';
				?>
                <li>
                    <input type="radio" id="payment_method_id-<?= $i ?>" name="payment_method_id" value="<?= $payment_method['payment_method_id'] ?>"<?= $checked ?> />
                    <label for="payment_method_id-<?= $i ?>"><?= $payment_method['name'] ?></label>
                </li>
                <?
			}
			?>
			</ul>
            <?
		}
		?>
	</fieldset>
    
    <fieldset id="credit_card_fields" style="<?= (empty($_SESSION['checkout_payment_method_id']) || $_SESSION['checkout_payment_method_id'] == '1') ? '' : 'display:none"' ?>">
		<ul class="fields">
			<li>
				<input type="text" id="billing-first-name" name="billing_first_name" placeholder="First Name"/>
			</li>
			<li>
				<input type="text" id="billing-last-name" name="billing_last_name" placeholder="Last Name" />
			</li>
			<li>
				<input type="text" id="billing-address" name="billing_address" placeholder="Billing Address" />
			</li>
			<li>
				<input type="text" id="billing-address" name="billing_address_2" placeholder="Apt #" />
			</li>
			<li>
				<input type="text" id="billing-city" name="billing_city" placeholder="City" />
			</li>
			<li>
				<input id="billing-state" name="billing_state" placeholder="State">
			</li>
			<li>
				<input type="text" id="billing-zip" name="billing_zip" placeholder="Zip Code"/>
			</li>
		</ul>
	</fieldset>
    
	<fieldset>
		<input type="submit" value="Next Step" />
	</fieldset>
</form>