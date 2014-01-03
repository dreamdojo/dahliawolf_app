<?
$pageTitle = "My Runway";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

require DR . '/includes/php/classes/Product_Listing.php';
?>
<div class="shop body">
	
	<h2>My Runway</h2>
	
	<?
	$Product_Listing = new Product_Listing();
	$Product_Listing->output($_data['products']);
	?>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>