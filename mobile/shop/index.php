<?
if(!empty($_GET['session_type']) && $_GET['session_type'] == "web") {
	$pageTitle = "Shop - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}

//require DR . '/includes/php/classes/Product_Listing.php';
?>
<div class="activity-bar">FEED</div>
	<?
		//include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
	?>
	<div id="feed-wrap">
    <img src="../images/Store 2.jpg" width="100%"/>
    </div>
	<?
	//$Product_Listing = new Product_Listing(array('image_dimensions' => array(300, 450)));
	//$Product_Listing->output($_data['products']);
	?>
<?
/*
<div class="container">
	<div class="content">
		<div class="product">
			<ul class="pro-list">
				<li>
					<a href="/mobile/shop/product.php?session_type=<?= $_GET['session_type'] ?>" class="product-img"><img src="/mobile/images/fav1.png"  /></a>
					<div class="product-info">
						<h1>DRESS IT</h1>
						<span>$48.00</span>
						<h5> justin Mavandi</h5>
					</div>
				</li>

				<li>
					<a href="/mobile/shop/product.php?session_type=<?= $_GET['session_type'] ?>" class="product-img"><img src="/mobile/images/fav2.png"  /></a>
					<div class="product-info">
						<h1>TOP DRESS</h1>
						<span>$98.00</span>
						<h5>Lissa maximum</h5>

					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
*/

include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>
