<?
if($_GET['session_type'] == "web") {
	$pageTitle = "My Wild 4's - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
$Spine = new Spine(array('bare' => true));
?>

<div class="activity-bar">MY WILD 4s</div>

<div class="feed-wrap">
<? foreach($_data['posts'] as $i=>$post): ?>
	<div class="pi-frame pi-<?= ($i %2 ? 'even' : 'odd') ?>" >
    	<a href="<?= DAHLIAWOLF_MOBILE ?>post-details.php?posting_id=<?= $post['posting_id'] ?>&session_type=web">
        	<img src="<?= $post['source'].$post['imagename'] ?>" style="<? echo ($post['width'] >= $post['height']? 'height' : 'width' ) ?>:100%;" class="lazy" >
        </a>
        <div class="pi-lb" style="background-image:url(<?= DAHLIAWOLF_MOBILE ?>images/heart_bg_on.png);" onclick="unlikePost(<?= $post['posting_id'] ?>, this)">
        	<div class="lb-num"><?= $post['total_likes'] ?></div>
        </div>
    </div>
<? endforeach ?>
</div>

<?  include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"  ?>
<script>
function likePost(id, el){
	if(User.name){
		count = $(el).find('div');
		
		$.post('../../action/like.php?posting_id='+id).done(function(){
			count.html( (parseInt(count.html())+1) );
			$(el).css('background-image', 'url(../images/heart_bg_on.png)');
			$(el).attr('onclick', 'unlikePost('+id+', this)');
		});
	}else{
		document.location = 'login.php';
	}
}
function unlikePost(id, el){
	if(User.name){
		count = $(el).find('div');
		
		$.post('../../action/unlike.php?posting_id='+id).done(function(){
			count.html( (parseInt(count.html())-1) );
			$(el).css('background-image', 'url(../images/heart_bg.png)');
			$(el).attr('onclick', 'likePost('+id+', this)');
		});
	}else{
		document.location = 'login.php';
	}
}
</script>