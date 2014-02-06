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

    $url = 'http://www.dahliawolf.com/api/1-0/posting.json?function=get_posting&use_hmac_check=0&posting_id='.$_GET['posting_id'].(isset($_SESSION['user']['user_id']) ? '&viewer_user_id='.$_SESSION['user']['user_id'] : '');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
    $_data['post'] = (Array)$result->data->get_posting;

    // Comments
    $url = 'http://www.dahliawolf.com/api/1-0/posting.json?function=get_comments&use_hmac_check=0&posting_id='.$_GET['posting_id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
    $_data['comments'] = $result->data->get_comments;

	$created = explode(' ', $_data['post']['created']);
?>

<? //var_dump($_data['post']); ?>
<style>
.sharebutton{text-align: right;border: #c2c2c2 thin solid;float: right;padding: 5px 12px;border-radius: 7px;position: absolute;right: 0px;bottom: 27%;}
#postDetailTopRow{height: 60px; position: relative;}
#postDetailTopRow .userDeets{float: left;width: 300px;}
#postDetailTopRow .avatar{height: 50px;width: 50px;overflow: hidden;border-radius: 38px;background-size: cover;background-position: 50%; float: left;}
#postDetailTopRow .username{text-align: left;font-size: 19px;text-indent: 10px; color: #76bf00; margin-top: 7px;}
#postDetailTopRow .location{text-align: left; text-indent: 10px;}
.sharebutton{cursor: pointer;}
</style>

<div class="pdWrap">
<div class="post-details-container posting-<?= $_data['post']['posting_id'] ?><?= !empty($_data['post']['is_liked']) ? ' liked' : '' ?>" data-posting_id="<?= $_data['post']['posting_id'] ?>">

    <div id="postDetailTopRow">
       <ul class="userDeets">
           <a href="/<?= $_data['post']['username'] ?>"><li class="avatar" style="background-image: url(<?= $_data['post']['avatar'] ?>&width=50)"></li></a>
           <li class="username"><a href="/<?= $_data['post']['username'] ?>"><?= $_data['post']['username'] ?></a></li>
           <li class="location"><?= $_data['post']['location'] ?></li>
       </ul>
        <div class="sharebutton">BACK</div>
        <div style="clear: left;"></div>
        <!--<div id="postShareSection">
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
        </div>-->
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
                        <? $hashified = socialize($comment->comment); ?>
                        <div class="postDetailCommentBox">
                            <a href="/<?= $comment->username ?>">
                                <div class="postCommentAvatarFrame" style="background-image: url('<?= $comment->avatar ?>&width=75');"></div>
                            </a>
                            <div class="postCommentComment">
                                <p class="name"><a href="/<?= $comment->username ?>"><?= $comment->username ?></a></p>
                                <p><?= $hashified ?></p>
                            </div>
                        </div>
                    <? endforeach ?>
                </div>
            </div>
                <? if( $_data['post']['total_tags'] || $_data['post']['user_id'] == $_SESSION['user']['user_id'] ): ?>
                    <div class="commentSectionTitle" style="margin-top: 20px;">Notes from <?= $_data['post']['username'] ?></div>
                    <div id="tagsSection"></div>
                <? endif ?>
            </div>
        </div>
    </div>
    <div style="clear: left;"></div>
    <div id="postGridTitle">MORE POSTS BY <a href="/<?= $_data['post']['username'] ?>"><?= $_data['post']['username'] ?></a></div>
    <div id="userPostGrid"></div>
</div>

<? if(!isset( $_GET['ajax'] )): ?>
    </div>
    <?php //include "footer.php" ?>
<? endif ?>



<script>
    $(function() {
        window.thePostDetail = new postDetail(<?= json_encode($_data['post']) ?>);
        window.thePostGrid = new postDetailGrid(thePostDetail.data.user_id, $('#modal-content'), false, 'posts');
        $('.sharebutton').on('click', function() {
            if( $('#voteBucket').length ) {
                $('#voteBucket').show();
                dahliawolfFeed.bindScroll();
            }
            window.history.back();
        });
        if( $('#voteBucket').length ) {
            $('#voteBucket').hide();
            $(window).unbind();
        }

        _gaq.push(['_trackEvent', 'Post', 'Viewing as pop up']);
    });
</script>

<?
if (!isset($_GET['ajax'])) {
	//include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
}
?>