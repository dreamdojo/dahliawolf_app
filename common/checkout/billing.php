<form action="/action/shop/billing.php" class="Form StaticForm billing" method="post">
	<h3>Billing Address</h3>
	<?
	$saved_billing_selected = false;
	if (!empty($_data['billing_addresses'])) {
		?>
		<fieldset>
			<ul class="fields">
				<li>
		    		<label for="billing-first-name">Saved Address:</label>
		    		<select name="billing_address_id" id="billing_address_id">
		    			<option value="">Billing Address &hellip;</option>
		    			<?
		    			foreach ($_data['billing_addresses'] as $billing_address) {
							if (!$saved_billing_selected) {
								if (!empty($_SESSION['checkout_billing_address_id']) && $_SESSION['checkout_billing_address_id'] == $billing_address['address_id']) {
									$saved_billing_selected = true;
								}
							}
							?>
							<option data-first_name="<?= $billing_address['first_name'] ?>" data-last_name="<?= $billing_address['last_name'] ?>" data-street="<?= $billing_address['street'] ?>" data-address_2="<?= $billing_address['street_2'] ?>" data-city="<?= $billing_address['city'] ?>" data-state="<?= $billing_address['state'] ?>" data-country="<?= $billing_address['country'] ?>" data-zip="<?= $billing_address['zip'] ?>" value="<?= $billing_address['address_id'] ?>"<?= !empty($_SESSION['checkout_billing_address_id']) && $_SESSION['checkout_billing_address_id'] == $billing_address['address_id'] ? ' selected="selected"' : '' ?>><?= $billing_address['street'] . ' ' . $billing_address['street_2'] ?></option>
							<?
						}
		    			?>
		    		</select>
		    	</li>
			</ul>
		</fieldset>
		<?
	}
	?>
	<fieldset id="billing-address-fields"<?= $saved_billing_selected ? ' style="display:none"' : '' ?>>
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
                	<option value="">State&hellip;</option>
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
	<br />
    <h3>Shipping Address</h3>
	<?
	$saved_shipping_selected = false;
	
	if (!empty($_data['shipping_addresses'])) {
		?>
		<fieldset>
			<ul class="fields">
				<li>
		    		<label for="shipping-first-name">Saved Address:</label>
		    		<select name="shipping_address_id" id="shipping_address_id">
		    			<option value="">Shipping Address &hellip;</option>
		    			<?
		    			foreach ($_data['shipping_addresses'] as $shipping_address) {
							if (!$saved_shipping_selected) {
								if(!empty($_SESSION['checkout_shipping_address_id']) && $_SESSION['checkout_shipping_address_id'] == $shipping_address['address_id']) {
									$saved_shipping_selected = true;
								}
							}
							?>
							<option value="<?= $shipping_address['address_id'] ?>"<?= !empty($_SESSION['checkout_shipping_address_id']) && $_SESSION['checkout_shipping_address_id'] == $shipping_address['address_id'] ? ' selected="selected"' : '' ?>><?= $shipping_address['street'] . ' ' . $shipping_address['street_2'] ?></option>
							<?
						}
		    			?>
		    		</select>
		    	</li>
			</ul>
		</fieldset>
		<?
	}
	?>
	
	<fieldset id="shipping-address-fields"<?= $saved_shipping_selected ? ' style="display:none"' : '' ?>>
    	
		<ul class="fields">
        	<li>
            	<input type="checkbox" name="populate-shipping-from-billing" id="populate-shipping-from-billing" />
                <label for="populate-shipping-from-billing">Same as Billing</label>
			</li>
			<li>
				<label for="shipping-first-name">First Name <em>*</em></label>
				<input type="text" id="shipping-first-name" name="shipping_first_name" />
			</li>
			<li>
				<label for="shipping-last-name">Last Name <em>*</em></label>
				<input type="text" id="shipping-last-name" name="shipping_last_name" />
			</li>
			<li>
				<label for="shipping-address">Address <em>*</em></label>
				<input type="text" id="shipping-address" name="shipping_address" />
			</li>
			<li>
				<label for="shipping-address">Address 2</label>
				<input type="text" id="shipping-address" name="shipping_address_2" />
			</li>
			<li>
				<label for="shipping-city">City <em>*</em></label>
				<input type="text" id="shipping-city" name="shipping_city" />
			</li>
			<li>
				<label for="shipping-state">State<em>*</em></label>
				<select id="shipping-state" name="shipping_state">
                	<option value="">State&hellip;</option>
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
				<label for="shipping-zip">Zip/Postal Code <em>*</em></label>
				<input type="text" id="shipping-zip" name="shipping_zip" />
			</li>
			<?
			/*
			<li>
				<label for="shipping-country">Country <em>*</em></label>
				<select id="shipping-country" name="shipping_country">
					
				</select>
			</li>
			
			<li>
				<label for="shipping-phone">Telephone <em>*</em></label>
				<input type="text" id="shipping-phone" name="shipping_phone" />
			</li>*/
			?>
		</ul>
	</fieldset>
	
	<fieldset>
		<input type="submit" value="Next Step &gt" />
	</fieldset>
</form>