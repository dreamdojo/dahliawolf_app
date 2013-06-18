<?
$is_review = !empty($is_review) ? true : false;
?>
<div class="cart-container">
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
			foreach (range(1, 3) as $i) {
				?>
				<tr>
					<td class="image">
						<img src="http://www.dahliawolf.com/shop/media/catalog/product/i/m/image2013-03-05-01-21-08_front.png" width="75" />
					</td>
					<td class="product">
						<a href="">Floral Lace Shorts</a>
						<dl class="options">
							<dt>Size</dt>
							<dd>S</dd>
						</dl>
					</td>
					<td class="price monetary">
						$47.00
					</td>
					<td class="quantity">
						<?
						if (!$is_review) {
							?>
							<input type="text" name="quantity" value="1" />
							<?
						}
						else {
							?>
							1
							<?
						}
						?>
					</td>
					<td class="subtotal monetary">
						$47.00
					</td>
					<?
					if (!$is_review) {
						?>
						<td class="remove">
							<a class="remove">x</a>
						</td>
						<?
					}
					?>
				</tr>
				<?
			}
			?>
		</tbody>
	</table>
	<?
	if (!$is_review) {
		?>
		<p class="button update"><a>Update Shopping Cart</a></p>
		<?
	}
	?>
</div>
<div class="checkout-footer">
	<div class="discounts">
		
		<?
		if (!$is_review) {
			?>
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
							input type="hidden" name="redemption_uses" id="redemption_rule_uses" value="0">
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
						});*/
						
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
				<form class="discount-code">
					<fieldset>
						<label for="">Enter your coupon code if you have one.</label>
						<input type="text" name="code" id="discount-code" />
						<p class="button"><a onclick="$(this).closest('form').submit()">Apply Coupon</a></p>
					</fieldset>
				</form>
			</div>
			<?
		}
		else {
			?>
			<div class="review">
				<h3>Billing Address</h3>
				<p class="address">
					address
					<br />
					goes here
				</p>
				
				<h3>Shipping Address</h3>
				<p class="address">
					address
					<br />
					goes here
				</p>
				
				<h3>Shipping Method</h3>
				
				<h3>Payment Method</h3>
			</div>
			<?
		}
		?>
	</div>
	<div class="totals">
		<table class="totals">
			<tfoot>
				<tr>
					<th scope="row">Grand Total</th>
					<td>$53.04</td>
				</tr>
			</tfoot>
			<tbody>
				<tr class="points spend">
					<th scope="row">You Will Spend:</th>
					<td>No Points</td>
				</tr>
				<tr class="points spend">
					<th scope="row">You Will Earn:</th>
					<td>490 Points</td>
				</tr>
				<tr class="subtotal">
					<th scope="row">Subtotal</th>
					<td>$49.00</td>
				</tr>
				<?
				if ($is_review) {
					?>
					<tr class="shipping">
						<th scope="row">Shipping (Shipping Option Name)</th>
						<td>$0.00</td>
					</tr>
					<tr class="discounts">
						<th scope="row">Discount (Promo Name)</th>
						<td>- $0.00</td>
					</tr>
					<?
				}
				?>
				<tr class="tax">
					<th scope="row">Tax</th>
					<td>$4.04</td>
				</tr>
			</tbody>
		</table>
		
		<?
		if (!$is_review) {
			?>
			<p class="button checkout"><a href="?step=billing">Proceed To Checkout</a></p>
			<?
		}
		else {
			?>
			<p class="button checkout"><a>Place Order</a></p>
			<?
		}
		?>
	</div>
</div>