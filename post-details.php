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

<? //var_dump($_data['post']); ?>
<style>
.post-details-container{width: 1000px;
height: 800px;
margin-top: 25px; 
margin: 0px auto;
color: rgb(102, 102, 102);
font-family: Helvetica, sans-serif;
font-weight: 100;
box-shadow: rgb(235, 235, 235) -2px -2px 15px 2px;
background-color: rgb(241, 241, 241);
border: 1px solid rgb(219, 219, 219);
padding-bottom: 20px;
position: relative;}
#postDetailTopRow{ width: 100%;height: 100px;padding-top: 20px;background-color: white;padding-bottom: 20px;}
.postDetailAvatarFrame{height:100%; width:100px; overflow:hidden; float:left; padding-left: 20px;}
.postDetailAvatarFrame img{ width:100%;}
#postDetailTopRow .deetsList{ height:100%; width:270px; float:left; text-align: left;margin-left: 10px;font-size: 10px;}
#postDetailTopRow .deetsList li{ color:#b7b7b7; margin-top: 5px;}
#postDetailTopRow .postDetailStat a{color:#b7b7b7 !important;}
.postDetailFollow{ height:100%; width:115px; float:left; margin-right: 10px;}
.isFollowing{background-image:url(/images/postDetailIsFollowButton.png);background-repeat:no-repeat; background-size: 60% 50%;background-position: 50% 33%;}
.notFollowing{background-image:url(/images/postDetailFollowButton.png);background-repeat:no-repeat; background-size: 60% 50%;background-position: 50% 33%;}
.postDetailFollow:hover{ opacity:.7;}
.postDetailLikes{ height: 100%;
width: 115px;
float: left;
border: 1px solid rgb(218, 218, 218);
margin-top: 1px;}
.postDetailLikes:hover{opacity:.7; background-color: rgb(255, 239, 244) !important;}
.pd-Loved{ background-image:url(/images/postDetailsLoveButtonLoved.png); background-repeat:no-repeat; background-size: 45% 43%;background-position: 49% 34%; }
.pd-unLoved { background-image:url(/images/postDetailsLoveButton.png); background-repeat:no-repeat; background-size: 45% 43%;background-position: 49% 34%; }
#shareRow{ height:100%; width:400px; float:left;}
.postShareTitle{width: 100%;height: 15px;padding-top: 5px;font-size: 14px;padding-bottom: 5px;margin-left: -1px;border: 1px solid rgb(221, 221, 221);}
#postShareSection{width: 420px;float: right;margin-right: 40px;}
.shareButts{height: 82px; width:104%;}
.shareButts li{width: 63.7px;height:85%; float:left;background-color: #FFF; margin-top: 5px;margin-right: 5px; border:#dfdfdf thin solid; cursor:pointer;}
.shareButts li:hover{background-color: rgb(202, 202, 202) !important;}
#shareFacebook{background: url(/mobile/images/shareFb.png) no-repeat; background-position: 50%;background-size: 160% auto; background-color:#fff;}
#sharePinterest{background: url(/mobile/images/sharePintrest.png) no-repeat; background-position: 50%;background-size: 160% auto; background-color:#fff;}
#shareInstagram{background: url(/mobile/images/shareInstagram.png) no-repeat; background-position: 50%;background-size: 66% auto; background-color:#fff;}
#shareTumbler{background: url(/mobile/images/shareTumbler.png) no-repeat; background-position: 50%;background-size: 160% auto; background-color:#fff;}
#shareTwitter{background: url(/mobile/images/shareTwitter.png) no-repeat; background-position: 50%;background-size: 160% auto; background-color:#fff;}
#shareEmail{background: url(/mobile/images/shareEmail.png) no-repeat; background-position: 50%;background-size: 160% auto; background-color:#fff;}
#shareGplus{background: url(/mobile/images/shareGplus.png) no-repeat; background-position: 50%;background-size: auto 100%; background-color:#fff;}
#postDetailMainRow{height: 620px;
width: 100%;
margin-top: 20px;} 
.postImageFrame{ width: 620px;
overflow: hidden;
float: left;
height: 100%;
background-color: white;
margin-left: 20px;
border: 1px solid rgb(224, 224, 224)}
.postImageFrame img{height: 100%;}
.socialCol{width: 325px;
height: 100%;
float: left;
color: #b7b7b7;
margin-left: 20px;}
.commentSectionTitle{width:100%; height:20px; text-align:center;font-size: 14px;background-color: #fff;padding-top: 3px;}
.postDetailCommentBox{ height:75px; width:100%; margin-top: 10px; }
.postCommentAvatarFrame{ height: 75px;overflow: hidden;width: 75px;float: left;}
.postCommentAvatarFrame img{ width: 100%;}
.name a{ color: #a84655 !important;
font-weight: 100;
font-size: 20px;}
.name a:hover{ color: black !important;
}
.postCommentComment{float: left;
margin-left: 10px;
font-size: 12px;
background-color: #fff;
height: 55px;
padding: 10px; 
overflow: scroll;}
.postCommentComment p{ width:215px; text-align: left;}
.postDetailUsername{margin-top: 0px;font-size: 17px;}
.postDetailUserLocation{font-size: 13px;color: #000 !important;margin-top: 0px !important;}
.postDetailCommentSection{ width: 325px;}
.buttonText{font-size: 15px;margin-top: 63%;}
#postUserCommentBox{height: 49px;
width: 228px;
background-color: #fff;
margin-left: 12px;
float: left;
border: none;
padding: 5px;
font-size: 12px;}
#postCommentButton{width: 100%;
text-align: right;
margin-top: -12px;
margin-bottom: 16px;
font-size: 13px;
margin-left: -1px;
cursor: pointer;}
#postCommentButton:hover{color:#000;}
#commentContainer{height: 495px;overflow: auto;}
.postOrigin{position: absolute;bottom: 9px;float: left;font-size: 13px;padding-left: 20px;}
.arrow{ position:absolute; top:50%; height:100px; width:50px; margin-top: -50px; }
#leftArrow{left:-80px; background-image:url(/images/postDetailsLeftArrow.png); background-size:100% 100%; background-repeat:no-repeat;}
#rightArrow{right:-80px; background-image:url(/images/postDetailsRightArrow.png); background-size:100% 100%; background-repeat:no-repeat;}
#userPostGrid{ width: 920px;
float: left;
box-shadow: rgb(235, 235, 235) -2px -2px 15px 2px;
background-color: rgb(241, 241, 241);
border: 1px solid rgb(219, 219, 219);
margin-left: 30px;
padding-left: 30px;}
.userGridPostFrame{ float: left;
width: 264px;
overflow: hidden;
margin-right: 20px;
height: 315px;
margin-top: 25px;
border: rgb(255, 255, 255) 10px solid;
position: relative;}
.userGridPostFrame a{ float:left; height:100%;}
.userGridPostFrame img{ width:100%;}
.myLittleSecret{position:absolute; height:100%; right:0px; width:20px; background-color:#fff;}
.userGridPostFrame:hover .popGridLove{ display:block; }
.popGridLove{ position: absolute;height: 100px;width: 100px;left: 50%;margin-left: -50px;top: 50%;margin-top: -50px; display:none;}
.popGridnotLoved{background: url("/images/like.png") no-repeat center center; background-size: 100%;}
.popGridisLoved{background: url("/images/wild_like.png") no-repeat center center; background-size: 100%;}
#postGridTitle{font-size: 20px;
margin-top: 20px;
margin-bottom: 10px;
font-family: helvetica;
font-weight: 100;
text-align: center;
color: rgb(80, 80, 80);
}
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
        	<a href="<?= $_data['post']['image_url'] ?>" target="_blank"><img class="zoom-in" src="<?= $_data['post']['image_url'] ?>" /></a>
        </div>
        
        <div class="postOrigin"> Posted from <?= $_data['post']['domain'] ?> on <?= $created[0] ?></div>
       	
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
	var thePostGrid = new postDetailGrid();
<? endif ?>

$('.socialize').bind('click', pplFinder.start);
</script>

<?
if (!isset($_GET['ajax'])) {
	include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
}
?>