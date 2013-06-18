<form action="/action/shop/select_payment_method.php" class="Form StaticForm payment" method="post">
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
				<label for="billing-first-name">First Name <em>*</em></label>
				<input type="text" id="billing-first-name" name="billing_first_name" />
			</li>
			<li>
				<label for="billing-last-name">Last Name <em>*</em></label>
				<input type="text" id="billing-last-name" name="billing_last_name" />
			</li>
			<li>
				<label for="billing-address">Address <em>*</em></label>
				<input type="text" id="billing-address" name="billing_address" />
			</li>
			<li>
				<label for="billing-address">Address 2</label>
				<input type="text" id="billing-address" name="billing_address_2" />
			</li>
			<li>
				<label for="billing-city">City <em>*</em></label>
				<input type="text" id="billing-city" name="billing_city" />
			</li>
			<li>
				<label for="billing-state">State<em>*</em></label>
				<select id="billing-state" name="billing_state">
					<?
					foreach ($_data['states'] as $state) {
						?>
						<option value="<?= $state['code'] ?>"><?= $state['name'] ?></option>
						<?
					}
					?>
				</select>
			</li>
			<li>
				<label for="billing-zip">Zip/Postal Code <em>*</em></label>
				<input type="text" id="billing-zip" name="billing_zip" />
			</li>
			<?
			/*
			<li>
				<label for="billing-country">Country <em>*</em></label>
				<select id="billing-country" name="billing_country">
					
				</select>
			</li>
			
			<li>
				<label for="billing-phone">Telephone <em>*</em></label>
				<input type="text" id="billing-phone" name="billing_phone" />
			</li>*/
			?>
		</ul>
	</fieldset>
    
	<fieldset>
		<input type="submit" value="Next Step &gt" />
	</fieldset>
</form>