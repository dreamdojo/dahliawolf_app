<?
	if($_GET['session_type'] == "web") {
		$pageTitle = "Post Details - Dahlia\Wolf";
		include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
		include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  
	
	} else {
		include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	}
	
	$params = array(
		'posting_id' => $_GET['posting_id'],
		'viewer_user_id' => $_SESSION['user']['user_id']
	);
	
	$data = api_call('posting', 'get_post', $params, true);
	$data = $data['data'];
	
	$comms = api_call('comment', 'get_post_comments', $params, true);
	$data['comments'] = $comms['data'];
	
	//var_dump($data);
?>
<style>
#posterDetails{width: 96%;height: 50px;background-color: #FFF;margin-top: 5px;margin-left: 2%;}
#postDetails{ width:96%; margin-left:2%; margin-top:2px; background-color:#FFF; height:100%;overflow: hidden; min-height:400px;}
#postFrame{ height: 100%; width:98%; margin-left:1%; padding-top:1%; overflow:hidden;}
#postFrame img{ width:100%;z-index: 1000000000;}
#postOptions{ height: 40px;width: 95%;left: 2%;bottom: 46px;background-color: #fff;position: fixed;padding-top: 5px; opacity:.6; padding-bottom:10px;}
.postOption{ float:left; width: 32%; height:100%; margin-left: .9%;}
.postOptionTitle{width:100%; height:70%; background-color:#fff;}
.loved{ background-image:url(/mobile/images/loved.png);background-repeat: no-repeat;background-position: 50%;background-size: auto 100%; }
.unloved{ background-image:url(/mobile/images/loveDetail.png);background-repeat: no-repeat;background-position: 50%;background-size: auto 100%; }
.postOptionCount{width:100%; height:30%; /*background-color:#fff;*/ color:#000;}
.postOptionCount p{font-size: 1.2em;font-weight: 100; font-family:helvetica; text-align: center;padding-top: 1px;}
.posterAvatarFrame{ width:15%; overflow: hidden;height: 92%; margin-top:2px; margin-left:1%; float:left;}
.posterAvatarFrame img{ width:100%;}
.posterDeets{height:100%; float:left; margin-left:1%; margin-top:2px;}
.posterName{color:#d36477; font-size:1em; text-transform:uppercase;}
.posterFollowButton{ float: right;background-color: #c2c2c2;padding: 4px 15px;color: #fff;margin-top: 15px;border-radius: .3em;margin-right: 2%;}

#fullDetails{position:fixed; left:0px; top:0px; width:100%; height:100%; z-index: 1000000; background-color:#000; display:none;}
#fullDetails img{ width:98%; margin-left:1%; margin-top:5%; }
#optionsBar{position:absolute; top:0px; left:0px; height:60px; background-color:#000; opacity:.8;}

.popTitle{position:fixed; background-color:#f6f6f6; height:40px; color:#939393; width:100%; top:-50px; display:none; text-align:center;z-index: 1000001;}
.popTitle p{font-size: 1.7em;padding-top: 6px;}
.popTitleClose{ position:absolute; right:2%; font-size: 2.6em;top: 2px;}

#shareTitle{ background-image:url(/mobile/images/share.png);background-repeat: no-repeat;background-position: 50%;background-size: auto 100%;}
#commentTitle{ background-image:url(/mobile/images/comment.png);background-repeat: no-repeat;background-position: 50%;background-size: auto 100%;}
#likeTitle{ }

#doneAndLove{position:fixed; width:100%; height:40px; top:-40px; background-color:#000; display:none;z-index: 10000000001; opacity:.7;}
#deetDone{background:url(/mobile/images/deetDone.png) no-repeat; background-size: auto 100%;height: 80%;margin-top: 3px;width: 30%;float: left;position: relative;margin-left: 4%;}
#deetLove{height: 80%;margin-top: 3px;width: 30%;float: right;position: relative;margin-right: 4%;}
.deetLoved{background:url(/mobile/images/deetLoved.png) no-repeat; background-size: auto 100%;background-position-x: 100%;}
.deetUnLoved{background:url(/mobile/images/deetUnLoved.png) no-repeat; background-size: auto 100%;background-position-x: 100%;}
</style>
<div id="title-COMMENT" class="popTitle">
	<p>COMMENTS</p>
 	<div class="popTitleClose">X</div>
</div>

<div id="title-SHARE" class="popTitle">
	<p>SHARE</p>
 	<div class="popTitleClose">X</div>
</div>

<div id="doneAndLove">
	<div id="deetDone"></div>
    <div id="deetLove" class="<?= ($data['is_liked'] ? 'deetLoved' : 'deetUnLoved') ?>"></div>
</div>

<div id="fullDetails">
	<div id="optionsBar">
    </div>
    <img src="<?= $data['image_url'] ?>" />
</div>

<div id="postHomePage">
    <div id="posterDetails">
        <div class="posterAvatarFrame">
            <img src="<?= $data['avatar'] ?>" />
        </div>
        <div class="posterDeets">
            <div class="posterName"><?= $data['username'] ?></div>
            <div class="posterLocation">Los Angeles</div>
        </div>
        <div class="posterFollowButton">FOLLOW</div>
    </div>
    
    <div id="postOptions">
        <div class="postOption" id="toggleLove" data-liked="<?= ($data['is_liked'] ? 'true' : 'false') ?>">
            <div id="likeTitle" class="postOptionTitle <?= ($data['is_liked'] ? 'loved' : 'unloved') ?>">
            </div>
            <div class="postOptionCount">
                <p id="totalLikes">Love <?= $data['total_likes']?></p>
            </div>
        </div>
        <div class="postOption" id="doComments">
            <div id="commentTitle" class="postOptionTitle">
            </div>
            <div class="postOptionCount">
                <p id="totalComment">Comment <?= count($data['comments'])?></p>
            </div>
        </div>
        <div class="postOption" id="doShare">
            <div id="shareTitle" class="postOptionTitle">
            </div>
            <div class="postOptionCount">
                <p id="totalShares">Share 200</p>
            </div>
        </div>
    </div>
    
    <div id="postDetails">
        <div id="postFrame">
            <img id="thePostImage" src="<?= $data['image_url'] ?>">
        </div>
    </div>
</div>
<style>
#postShare{position:fixed; height:100%; width:100%; background-color:#c2c2c2; left:0px; top:100%; display:none;z-index: 1000000001;}
#postShare ul{margin-top:5%; width:90%; margin-left:5%;height: 70%;}
#shareFacebook{background:url(/mobile/images/shareFb.png) no-repeat;}
#shareEmail{background:url(/mobile/images/shareEmail.png) no-repeat;}
#shareTwitter{background:url(/mobile/images/shareTwitter.png) no-repeat;}
#sharePinterest{background:url(/mobile/images/sharePintrest.png) no-repeat;}
#shareTumblr{background:url(/mobile/images/shareTumbler.png) no-repeat;}
#shareText{background:url(/mobile/images/shareText.png) no-repeat;}
#postShare li{ background-color:#FFF; background-position:50%; background-size:100%; width:40%; margin-left:5%; margin-top:5%; height:10%;height: 20%;float: left;} 
</style>

<div id="postShare" class="optimize-me">
	<ul>
    	 <a href="https://www.facebook.com/dialog/feed?app_id=552515884776900&link=http://www.dahliawolf.com/mobile/postdetails.php?posting_id=<?= $data['posting_id'] ?>&session_type=web&picture=<?= $data['image_url'] ?>&name=Facebook%20Dialogs&caption=Freshness comin in HOT!&description=OMG Dahlia Wolf turns my images into fashion AMAZING!&redirect_uri=http://www.dahliawolf.com/mobile/postdetails.php?posting_id=<?= $data['posting_id'] ?>">
        	<li id="shareFacebook"></li>
        </a>
        <a href='mailto:?subject=Frickin Awesome&body=Yo check out this bangin outfit I found at http://www.dahliawolf.com/post/<?= $data['posting_id'] ?>.'>
        	<li id="shareEmail"></li>
        </a>
        <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&amp;url=http://www.dahliawolf.com/post/<?= $data['posting_id'] ?>" target="_blank">
        	<li id="shareTwitter"></li>
        </a>
        <a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com&amp;media=<?= $data['image_url'] ?>" class="pin-it-button" count-layout="horizontal" target="_blank">
        	<li id="sharePinterest"></li>
        </a>
        <a href="http://www.tumblr.com/share/photo?source=<?= rawurlencode( $data['image_url'] )?>&caption=<?= rawurlencode( "OMG Super Amazeballs" )?>&click_thru=<?= rawurlencode( "http://www.dahliawolf.com/post/".$data['posting_id']) ?>">
        	<li id="shareTumblr"></li>
        </a>
            <li id="shareText"></li>
    </ul>
</div>

<style>
#postComments{ position:fixed; width:100%; height:100%; background-color:#c2c2c2; top:100%; left:0px; overflow: auto; display:none;z-index: 100000001;}
.postComment{ background-color:#fff; margin-top:5px; width:96%; margin-left:2%; word-wrap:normal; font-size:.8em; color:#959595;min-height: 60px;float: left;padding-bottom: 5px;}
.commentAvatarFrame{height:50px; width:10%; overflow:hidden; float:left;margin-top: 5px;margin-left: 5px;}
.commentAvatarFrame img{width:100%;}
.commentData{float: left;margin-top: 5px;margin-left: 5px;width: 85%;}
.commentData span{color:#e18499;}

#addCommentBox{position:fixed; width:100%; height:40px; background-color:#FFF; bottom:0px; left:-100%; display:none;z-index: 100000002;}
#addCommentBox p{font-size: 1.4em;text-align: center;padding-top: 10px;}
.secretInput{position:absolute; height:100%; width: 82.5%; left:0px; top:0px; text-align: center;}
#sendCommentButton{right: 0;width: 17%;height: 30px;text-align: center;color: #575757;position: absolute;top: 0;padding-top: 12px;border-left: #c2c2c2 thin solid;}
</style>
<div id="postComments" class="optimize-me">
	<? foreach($data['comments'] as $comment): ?>
    	<div class="postComment">
        	<div class="commentAvatarFrame">
      			<img src="<?= $comment['avatar'] ?>" />
            </div>
            <div class="commentData">
            	<span><?= $comment['username'] ?>: </span>
                <?= $comment['comment'] ?>
            </div>
        </div>
	<? endforeach ?>
</div>

<div id="addCommentBox">
    <form id="commentForm" action="/action/comment.php">
    	<input id="postComment" type="text" class="secretInput" <?= (IS_LOGGED_IN) ? '' : 'readonly' ?> placeholder="ADD COMMENT" />
    </form>
    <div id="sendCommentButton">SEND</div>
</div>

<script>

$(function(){
	var thePost = new postDetail(<?= json_encode($data) ?>);
	
	if($(window).height() < 1060){
		$('body').height(120+'%');
		window.scrollTo(0, 0);
	}

});
</script>