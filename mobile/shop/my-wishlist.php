<?
if($_GET['session_type'] == "web") {
	$pageTitle = "My Wishlist - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}

require DR . '/includes/php/classes/Product_Listing.php'
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
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>
