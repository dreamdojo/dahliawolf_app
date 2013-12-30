<?php
$calls = array(
    'get_user_billing_addresses' => array(
        'user_id' => $_SESSION['user']['user_id']
    )
, 'get_user_shipping_addresses' => array(
        'user_id' => $_SESSION['user']['user_id']
    )
, 'get_countries' => NULL
, 'get_states' => NULL
);
$data = api_request('address', $calls, true);

if (!empty($data['errors']) || !empty($data['data']['get_user_billing_addresses']['errors'])) {
    $_SESSION['errors'] = api_errors_to_array($data, 'get_user_billing_addresses');
}
else {
    $_data['billing_addresses'] = $data['data']['get_user_billing_addresses']['data'];
}

if (!empty($data['errors']) || !empty($data['data']['get_user_shipping_addresses']['errors'])) {
    $_SESSION['errors'] = api_errors_to_array($data, 'get_user_shipping_addresses');
}
else {
    $_data['shipping_addresses'] = $data['data']['get_user_shipping_addresses']['data'];
}

$id_lang =  defined('ID_LANG') ? ID_LANG : 1;
$id_country =  defined('ID_COUNTRY') ? ID_COUNTRY : 3;

// Countries & default states
$calls = array(
    'get_countries' => array(
        'id_lang' => $id_lang
    )
, 'get_states' => array(
        'id_country' => $id_country
    )
);
$data = commerce_api_request('address', $calls, true);


//echo sprintf("<pre>%s</pre>", var_export($data, true));

$_data['states'] = $data['data']['get_states']['data'];
$_data['countries'] = $data['data']['get_countries']['data'];


foreach($_data['countries'] as $country)
{
    if( $country['iso_code'] == 'US') array_unshift($_data['countries'], $country);
}

?>


