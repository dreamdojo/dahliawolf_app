<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Checkout - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>

<div class="shop body checkout">
	<?
	include DR . "/common/cart-summary.php";
	?>
	
	<h2>Checkout</h2>
	
	<?
	$checkout_steps = array(
		'cart' => 'My Shopping Cart'
		, 'billing' => 'Billing & Shipping'
		, 'shipping' => 'Shipping Options'
		//, 'payment' => 'Payment Type'
		, 'confirmation' => 'Order Review'
	);
	$current_step = 'cart';
	if (isset($_GET['step']) && !empty($checkout_steps[$_GET['step']])) {
		$current_step = $_GET['step'];
	}
	
	include DR . "/common/checkout-nav.php";
	
	$content_file = DR . '/common/checkout/' . $current_step . '.php';
	if (file_exists($content_file)) {
		include $content_file;
	}
	?>
	
</div>

<? 
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>