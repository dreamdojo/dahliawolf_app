<?
$pageTitle = "Shop - My Orders";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<div class="shop body checkout">
	<?
	include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
	?>

	<h2>My Orders</h2>

	<?
	$order_stages = array(
		'new' => 'New'
		, 'processing' => 'Processing'
		, 'shipping' => 'Shipping'
		, 'delivered' => 'Delivered'
		, 'returned' => 'Returned'
		, 'canceled' => 'Canceled'
	);
	$current_step = 'new';
	if (isset($_GET['step']) && !empty($order_stages[$_GET['step']])) {
		$current_step = $_GET['step'];
	}

	include DR . "/common/order-nav.php";

	$content_file = DR . '/common/order/' . $current_step . '.php';
	if (file_exists($content_file)) {
		include $content_file;
	}
	?>

</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>