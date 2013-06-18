<?
if(!empty($_GET['session_type']) && $_GET['session_type'] == "web") {
	$pageTitle = "Shop - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>
<div class="shop body checkout">
	
	<h2>Order #<?= !empty($_data['order']) ? $_data['order']['id_order'] : '' ?></h2>
	<?
	output_order_details($_data['order']);
	?>
	
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>