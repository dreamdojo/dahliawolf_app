<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Vote - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
	echo '<div style="margin-top: 75px"></div>';  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>

	<div class="container">
		<div class="content" style="float: none;">
			<div class="product" style="padding:0;">
				<div class="model">
					<div class="left-model">
						<img src="images/wild-background.jpg" alt="wild" />
						<div class="wild-logo"><img src="images/wild-logo.png"  alt="wild"/></div>
					</div>
 				
 				<div class="center-model">
 					<img src="images/model.png" />
 						<div class="votes">
 							<h1>950 Votes</h1>
  							<p>Jerry Doe</p>
 						</div>
 				</div> 
				<div class="right-model" style="right:20px;">
					<img src="images/next-slash.png" alt="next-slash" />
					<div class="next-button">
						<a href="#"><img src="images/button-next.png" alt="next-button" /></a>
					</div>
				</div> 
				</div>
			</div>
		</div>
</div>

<? 
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>