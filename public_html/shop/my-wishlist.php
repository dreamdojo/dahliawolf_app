<?
$pageTitle = "Shop - My Wishlist";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

require DR . '/includes/php/classes/Product_Listing.php';
?>
<div class="shop body">
	
	<h2>My Wishlist</h2>
	
	<?
	
	$Product_Listing = new Product_Listing(
		array(
			'is_wishlist' => true
		)
	);
	$Product_Listing->output($wl_data['data']['get_wishlist']['data']);
	?>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>