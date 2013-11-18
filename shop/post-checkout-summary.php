<?
$pageTitle = "Shop - Order Summary";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<div class="shop body checkout">
	<? include DR . "/common/cart-summary.php"; ?>

	<h2>Order # <?= $_data['order']['id_order'] ?></h2>

	<div class="thank-you-message">
		<h3>Thank you for ordering from <?= $_data['shop']['name'] ?>.</h3>
		<p>Your order summary for <strong>Order #<?= $_data['order']['id_order'] ?></strong> is below:</p>
	</div>
	<?
	output_order_details($_data['order']);
	?>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>
<script>
    sendGeoffMessage('<?= $_SESSION['user']['username'] ?> just placed an order for <?= $_data['order']['products'][0]['product_name'] ?>');
</script>