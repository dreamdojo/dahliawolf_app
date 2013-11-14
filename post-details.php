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

    // Likes
    $data = api_call('posting', 'get_post_likes', $params, true);
    $_data['post_likes'] = $data['data'];

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

<? if( 1 == 2/*isset($_data['post']['previous_posting_id']) && isset($_GET['ajax'])*/ ): ?>
     <a href="/post-details?posting_id=<?= $_data['post']['previous_posting_id'] ?>" rel="modal"><div class="arrow" id="leftArrow"></div></a>
<? endif ?>
<? if( 1 == 2/*isset($_data['post']['next_posting_id']) && isset($_GET['ajax'])*/ ): ?>
     <a href="/post-details?posting_id=<?= $_data['post']['next_posting_id'] ?>" rel="modal"><div class="arrow" id="rightArrow"></div></a>
<? endif ?>
<div class="post-details-container posting-<?= $_data['post']['posting_id'] ?><?= !empty($_data['post']['is_liked']) ? ' liked' : '' ?>" data-posting_id="<?= $_data['post']['posting_id'] ?>">

    <div id="postDetailTopRow">
        <a href="/<?= $_data['post']['username'] ?>">
            <div class="postDetailAvatarFrame" style='background-image: url("<?= $_data['post']['avatar'] ?>&width=200")'></div>
        </a>
        <ul class="deetsList">
        	<li class="postDetailUsername name"><a href="/<?= $_data['post']['username'] ?>"><?= $_data['post']['username'] ?></a></li>
            <li class="postDetailUserLocation"><?= $posterData['location'] ?></li>
           <li class="postDetailStat">RANK <?= $posterData['rank'] ?></li>
            <li class="postDetailStat"><a href="/<?= $_data['post']['username'] ?>/followers">FOLLOWERS</a> <span id="detailFollowingCount"><?= $posterData['followers'] ?></span></li>
            <li class="postDetailStat"><a href="/<?= $_data['post']['username'] ?>/following">FOLLOWING </a><?= $posterData['following'] ?></li>
            <li class="postDetailStat"></li>
        </ul>
        
        
        <div id="postDetailLoveButton" class="postDetailLikes cursor <?= ($_data['post']['is_liked'] ? 'pd-Loved' : 'pd-unLoved') ?>">
        	<div id="loveCount" class="buttonText"><?= $_data['post']['total_likes'] ?></div>
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
    	<div class="postImageFrame">
        	<? if($_data['post']['is_winner']): ?>
                <div class="is_winner_box">WINNER <a href="/shop/<?= $_data['post']['product_id'] ?>">view item</a></div>
            <? endif ?>
            <a id="post_image" class="zoombox" data-url="<?= $_data['post']['image_url'] ?>"><img class="zoom-in" src="<?= $_data['post']['image_url'] ?>" /></a>
        </div>
        
        <div class="postOrigin">
            Posted from <a href="<?= $_data['post']['image_attribution_url'] ?>" target="_blank"><?= $_data['post']['image_attribution_domain'] ?></a> on <?= $created[0] ?>,
            Needs <span id="totalVotesNeed" class="dahliaPink"><?= (1000 - $_data['post']['total_likes']) ?></span> More Votes To Win
        </div>
       	
        <div class="socialCol">
        	<div class="postDetailCommentSection">
            	<div class="commentSectionTitle">COMMENTS</div>
                <? if(IS_LOGGED_IN): ?>
                    <div class="postDetailCommentBox">
                         <div class="postCommentAvatarFrame" style="background-image: url('<?= $userConfig['avatar'] ?>&width=75')"></div>
                         <textarea id="postUserCommentBox" class="socialize" placeholder="Enter Comment Here!"></textarea>
                    </div>
                <? endif ?>
                <div id="postCommentButton">POST COMMENT</div>
                <div id="commentContainer">
					<? foreach($_data['comments'] as $comment): ?>
                        <? $hashified = socialize($comment['comment']); ?>
                        <div class="postDetailCommentBox">
                            <div class="postCommentAvatarFrame" style="background-image: url('<?= $comment['avatar'] ?>&width=75');"></div>
                            <div class="postCommentComment">
                                <p class="name"><a href="/<?= $comment['username'] ?>"><?= $comment['username'] ?></a></p>
                                <p><?= $hashified ?></p>
                            </div>
                        </div>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="postGridTitle">MORE POSTS BY <a href="/<?= $_data['post']['username'] ?>"><?= $_data['post']['username'] ?></a></div>
<div id="userPostGrid"></div>

<? if(!isset( $_GET['ajax'] )): ?>
    </div>
<? endif ?>



<script>

    $(function() {

        window.thePostDetail = new postDetail(<?= json_encode($_data['post']) ?>);
        window.thePostGrid = new postDetailGrid(thePostDetail.data.user_id, $('#modal-content'), false, 'posts');

        sendToAnal({name:'is viewing post <?= $_GET['posting_id'] ?>'});
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