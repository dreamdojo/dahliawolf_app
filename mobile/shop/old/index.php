<?
if(!empty($_GET['session_type']) && $_GET['session_type'] == "web") {
	$pageTitle = "Shop - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
	echo '<div style="margin-top: 60px"></div>';  
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>
<div class="container">
	<div class="content">
		<div class="product">
			<ul class="pro-list">
				<li>
					<a href="/mobile/shop/product.php" class="product-img"><img src="/mobile/images/fav1.png"  /></a>
					<div class="product-info">
						<h1>DRESS IT</h1>
						<span>$48.00</span>
						<h5> justin Mavandi</h5>
					</div>
				</li>

				<li>
					<a href="/mobile/shop/product.php" class="product-img"><img src="/mobile/images/fav2.png"  /></a>
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
