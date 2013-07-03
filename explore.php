<?
$pageTitle = "Explore";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include "header.php";

//var_dump($_data['posts']);

$Spine = new Spine(array('bare' => 1));
$Spine->output_explore($_data['posts']);

?>
<div id="product-popup">
</div>
<div id="product-overlay">
</div>

<?php include "footer.php" ?>
<script>

    console.log(<? echo json_encode( $_data['posts'] ) ?>);

$('.image').hover(function(){
	$(this).find('.explore-prod-options-box').fadeToggle(1);
},
function(){
	$(this).find('.explore-prod-options-box').fadeToggle(1);
});

var product = new Object();
product.openProduct = "<?= (!empty($_GET['product_id']) ? $_GET['product_id'] : '' )?>";
product.script = 'explore_popup.php';
product.isOpen = false;
product.overlay = $('#product-overlay');
product.popup = $('#product-popup');

//Methods
product.show = showProduct;
product.showOverlay = showProdOverlay;
product.hideMe = hideProduct;
product.resizer = function() {
    product.popup.height( (window.innerHeight - 60) );
}

//FUNCTIONS
function hideProduct(){
	product.popup.slideUp(200, function(){
		product.overlay.fadeOut(200);
        $(window).off('resize', product.resizer);
		$('body').css('overflow', 'visible');
	})
}
function showProdOverlay(){
	this.overlay.fadeIn(200);
}
function hideOverlay(){
	this.overlay.fadeOut(100);
}

function showProduct(id){
	URL = this.script+'?id_product='+id;
	$('#product-popup').load(URL, function(){
		product.showOverlay();
		product.popup.height( (window.innerHeight - 60) ).show();
        $(window).resize(product.resizer);
		$('body').css('overflow', 'hidden');
	});
}

$("#product-overlay").bind('click', function(){
	product.hideMe();
});

if(product.openProduct != ''){
	id = parseInt(product.openProduct);
	if(id > 0){
		product.show(id);
	}
}

</script>