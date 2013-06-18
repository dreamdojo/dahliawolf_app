<?
$pageTitle = "Following - Dahlia\Wolf";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";   
?>

<div class="activity-bar">FOLLOWING</div>

<div class="feed-wrap">
		<? //var_dump($_data['followers']) ?>
        
		<? foreach($_data['following'] as $person): ?>
        	<div class="prof-frame" >
            	<a href="<?= DAHLIAWOLF_MOBILE ?>profile.php?username=<?= $person['username'] ?>"><img src="<?= $person['avatar'] ?>" /></a>
            </div>
		<? endforeach ?>
</div>

<? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>

<script language="javascript" type="text/javascript">
function ATF(id,nhide,nshow) {
	$('#'+nhide).addClass('hidden');
	$.post("http://www.dahliawolf.com/fav.php",{"id":id},function(html) {
		$('#'+nshow).removeClass('hidden');
	});
}
function RFF(id,nhide,nshow) {
	$('#'+nhide).addClass('hidden');
	$.post("http://www.dahliawolf.com/fav2.php",{"id":id},function(html) {
		$('#'+nshow).removeClass('hidden');
	});
}
</script>