<?
$pageTitle = "Shop - Order Details";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<div class="shop body checkout">
	<?
	include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
	?>

	<h2>Order #<?= !empty($_data['order']) ? $_data['order']['id_order'] : '' ?> <span style="font-weight: normal;">(<?= $_data['order']['payment_status'] ?>)</span></h2> - <a href="<?= CR ?>/shop/order-return.php?id_order=<?= $_data['order']['id_order'] ?>">Request Return</a>
	<?
	output_order_details($_data['order']);
	?>

</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>