<form id="shippingForm" action="/public_html/action/shop/billing.php" class="Form StaticForm billing" method="post">
    <input type="hidden" name="ajax" value="true">
	<h3>Billing Address</h3>
	<?
	$saved_billing_selected = false;
    $selected_address = false;
	if (!empty($_data['billing_addresses'])) {
		?>
		<fieldset>
			<ul class="fields">
				<li>
					<select name="billing_address_id" id="billing_address_id">
						<option value="">My saved Addresses</option>
						<?
						foreach ($_data['billing_addresses'] as $billing_address) {
							if (!$saved_billing_selected) {
								if (!empty($_SESSION['checkout_billing_address_id']) && $_SESSION['checkout_billing_address_id'] == $billing_address['address_id']) {
									$selected_address = $billing_address;
                                    $saved_billing_selected = true;
								}
							}
							?>
							<option data-first_name="<?= $billing_address['first_name'] ?>" data-last_name="<?= $billing_address['last_name'] ?>" data-street="<?= $billing_address['street'] ?>" data-address_2="<?= $billing_address['street_2'] ?>" data-city="<?= $billing_address['city'] ?>" data-state="<?= $billing_address['state'] ?>" data-country="<?= $billing_address['country'] ?>" data-zip="<?= $billing_address['zip'] ?>" data-phone="<?= $billing_address['phone'] ?>" value="<?= $billing_address['address_id'] ?>"<?= !empty($_SESSION['checkout_billing_address_id']) && $_SESSION['checkout_billing_address_id'] == $billing_address['address_id'] ? ' selected="selected"' : '' ?>><?= $billing_address['street'] . ' ' . $billing_address['street_2'] ?></option>
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
	<fieldset id="billing-address-fields">
		<ul class="fields">
			<li>
				<input class="isRequired" type="text" id="billing-first-name" name="billing_first_name" placeholder="First Name" <?= $selected_address ? 'value="'.$selected_address['first_name'].'"' : '' ?> />
			</li>
			<li>
				<input class="isRequired" type="text" id="billing-last-name" name="billing_last_name" placeholder="Last Name" <?= $selected_address ? 'value="'.$selected_address['last_name'].'"' : '' ?> />
			</li>
			<li>
				<select class="isRequired" id="billing-country" name="billing_country" class="country">
					<option value="<?= $selected_address ? $selected_address['country'] : '' ?>"><?= $selected_address ? $selected_address['country'] : 'Country' ?></option>
					<?
					foreach ($_data['countries'] as $country) {
						?>
							<option value="<?= $country['iso_code'] ?>"><?= $country['name'] ?></option>
						<?
					}
					?>
				</select>
			</li>
			<li>
				<input class="isRequired" type="text" id="billing-address" name="billing_address" placeholder="Address" <?= $selected_address ? 'value="'.$selected_address['street'].'"' : '' ?> />
			</li>
			<li>
				<input type="text" id="billing-address" name="billing_address_2" placeholder="Address 2" />
			</li>
			<li>
				<input class="isRequired" type="text" id="billing-city" name="billing_city" placeholder="City" <?= $selected_address ? 'value="'.$selected_address['city'].'"' : '' ?> />
			</li>
			<li>
				<select class="isRequired" id="billing-state" name="billing_state" class="state">
					<option value="<?= $selected_address ? $selected_address['state'] : '' ?>"><?= $selected_address ? $selected_address['state'] : 'State/Province' ?></option>
					<?
					foreach ($_data['states'] as $state) {
						?>
						<option value="<?= $state['iso_code'] ?>"><?= $state['name'] ?></option>
						<?
					}
					?>
				</select>
				<input type="text" name="billing_province" class="province" style="display: none;" />
			</li>

			<li>
				<input class="isRequired" type="text" id="billing-zip" name="billing_zip" placeholder="Zip Code" <?= $selected_address ? 'value="'.$selected_address['zip'].'"' : '' ?>/>
			</li>
            
            <li>
				<input class="isRequired" type="text" id="billing-phone" name="billing_phone" placeholder="Phone Number" <?= $selected_address ? 'value="'.$selected_address['phone'].'"' : '' ?>/>
			</li>
		</ul>
	</fieldset>
	<br />

    <h3>Shipping Address</h3>

    <div id="pop-ship" class="selectoBismol"></div>
    <input style="visibility: hidden;" type="checkbox" name="populate-shipping-from-billing" id="populate-shipping-from-billing" checked="checked" />
    <label style="float: left;">Same as billing address</label>
    <div style="clear: left"></div>

    <div id="shippingFields">
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
				<input class="isAlsoRequired" type="text" id="shipping-first-name" name="shipping_first_name" placeholder="First Name" />
			</li>
			<li>
				<input  class="isAlsoRequired" type="text" id="shipping-last-name" name="shipping_last_name" placeholder="Last Name" />
			</li>

			<li>
				<select  class="isAlsoRequired" id="shipping-country" name="shipping_country" class="country">
					<option value="">Country&hellip;</option>
					<?
					foreach ($_data['countries'] as $country) {
						?>
						<option value="<?= $country['iso_code'] ?>"><?= $country['name'] ?></option>
						<?
					}
					?>
				</select>
			</li>

			<li>
				<input  class="isAlsoRequired" type="text" id="shipping-address" name="shipping_address" placeholder="Address" />
			</li>
			<li>
				<input type="text" id="shipping-address" name="shipping_address_2" placeholder="Address 2" />
			</li>
			<li>
				<input  class="isAlsoRequired" type="text" id="shipping-city" name="shipping_city" placeholder="City" />
			</li>
			<li>
				<select  class="isAlsoRequired" id="shipping-state" name="shipping_state" class="state">
					<option value="">State/Province&hellip;</option>
					<?
					foreach ($_data['states'] as $state) {
						?>
						<option value="<?= $state['iso_code'] ?>"><?= $state['name'] ?></option>
						<?
					}
					?>
				</select>
				<input type="text" name="shipping_province" class="province" style="display: none;"  placeholder="Province"/>
			</li>
			<li>
				<input  class="isAlsoRequired" type="text" id="shipping-zip" name="shipping_zip" placeholder="Zip code" />
			</li>
            
            <li>
				<input  class="isAlsoRequired" type="text" id="shipping-phone" name="shipping_phone" placeholder="Phone Number" />
			</li>
		</ul>
	</fieldset>
    </div>

	<fieldset>
		<input type="submit" value="Next Step &gt" style="float: right; visibility: hidden;"/>
	</fieldset>
</form>