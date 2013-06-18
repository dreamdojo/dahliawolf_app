<?
if($_GET['session_type'] == "web") {
	$pageTitle = "My Wishlist - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
	echo '<div style="margin-top: 75px"></div>';  
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>

<h2>My Wishlist</h2>

<div class="container">
	<div class="content">
		<div class="product">
			<ul class="line-list">
			<?
				foreach($wl_data['data']['get_wishlist']['data'] AS $key => $value) {
			?>
				<li>
					<a href="/mobile/shop/product.php?id_product=<?= $value['id_product'] ?>&session_type=<?= $_GET['session_type'] ?>" class="come-img"><img src="http://content.dahliawolf.com/shop/product/image.php?file_id=<?= $value['product_file_id'] ?>&width=240&height=360" /></a>
					<div><strong><?= $value['product_lang_name'] ?></strong></div>
					<div><?= $value['username'] ?></div>
					<div class="up-info"><a href="#">SOLD OUT</a></div>
				</li>
				
			<? } ?>
			</ul>
		</div>
	</div>
</div>

<? 
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>
