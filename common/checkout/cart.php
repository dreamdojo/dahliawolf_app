<?
$is_review = !empty($is_review) ? true : false;
//print_r($_data['cart']);
?>
<div class="cart-container">
	<?
	if (!$is_review) {
		?>
		<form action="/action/shop/update_cart.php" method="post">
		<?
	}
	?>
	<table class="cart">
		<thead>
			<tr>
				<th scope="col" class="image"></th>
				<th scope="col" class="product">Product Name</th>
				<th scope="col" class="price monetary">Unit Price</th>
				<th scope="col" class="quantity">Qty</th>
				<th scope="col" class="subtotal monetary">Subtotal</th>
				<?
				if (!$is_review) {
					?>
					<th scope="col" class="remove"></th>
					<?
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?
			if (!empty($_data['cart']) && !empty($_data['cart']['products'])) {
				$width = 74;
				$height = 111;

				$sales_tax = 0;
				$affiliate_discount = 0;
				$coupon_discount = 0;
				$total_weight = 0;
				$sub_total = 0;
				$grand_total = 0;
				foreach ($_data['cart']['products'] as $i => $cart_value) {
  					$id_product 			= $cart_value['id_product'];
					$id_product_attribute 	= $cart_value['id_product_attribute'];
					$product_name			= $cart_value['product_info']['product_name'];
					$product_image			= '';
					$quantity 				= $cart_value['quantity'];
					$price 					= ($cart_value['product_info']['on_sale'] == '1') ? $cart_value['product_info']['sale_price'] : $cart_value['product_info']['price'];
					$total_price 			= $price * $quantity;
					$product_tax			= !empty($cart_value['tax_info']) ? $cart_value['tax_info']['total_amount'] : 0;
					$sales_tax				= $sales_tax + $product_tax;
					$affiliate_discount		= $affiliate_discount;
					$coupon_discount		= $coupon_discount;

					$total_weight			= $total_weight + $cart_value['product_info']['weight'];
  					$sub_total				= $sub_total + $total_price;
  					$grand_total			= $grand_total + $total_price + $product_tax;

					$image_url = cdn_product_image($cart_value['product_info']['product_file_id'], $width, $height);
  					?>
  					<tr>
					<td class="image">
						<img src="<?= $image_url ?>" width="<?= $width ?>" height="<?= $height ?>" alt="<?= $product_name ?>" />
					</td>
					<td class="product">
						<a href="<?= CR ?>/shop/product.php?id_product=<?= $id_product ?>"><?= $product_name ?></a>
						<?
          				if (!empty($cart_value['attributes'])) {
          					$attributes = explode(chr(0x1D), $cart_value['attributes']);
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
					<td class="price monetary">
						$<?= number_format($price, 2, '.', ',') ?>
					</td>
					<td class="quantity">
						<?
						if (!$is_review) {
							?>
							<input name="id_products[]" type="hidden" value="<?= $id_product ?>">
      						<input name="id_product_attributes[]" type="hidden" value="<?= $id_product_attribute ?>">
							<input type="text" name="quantities[]" id="quantities-<?= $i ?>" value="<?= $quantity ?>" />
							<?
						}
						else {
							?>
							<?= $quantity ?>
							<?
						}
						?>
					</td>
					<td class="subtotal monetary">
						$<?= number_format($total_price, 2, '.', ',') ?>
					</td>
					<?
					if (!$is_review) {
						?>
						<td class="remove">
							<a class="remove" href="/action/shop/remove_item_from_cart.php?id_product=<?= $id_product ?>&id_product_attribute=<?= $id_product_attribute ?>">x</a>
						</td>
						<?
					}
					?>
				</tr>
  					<?
				}
			}

			?>
		</tbody>
	</table>
	<?
	if (!$is_review) {
		?>
		<p class="button update"><a onclick="$(this).closest('form').submit()">Update Shopping Cart</a></p>
	</form>
		<?
	}
	?>
</div>
<div class="checkout-footer">
	<div class="discounts">

		<?
		/*if (!$is_review) {
			if (!empty($_data['cart']['points']['levels'])) {
				?>
				<form action="<?= CR ?>/action/shop/set_user_cart_rule.php" method="post">
					<h3>Spend Your Points</h3>
					<input type="hidden" name="id_cart" value="<?= $_data['cart']['cart']['id_cart'] ?>" />
					<ul class="levels">
						<?
						foreach ($_data['cart']['points']['levels'] as $level) {
							$id = 'discount-' . $level['commerce_id_cart_rule'];
							$checked = $level['commerce_id_cart_rule'] == $_data['cart']['cart']['user_id_cart_rule'];
							?>
							<li>
								<input type="checkbox" id="<?= $id ?>" name="id_cart_rule" value="<?= $level['commerce_id_cart_rule'] ?>"<?= $checked ? ' checked="checked"' : '' ?> />
								<label for="<?= $id ?>"><?= number_format($level['points'], 0) ?>pts for <?= number_format($level['reduction_percent'], 0) ?>% off entire order</label>
							</li>
							<?
						}
						?>
					</ul>
				</form>
				<script type="text/javascript">
					$('ul.levels').on('click', 'input[type="checkbox"]', function(event) {
						$(event.delegateTarget).find('input[type="checkbox"]').not(this).attr('checked', false);

						$(this).closest('form').submit();
					});
				</script>
				<?
			}
		}*/

		if (!$is_review) {
			?>
			<? /*
            <div class="discount-codes box rewards-box-spend-minicart discount">
				<div class="rewards-box-spend-header">
					<h3>Spend your points</h3>
				</div>
				<div class="box-content">
					<!-- Cart Slider -->
					<h5 class="minicart-slider-header">Choose how many points to spend: </h5>
						<div class="cartSlider">

							<script type="text/javascript">

							// Other PHP content ///////////////
							var currency_map  = {"1":""};

							function feignPriceChange() {

							}

							</script>

						<div class="slider" onmouseup="sliderNotSliding()">
							<table cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td style="vertical-align:middle" class="btn-slider-reduce-points-container">
											<img class="btn-slider-reduce-points" alt="Spend one point less" src="http://www.sugarlips.com/skin/frontend/default/technodrome/images/rewards/slider/decr_points.gif" id="slider_reduce_points" onclick="rSlider.decr()" style="position:relative; top:5px;">
										</td>
										<td>
											<div class="sliderRail sliderRail-sliding" id="sliderRail">
												<a style="left: 0px; top: 0px;" class="sliderHandle ui-slider-handle ui-state-default sliderHandle-sliding selected" id="sliderHandle" onmousedown="sliderSliding()" onmouseup="sliderNotSliding()"></a>
											</div>
										</td>
										<td style="vertical-align: middle" class="btn-slider-reduce-points-container">
											<img class="btn-slider-increase-points" alt="Spend one point more" src="http://www.sugarlips.com/skin/frontend/default/technodrome/images/rewards/slider/incr_points.gif" id="slider_reduce_points" onclick="rSlider.incr()" style="position:relative; top:5px;">
										</td>
										<td valign="top" class="cartSlider_cell">
										</td>
									</tr>
								</tbody>
							</table>
							<div id="sliderCaption" class="cartSlider_caption">You Will Spend: 0 Points</div>
							<input type="hidden" name="redemption_uses" id="redemption_rule_uses" value="0">
						</div>

						<script type="text/javascript">
						/*document.observe("dom:loaded", function() {
							var min_spendable = 0;
							var max_spendable = 5590;
							var step = 10;
							var current_value = 0;

							rSlider = new RedemptionSlider('sliderHandle', 'sliderRail', 'sliderCaption', 'redemption_rule_uses');
							rSlider.regenerateSlider(min_spendable, max_spendable, step, current_value);//min, max, step, initial_value
							rSlider.setExternalValue(current_value);
						});*//*

						// Functions for changing the cursor on the slider
						function sliderSliding() {
							$('sliderRail').addClassName('sliderRail-sliding');
							$('sliderHandle').addClassName('sliderHandle-sliding');
						}

						function sliderNotSliding() {
							$('sliderRail').removeClassName('sliderRail-sliding');
							$('sliderHandle').removeClassName('sliderHandle-sliding');
						}
						</script>
					</div>
					<input type="checkbox" name="use_all_points" id="use_all_points" onclick="toggleUseAllPoints(this.checked)">&nbsp;
					<label for="use_all_points">Maximize my discount with points</label>

					<!-- All other rules -->
		   			<div class="more-ways-to-spend  more-ways-to-spend-also">
						<h4 class="more-ways-to-spend-header">More ways to spend points: </h4>
						<!-- Applied Rule Listing -->

						<!-- Applicable Rule Listing -->
						<div class="cart_redemption_item">
							<input type="checkbox" name="applicable_cart_rule[]" id="applicable_cart_rule[]" value="57" onclick="toggleCartRule(this)">&nbsp;
							<label for="applicable_cart_rule[]">50,000pts for 50% off entire order</label>
						</div>
						<div class="cart_redemption_item">
							<input type="checkbox" name="applicable_cart_rule[]" id="applicable_cart_rule[]" value="56" onclick="toggleCartRule(this)">&nbsp;
							<label for="applicable_cart_rule[]">10,000pts for 30% off entire order</label>
						</div>
					</div>
				</div>
			</div>

			<div class="codes">
				<h4>Discount Codes</h4>
				<form class="discount-code" action="/action/shop/add_discount.php" method="post">
					<fieldset>
						<label for="">Enter your coupon code if you have one.</label>
						<input type="text" name="code" id="discount-code" />
						<p class="button"><a onclick="$(this).closest('form').submit()">Apply Coupon</a></p>
					</fieldset>
				</form>
			</div>
			*/?>
            <?
		}
		else {
			?>
			<div class="review">
				<?
                if (!empty($_data['billing_address'])) {
                    ?>
                    <h3>Billing Address</h3>
                    <p class="address">
                        <?= $_data['billing_address']['first_name'] ?> <?= $_data['billing_address']['last_name'] ?>
                        <br />
                        <?= $_data['billing_address']['street'] ?> <?= $_data['billing_address']['street_2'] ?>
                        <br />
                        <?= $_data['billing_address']['city'] ?>, <?= $_data['billing_address']['state'] ?> <?= $_data['billing_address']['zip'] ?>
                        <br />
                        <?= $_data['billing_address']['country'] ?>
                    </p>
                    <?
                }

                if (!empty($_data['shipping_address'])) {
                    ?>
                    <h3>Shipping Address</h3>
                    <p class="address">
                        <?= $_data['shipping_address']['first_name'] ?> <?= $_data['shipping_address']['last_name'] ?>
                        <br />
                        <?= $_data['shipping_address']['street'] ?> <?= $_data['shipping_address']['street_2'] ?>
                        <br />
                        <?= $_data['shipping_address']['city'] ?>, <?= $_data['shipping_address']['state'] ?> <?= $_data['shipping_address']['zip'] ?>
                        <br />
                        <?= $_data['shipping_address']['country'] ?>
                    </p>
                    <?
                }

				if (!empty($_data['cart']['cart']['carrier'])) {
                    ?>
                    <h3>Shipping Method</h3>
                    <p><?= $_data['cart']['cart']['carrier']['carrier_name'] ?> <?= $_data['cart']['cart']['carrier']['delay'] ?></p>
                    <?
                }
                ?>
				<?
                /*<h3>Payment Method</h3>*/
				?>
			</div>
			<?
		}
		?>
	</div>


	<div class="totals">

     <?
	if ($is_review) {
		$cc_payment = false;
		$paypal_payment = false;
		?>
        <form action="/action/shop/place_order.php" id="place_order_form" class="Form StaticForm payment" method="post">
        <input type="hidden" name="amount" value="<?= $_data['cart']['cart']['totals']['grand_total'] ?>" />
        <fieldset>
            <h3>Payment Method</h3>
            <?
            if (!empty($_data['payment_methods'])) {
                ?>
                <ul class="radios">
                <?
                foreach ($_data['payment_methods'] as $i => $payment_method) {
                    $checked = (!empty($_SESSION['checkout_payment_method_id']) && $_SESSION['checkout_payment_method_id'] == $payment_method['payment_method_id'])? ' checked="checked"' : '';
					$cc_fields = ($payment_method['name'] == 'Credit Card') ? '1' : '0';
					$set_paypal = ($payment_method['name'] == 'PayPal') ? '1' : '0';
					if (!empty($checked) && $payment_method['name'] == 'Credit Card') {
						$cc_payment = true;
					}
					else if (!empty($checked) && $payment_method['name'] == 'PayPal') {
						$paypal_payment = true;
					}
                    ?>
                    <li>
                        <input type="radio" id="payment_method_id-<?= $i ?>" name="payment_method_id" value="<?= $payment_method['payment_method_id'] ?>"<?= $checked ?> data-show_cc_fields="<?= $cc_fields ?>" data-show_set_paypal="<?= $set_paypal ?>" />
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
        <?
		if (empty($_data['cart']['cart']['paypal_token'])) {
			?>
            <div style="<?= $paypal_payment ? '' : 'display:none;' ?>" id="set_paypal">
                <p>In order to use PayPal, we must direct you to their website to log in. Once logged in, you will be returned to confirm your order.</p>
                <p><a href="/common/checkout/paypal-express-checkout/set">Continue</a></p>
            </div>
            <?
		}
		?>
        <fieldset id="credit_card_fields" style="<?= empty($_SESSION['checkout_payment_method_id']) || $cc_payment ? '' : 'display:none;' ?>">
            <ul class="fields">
                <li>
                    <label for="cc_name">Name on Card <em>*</em></label>
                    <input type="text" id="cc_name" name="cc_name" />
                </li>
                <li>
                    <label for="cc_number">Card Number <em>*</em></label>
                    <input type="text" id="cc_number" name="cc_number" />
                </li>
                <li>
                    <label for="cc_exp_month">Expiration Month<em>*</em></label>
                    <select id="cc_exp_month" name="cc_exp_month">
                    	<option value="">Month&hellip;</option>
						<?
                        foreach ($_data['months'] as $month) {
                            ?>
                            <option value="<?= $month ?>"><?= $month ?></option>
                            <?
                        }
                        ?>
                    </select>
                </li>
                <li>
                    <label for="cc_exp_year">Expiration Year<em>*</em></label>
                   	<select id="cc_exp_year" name="cc_exp_year">
                    	<option value="">Year&hellip;</option>
						<?
                        foreach ($_data['years'] as $year) {
                            ?>
                            <option value="<?= $year ?>"><?= $year ?></option>
                            <?
                        }
                        ?>
                    </select>
                </li>
                <li>
                    <label for="cc_cvv">CVV <em>*</em></label>
                    <input type="text" id="cc_cvv" name="cc_cvv" />
                </li>
             </ul>
        </fieldset>
        <?
	}
	?>

		<table class="totals" style="<?= $paypal_payment && empty($_data['cart']['cart']['paypal_token']) ? 'display: none;' : '' ?>">
			<tfoot>
				<tr>
					<th scope="row">Grand Total</th>
					<td>$<?= !empty($_data['cart']) ? number_format($_data['cart']['cart']['totals']['grand_total'], 2, '.', ',') : '0.00' ?></td>
				</tr>
			</tfoot>
			<tbody>
				<?
				/*
				<tr class="points spend">
					<th scope="row">You Will Spend:</th>
					<td><?= !empty($_data['cart']['cart']['points']) ? number_format($_data['cart']['cart']['points'], 0) : 'No' ?> Points</td>
				</tr>
				*/
				?>
				<tr class="points spend">
					<th scope="row">You Will Earn:</th>
					<td><?= number_format($_data['cart']['points']['will_earn'], 0) ?> Points</td>
					<?
					//$_data['buy_points_amount'] *
					?>
				</tr>
				<tr class="subtotal">
					<th scope="row">Subtotal</th>
					<td>$<?= !empty($_data['cart']) ? number_format($_data['cart']['cart']['totals']['products'], 2, '.', ',') : '0.00' ?></td>
				</tr>
				<?

				if (!empty($_data['cart']['discounts'])) {
					foreach($_data['cart']['discounts'] as $discount) {
						?>
						<tr class="discounts">
							<th scope="row">

	                            <?
								if (!$is_review) {
									?>
	                            	<a class="remove" href="/action/shop/remove_discount.php?id_cart_rule=<?= $discount['id_cart_rule'] ?>" title="Remove Discount">x</a>
	                                <?
								}
								?>
								Discount (<?= $discount['name'] ?> - <?= ($discount['is_amount_discount'] == '1') ? '$' . number_format($discount['reduction_amount'], 2, '.', ',') : number_format($discount['reduction_percent'], 0, '.', ',') . '%' ?> off)

                            </th>
							<td>- $<?= number_format($discount['discount_amount'], 2, '.', ',') ?></td>
						</tr>
						<?
					}
				}

				//if ($is_review) {
					if (!empty($_data['cart']['cart']['carrier'])) {
  						?>
      					<tr class="shipping">
        					<th scope="row">Shipping (<?= $_data['cart']['cart']['carrier']['carrier_name'] ?> <?= $_data['cart']['cart']['carrier']['delay'] ?>)</th>
        					<td>$<?= number_format($_data['cart']['cart']['totals']['shipping'], 2, '.', ',') ?></td>
        				</tr>
        				<?
					}

				//}

				?>
				<tr class="tax">
					<th scope="row">Tax</th>
					<td>$<?= !empty($_data['cart']) ? number_format(($_data['cart']['cart']['totals']['product_tax'] + $_data['cart']['cart']['totals']['discount_tax'] + $_data['cart']['cart']['totals']['shipping_tax'] + $_data['cart']['cart']['totals']['wrapping_tax']), 2, '.', ',') : '0.00' ?></td>
				</tr>
				<?
				if (!empty($_data['cart']['cart']['carrier'])) {
					?>
	 				<tr class="tax">
						<th scope="row">Shipping Tax</th>
						<td>$<?= number_format($_data['cart']['cart']['totals']['shipping_tax'], 2, '.', ',') ?></td>
					</tr>
	 				<?
				}
				?>
			</tbody>
		</table>

		<?
		if (!$is_review) {
			?>
			<p class="button checkout"><a href="<?= empty($_SESSION['user']) ? HEADER_LOCATION_PREFIX . '/login.php' : '?step=billing'?>">Proceed To Checkout</a></p>
			<?
		}
		else {
			?>
			<p class="button checkout" style="<?= $paypal_payment && empty($_data['cart']['cart']['paypal_token']) ? 'display: none;' : '' ?>"><a onclick="$('#place_order_form').submit()">Place Order</a></p>
            </form>
			<?
		}
		?>
	</div>
</div>