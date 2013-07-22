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

<? var_dump($_data['post']); ?>
<style>

</style>

<? if( 1 == 2/*isset($_data['post']['previous_posting_id']) && isset($_GET['ajax'])*/ ): ?>
     <a href="/post-details?posting_id=<?= $_data['post']['previous_posting_id'] ?>" rel="modal"><div class="arrow" id="leftArrow"></div></a>
<? endif ?>
<? if( 1 == 2/*isset($_data['post']['next_posting_id']) && isset($_GET['ajax'])*/ ): ?>
     <a href="/post-details?posting_id=<?= $_data['post']['next_posting_id'] ?>" rel="modal"><div class="arrow" id="rightArrow"></div></a>
<? endif ?>
<div class="post-details-container posting-<?= $_data['post']['posting_id'] ?><?= !empty($_data['post']['is_liked']) ? ' liked' : '' ?>" data-posting_id="<?= $_data['post']['posting_id'] ?>">
    
    <div id="postDetailTopRow">
    	<div class="postDetailAvatarFrame">
        	<a href="/<?= $_data['post']['username'] ?>"><img src = "<?= $_data['post']['avatar'] ?>" /></a>
        </div>
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
                <li class="cursor" id="shareFacebook"></li>
                <a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com&amp;media=<?= $_data['post']['image_url'] ?>" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                	<li id="sharePinterest"></li>
                </a>
                <a href="http://www.tumblr.com/share/photo?source=<?= rawurlencode( $_data['post']['image_url'] )?>&caption=<?= rawurlencode( "OMG Super Amazeballs" )?>&click_thru=<?= rawurlencode( "http://www.dahliawolf.com/post/".$_data['post']['posting_id']) ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                	<li id="shareTumbler"></li>
                 </a>
                 <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&amp;url=http://www.dahliawolf.com/post/<?= $_data['post']['posting_id'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">	
                    <li id="shareTwitter"></li>
                 </a>
                <a href="https://plus.google.com/share?url=http://www.dahliawolf.com/post/<?= $_data['post']['posting_id'] ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                	<li id="shareGplus"></li>
                </a>
                <a href='mailto:?subject=Frickin Awesome&body=Yo check out this bangin outfit I found at http://www.dahliawolf.com/post/<?= $_data['post']['posting_id'] ?>.'>
                	<li id="shareEmail"></li>
                </a>
            </ul>
        </div>
    </div>
    <div id="postDetailMainRow">
    	<div class="postImageFrame">
        	<? if($_data['post']['is_winner']): ?>
                <div class="is_winner_box">WINNER <a href="/shop/<?= $_data['post']['product_id'] ?>">view item</a></div>
            <? endif ?>
            <a href="<?= $_data['post']['image_url'] ?>" target="_blank"><img class="zoom-in" src="<?= $_data['post']['image_url'] ?>" /></a>
        </div>
        
        <div class="postOrigin"> Posted from <a href="<?= $_data['post']['image_attribution_url'] ?>" target="_blank"><?= $_data['post']['image_attribution_domain'] ?></a> on <?= $created[0] ?></div>
       	
        <div class="socialCol">
        	<div class="postDetailCommentSection">
            	<div class="commentSectionTitle">COMMENTS</div>
                <div class="postDetailCommentBox">
                	 <div class="postCommentAvatarFrame">
                         <? if(IS_LOGGED_IN): ?>
                         	<img src="<?= $userConfig['avatar'] ?>" />
                         <? else: ?>
                         	<img src="http://www.dahliawolf.com/avatar.php?user_id=&width=190">
						 <? endif ?>
                     </div>
                     <textarea id="postUserCommentBox" class="socialize" placeholder="Enter Comment Here!"></textarea>
                </div>
                <div id="postCommentButton">POST COMMENT</div>
                <div id="commentContainer">
					<? foreach($_data['comments'] as $comment): ?>
                        <? $hashified = socialize($comment['comment']); ?>
                        <div class="postDetailCommentBox">
                            <div class="postCommentAvatarFrame">
                                <img src="<?= $comment['avatar'] ?>" />
                            </div>
                            <div class="postCommentComment">
                                <p class="name"><?= $comment['username'] ?></p>
                                <p><?= $hashified ?></p>
                            </div>
                        </div>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="postGridTitle"></div>
<div id="userPostGrid"></div>

<script>

var thePostDetail = new postDetail(<?= json_encode($_data['post']) ?>);

<? if( isset($_GET['ajax']) ): ?>
	var thePostGrid = new postDetailGrid(thePostDetail.data.user_id, $('#modal-content'), false, 'posts');
    sendToAnal({name:'is viewing post <?= $_GET['posting_id'] ?>'});
<? else: ?>
    $('body').css('overflow', 'auto');
<? endif ?>

$('.socialize').bind('click', pplFinder.start);
</script>

<?
if (!isset($_GET['ajax'])) {
	include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
}
?>