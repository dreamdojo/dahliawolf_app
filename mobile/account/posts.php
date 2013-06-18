<?
$pageTitle = "My Posts";
//$Spine = new Spine(array('bare' => true));
if($_GET['session_type'] == "web") {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>

<div class="activity-bar">MY POSTS</div>

<div class="feed-wrap">
<? foreach($_data['posts'] as $i=>$post): ?>
	<div class="pi-frame pi-<?= ($i %2 ? 'even' : 'odd') ?>" >
    	<a href="<?= DAHLIAWOLF_MOBILE ?>post-details.php?posting_id=<?= $post['posting_id'] ?>&session_type=web">
        	<img src="<?= $post['source'].$post['imagename'] ?>" style="<? echo ($post['width'] >= $post['height']? 'height' : 'width' ) ?>:100%;" class="lazy" >
        </a>
        <div class="pi-lb" style="background-image:url(<?= DAHLIAWOLF_MOBILE ?>images/heart_bg_on.png);" onclick="unlikePost('<?= $post['posting_id'] ?>', this)')">
        	<div class="lb-num"><?= $post['total_likes'] ?></div>
        </div>
    </div>
<? endforeach ?>
</div>

<?  include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"  ?>