<?
function list_users($users) {
	if (!empty($users)) {
		foreach ($users as $user) {
			//$profile_url = '/profile.php?username=' . $user['username'];
			$profile_url = '/' . $user['username'];
			$is_followed = !empty($user['is_followed']);
			?>
	        <div class="person">
	    		<a class="PersonImage ImgLink" href="<?= $profile_url ?>"><img src="<?= $user['avatar'] ?>&amp;width=100" alt="<?= $user['username'] ?>" /></a>
	    		<p class="PersonIdentity"><a href="<?= $profile_url ?>"><?= $user['username'] ?></a></p>
	    		<?
	    		if (IS_LOGGED_IN && $user['user_id'] != $_SESSION['user']['user_id']) {
	    			?>
	    			<div style="text-align: center;" class="sysBoardFollowAllButton<?= $is_followed ? ' hidden' : '' ?>" id="SFADD71">
	    				<a href="/action/follow?user_id=<?= $user['user_id'] ?>" class="Button12 Button OrangeButton" rel="follow">
	    					<strong>Follow</strong><span></span>
	    				</a>
	    			</div>
	            	<div style="text-align: center;" class="sysBoardUnFollowAllButton<?= !$is_followed ? ' hidden' : '' ?>" id="SFREM71">
	            		<a href="/action/unfollow?user_id=<?= $user['user_id'] ?>" class="Button12 Button OrangeButton disabled" rel="unfollow">
	            			<strong>Unfollow</strong><span></span>
	            		</a>
	            	</div>
	            	<?
				}
				?>
	        </div>
	        <?
	    }
	}
}

function output_avatar($user_id, $width, $height = NULL) {
	require DR . '/lib/php/resize-image.php';
	
	$file = DR . '/uploads/avatars/nopic-desktop.gif';
    //$file = preg_replace('dev', 'www', $file);
    $file = str_replace('dev', 'www', $file);

	if (is_numeric($user_id)) {
		$file_path = DR . AVATARPATH . $user_id;
		if (file_exists($file_path)) {
			$file = $file_path;
		}
	}
	
	$image = new SimpleImage($file);
	if (!empty($width)) {
		if (empty($height)) {
			$image->square($width);
		}
		else {
			$image->resize($width, $height);
		}
	}
	$image->output();
}

function cdn_product_image($product_file_id, $width, $height) {
	return CDN_IMAGE_SCRIPT . $product_file_id . '&amp;width=' . $width . '&amp;height=' . $height;
}

function output_orders($orders) {
	if (empty($orders)) {
		?>
        <p>No orders found.</p>
        <?
	}
	else {
		?>
		<table class="cart">
			<thead>
				<tr>
					<th scope="col" class="order-number">Order #</th>
					<th scope="col" class="date">Date</th>
					<th scope="col" class="amount monetary">Amount</th>
				</tr>
			</thead>
			<tbody>
				<?
				foreach ($orders as $i => $order) { 
					?>
					<tr>
						<td class="order-number"><a href="<?= HEADER_LOCATION_PREFIX ?>/shop/order-details.php?id_order=<?= $order['id_order'] ?>"><?= $order['id_order'] ?></a></td>
						<td class="date"><a href="<?= HEADER_LOCATION_PREFIX ?>/shop/order-details.php?id_order=<?= $order['id_order'] ?>"><?= date('m/d/Y g:i a', strtotime($order['date_add'])) ?></a></td>
						<td class="amount monetary"><a href="<?= HEADER_LOCATION_PREFIX ?>/shop/order-details.php?id_order=<?= $order['id_order'] ?>">$<?= number_format($order['total_paid'], 2) ?></a></td>
					</tr>
					<? 
				}
				?>
			</tbody>
		</table>
		<?
	}
}

function output_order_details($order) {
	if (empty($order['products'])) {
		?>
        <p>No items found.</p>
        <?
	}
	else {
		?>
        <table class="cart">
            <thead>
                <tr>
                    <th scope="col" class="image"></th>
                    <th scope="col" class="product">Product Name</th>
                    <th scope="col" class="price monetary">Unit Price</th>
                    <th scope="col" class="quantity">Qty</th>
                    <?
					/*
                    <th scope="col" class="subtotal monetary">Subtotal</th>
					*/
					?>
                </tr>
            </thead>
            <tbody>
                <?
               	$width = 74;
				$height = 111;
				
				$sales_tax = 0;
				$affiliate_discount = 0;
				$coupon_discount = 0;
				$total_weight = 0;
				$sub_total = 0;
				$grand_total = 0;
				foreach ($order['products'] as $i => $product) { 
					$id_product 			= $product['product_id'];
					$id_product_attribute 	= $product['product_attribute_id'];
					$product_name			= $product['product_name'];
					$product_image			= '';
					$quantity 				= $product['product_quantity'];
					$price 					= $product['product_price'];
					$total_price 			= $price * $quantity;
					$product_tax			= !empty($product['tax_info']) ? $product['tax_info']['total_amount'] : 0;
					$sales_tax				= $sales_tax + $product_tax;
					$affiliate_discount		= $affiliate_discount;
					$coupon_discount		= $coupon_discount;
					
					$total_weight			= $total_weight + $product['product_weight'];
					$sub_total				= $sub_total + $total_price;
					$grand_total			= $grand_total + $total_price + $product_tax;
					
					$image_url = cdn_product_image($product['product_file_id'], $width, $height);
					?>
					<tr>
                        <td class="image">
                            <img src="<?= $image_url ?>" width="<?= $width ?>" height="<?= $height ?>" alt="<?= $product_name ?>" />
                        </td>
                        <td class="product">
                            <a href="<?= HEADER_LOCATION_PREFIX ?>/shop/product.php?id_product=<?= $id_product ?>"><?= $product_name ?></a>
                            <?
                            if (!empty($product['attributes'])) {
                                $attributes = explode(chr(0x1D), $product['attributes']);
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
                        <td class="quantity"><?= $quantity ?></td>
                        <?
						/*
                        <td class="subtotal monetary">$<?= number_format($total_price, 2, '.', ',') ?></td>
						*/
						?>
					</tr>
					<? 
				}
               ?>
            </tbody>
        </table>
        <?
	}
}

?>