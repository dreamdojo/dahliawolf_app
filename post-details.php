<?
	if (empty($_GET['posting_id'])) {
		die();
	}
	
	if (!isset($_GET['ajax'])) {
		include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
		include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
	}
	else {
		require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
		require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/initial-calls.php';
	}

    if(isset($_GET['posting_id'])){
        $params = array(
            'posting_id' => $_GET['posting_id']
        );
    }
    if (IS_LOGGED_IN) {
        $params['viewer_user_id'] = $_SESSION['user']['user_id'];
    }
    $data = api_call('posting', 'get_post', $params, true);
    $_data['post'] = $data['data'];

    // Comments
    $data = api_call('comment', 'get_post_comments', $params, true);
    $_data['comments'] = $data['data'];
	
	$params = array(
		'user_id' => $_data['post']['user_id']
	);
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	$posterData = api_call('user', 'get_user', $params, true);
	$posterData = $posterData['data'];
	
	$created = explode(' ', $_data['post']['created']);
?>

<? //var_dump($_data['post']); ?>
<style>

</style>

<? if(!isset( $_GET['ajax'] )): ?>
    <div id="modal-content" style="margin-left: -500px;">
<? endif ?>

<div class="pdWrap">
<div class="post-details-container posting-<?= $_data['post']['posting_id'] ?><?= !empty($_data['post']['is_liked']) ? ' liked' : '' ?>" data-posting_id="<?= $_data['post']['posting_id'] ?>">

    <div id="postDetailTopRow">
        <ul class="postDetailAvatarFrame avatarShutters" style='background-image: url("<?= $_data['post']['avatar'] ?>&width=200")'>
            <li id="postDetailFollowButton"><?= $_data['post']['is_following'] ? 'Following' : 'Follow' ?></li>
            <li><a href="@<?= $_data['post']['username'] ?>" rel="message">Message</a></li>
            <li><a href="/<?= $_data['post']['username'] ?>">Profile</a></li>
        </ul>
        <ul class="deetsList">
        	<li class="postDetailUsername name"><a href="/<?= $_data['post']['username'] ?>"><?= $_data['post']['username'] ?></a></li>
            <li class="postDetailUserLocation"><?= $posterData['location'] ?></li>
           <li class="postDetailStat" style="margin-top: 10px;">RANK <?= $posterData['rank'] ?></li>
            <li class="postDetailStat"><a href="/<?= $_data['post']['username'] ?>/followers">FOLLOWERS</a> <span id="detailFollowingCount"><?= $posterData['followers'] ?></span></li>
            <li class="postDetailStat"><a href="/<?= $_data['post']['username'] ?>/following">FOLLOWING </a><?= $posterData['following'] ?></li>
            <li class="postDetailStat"></li>
        </ul>
        
        
        <div id="postDetailLoveButton" class="postDetailLikes cursor <?= ($_data['post']['is_liked'] ? 'pd-Loved' : 'pd-unLoved') ?>">
        	<div id="loveCount" class="buttonText"><?= $_data['post']['likes'] ?></div>
        </div>
        <div id="postShareSection">
        	<div class="postShareTitle">SHARE THIS POST</div>
            <ul class="shareButts">
                <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.dahliawolf.com/post/<?= $_data['post']['posting_id']  ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                    <li class="cursor" id="shareFacebook"></li>
                </a>
                <a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com&amp;media=<?= $_data['post']['image_url'] ?>" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                	<li id="sharePinterest" class="shareButton" data-platform="pinterest"></li>
                </a>
                <a href="http://www.tumblr.com/share/photo?source=<?= rawurlencode( $_data['post']['image_url'] )?>&caption=<?= rawurlencode( "Vote for this " )?>&click_thru=<?= rawurlencode( "http://www.dahliawolf.com/post/".$_data['post']['posting_id']) ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                	<li id="shareTumbler" class="shareButton" data-platform="tumbler"></li>
                 </a>
                 <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&amp;url=http://www.dahliawolf.com/post/<?= $_data['post']['posting_id'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">	
                    <li id="shareTwitter" class="shareButton" data-platform="twitter"></li>
                 </a>
                <a href="https://plus.google.com/share?url=http://www.dahliawolf.com/post/<?= $_data['post']['posting_id'] ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                	<li id="shareGplus" class="shareButton" data-platform="google"></li>
                </a>
                <a href='mailto:?subject=Check out Dahliwolf.com&body=Vote for this post http://www.dahliawolf.com/post/<?= $_data['post']['posting_id'] ?>.'>
                	<li id="shareEmail" class="shareButton" data-platform="email"></li>
                </a>
            </ul>
        </div>
    </div>
    <div id="postDetailMainRow">
        <a id="post_image" class="zoombox" data-url="<?= $_data['post']['image_url'] ?>">
            <div id="postDetailImage" class="postImageFrame <?= intval($_data['post']['width']) > intval($_data['post']['height']) ? 'postWide' : 'postTall' ?>" style='background-image: url("<?= $_data['post']['image_url'] ?>&width=620")'></div>
        </a>
        
        <div class="postOrigin">
            Posted from <a href="<?= $_data['post']['image_attribution_url'] ?>" target="_blank"><?= $_data['post']['image_attribution_domain'] ?></a> on <?= $created[0] ?>,
        </div>
       	
        <div class="socialCol">
        	<div class="postDetailCommentSection">
            	<div class="commentSectionTitle">COMMENTS</div>
                <? if(IS_LOGGED_IN): ?>
                    <div class="postDetailCommentBox">
                        <div class="postCommentAvatarFrame" style="background-image: url('<?= $userConfig['avatar'] ?>&width=75')"></div>
                        <textarea id="postUserCommentBox" class="socialize" placeholder="Write message @member, #hashtag"></textarea>
                    </div>
                    <div id="postCommentButton">ADD COMMENT</div>
                <? endif ?>
                <div id="commentContainer" style="height: <?= $_data['post']['total_tags'] ? '227px' : '100%'?>;">
					<? foreach($_data['comments'] as $comment): ?>
                        <? $hashified = socialize($comment['comment']); ?>
                        <div class="postDetailCommentBox">
                            <a href="/<?= $comment['username'] ?>">
                                <div class="postCommentAvatarFrame" style="background-image: url('<?= $comment['avatar'] ?>&width=75');"></div>
                            </a>
                            <div class="postCommentComment">
                                <p class="name"><a href="/<?= $comment['username'] ?>"><?= $comment['username'] ?></a></p>
                                <p><?= $hashified ?></p>
                            </div>
                        </div>
                    <? endforeach ?>
                </div>
                <? if( $_data['post']['total_tags'] || $_data['post']['user_id'] == $_SESSION['user']['user_id'] ): ?>
                    <div class="commentSectionTitle" style="margin-top: 20px;">Notes from <?= $_data['post']['username'] ?></div>
                    <div id="tagsSection"></div>
                <? endif ?>
            </div>
        </div>
    </div>
</div>
<div id="postGridTitle">MORE POSTS BY <a href="/<?= $_data['post']['username'] ?>"><?= $_data['post']['username'] ?></a></div>
<div id="userPostGrid"></div>
</div>

<? if(!isset( $_GET['ajax'] )): ?>
    </div>
<? endif ?>



<script>

    $(function() {
        console.log(<?= json_encode($_data['post']) ?>);
        window.thePostDetail = new postDetail(<?= json_encode($_data['post']) ?>);
        window.thePostGrid = new postDetailGrid(thePostDetail.data.user_id, $('#modal-content'), false, 'posts');

        _gaq.push(['_trackEvent', 'Post', 'Viewing as pop up']);
        <? if(isset($_GET['ajax'])): ?>
        $('body').css('overflow', 'hidden');
        <? endif ?>;
    });

</script>

<?
if (!isset($_GET['ajax'])) {
	include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
}
?>