<?php if(IS_LOGGED_IN): ?>
<?
	function getNew($array){
		$x = 0;
		foreach($array as $ar){
			if(is_array($ar) && $ar['read'] == NULL){
				$x++;
			}
		}
		return $x;
	}
	function getUrl($id){
		if($id != ''){
			$params = array(
				'posting_id' => $id
			);
		
			$data = api_call('posting', 'get_post', $params, true);
			$ret = $data['data']['image_url'];
		}else{
			$ret = NULL;
		}
		return $ret;
	}
	
	if( empty($_SESSION['user']['user_id']) ){
		die();
	}
	$params = array(
			'user_id' => $_SESSION['user']['user_id'],
		);
	
	$calls = array(
		'get_grouped_log' => array(
			'user_id' => $_SESSION['user']['user_id']
			, 'api_website_id' => 2
		)
	);
	
	$g_data = api_request('activity_log', $calls, true);
	
	$categories['comments'] = $g_data['data']['get_grouped_log']['data']['comments'];
	$categories['comments']['title'] = 'Comments';
	$categories['comments']['img_src'] = 'small_comment.png';
	$categories['comments']['statement'] = 'SAYS';
	
	$categories['likes'] = $g_data['data']['get_grouped_log']['data']['likes'];
	$categories['likes']['title'] = 'Likes';
	$categories['likes']['img_src'] = 'small_heart.png';
	$categories['likes']['statement'] = "LIKES ONE OF YOUR IMAGES";
	
	$categories['followers'] = $g_data['data']['get_grouped_log']['data']['followers'];
	$categories['followers']['title'] = 'Followers';
	$categories['followers']['img_src'] = 'small_followers.png';
	$categories['followers']['statement'] = 'IS NOW FOLLOWING YOU';
	
	$categories['posts'] = $g_data['data']['get_grouped_log']['data']['posts'];
	$categories['posts']['title'] = 'Posts';
	$categories['posts']['img_src'] = 'small_posts.png';
	$categories['posts']['statement'] = 'ONE OF YOUR POSTS HAS WON!';
	
	
	if (IS_LOGGED_IN) {
		$params['viewer_user_id'] = $_SESSION['user']['user_id'];
	}
	$user = api_call('user', 'get_user', $params, true);
	$user = $user['data'];
	
	$menu = array(	array('title' => 'RANK', 'img' => 'icon_rank.png', 'stat' => $user['rank'], 'new' => NULL), 
					array('title' => 'POINTS', 'img' => 'icon_points.png', 'stat' => $user['points'], 'new' => NULL), 
					array('title' => 'POSTS', 'img' => 'icon_posts.png', 'stat' => NULL, 'new' => getNew($categories['posts']) ), 
					array('title' => 'COMMENTS', 'img' => 'icon_comments.png', 'stat' => NULL, 'new' => getNew($categories['comments']) ), 
					array('title' => 'LIKES', 'img' => 'icon_likes.png', 'stat' => NULL, 'new' => getNew($categories['likes']) ), 
					array('title' => 'FOLLOWERS', 'img' => 'icon_followers.png', 'stat' => NULL, 'new' => getNew($categories['followers']) )
				);
?>

<style>
	#activityPage{display:none; position:fixed; width:100%; height:100%; background-color:rgb(230, 230, 230);; z-index:100000003; top:0px; left:0px; overflow: scroll;}
	#activityPage .Header{width:100%; height:45px; background-color:white; opacity:.9;}
	#activityPage .Header img{height: 65%;margin-top: 2%;margin-left: 2%;}

	#activityPage .titleBar{width:100%; height:35px; background-color:white; color:#858585; text-align:center;font-size: 1.7em;padding-top: 10px;margin-top: 2px;}
	#activityPage .activity-menu{ height:45px; width:100%; float: left; margin-top: 2px; margin-left:20%;}
	#activityPage .activity-menu-icon{height: 90%;width: 45px;background-size: auto 100%;background-repeat: no-repeat;margin-left: 1%;float: left;margin-top: 1px;}
	#activityPage .activity-menu-title{float: left;padding-top: 2%;font-weight: lighter;color: rgb(78, 78, 78);font-size: 1.5em;font-family: Helvetica, sans-serif;}
	#main-activity-menu{margin-top: 5%; position:relative;}
	.new-bubs{background-color: #f54c6d;float: left;color: white;padding: 3px 6px;border-radius: .6em;margin-left: 20px;margin-top: 2%;}
	
	.activity-sub-section{position:absolute; width:100%; left:100%; color:rgb(24, 24, 24);;overflow: scroll; display:none;}
	.note-detail{display:none;width: 98%;float: left;height: 75px;padding-left: 2%;}
	.close-me{position: absolute;right: 0px;width: 5%;}
	.notification{float: left;width: 100%;height: 35px;font-size: .8em;background-color: white;margin-bottom: 1%;}
	.open-me{float: left;width: 94%;height: 100%;}
	.note-timestamp{float:right;padding-top: 10px;}
	.note-content{float:left; width:80%; height:100%;overflow: hidden;margin-top: 3%; white-space:nowrap;}
	.on{background-image: url(/images/new_msg_on.png);}
	.off{background-image: url(/images/new_msg_off.png);}
	.notification-light{background-repeat: no-repeat;background-size: 100% auto;float: left;height: 100%;width: 6%;position: relative;margin-top: 1%;}
	.notification-title{height: 35px;width: 100%;border-bottom: 1px solid black;}
	.notification-title img{ float: left;height: 80%;margin-top: 4px;margin-right: 1%;margin-left: 1%;}
	.title-bar-title{padding-top: 9px;font-size: 1.2em;font-weight: bold;margin-left: 7%; font-family:Arial, Helvetica, sans-serif;}
	#activityPage .avatar-frame{width: 25%;overflow: hidden;float: left;height: 100%;}
	#activityPage .avatar-frame img{width:100%;}
	.note-detail-content a{color:#fff !important;}
	.note-detail-content{width: 45%;height: 100%;float: left;padding-top: 10px;text-align: center;}
</style>

<div id="activityPage">
	<div class="Header"><img id="backButt" src="/mobile/images/back.png"><div style="position: absolute; right: 0px;top: 0px;margin-top: 9px;font-size: 23px;font-weight: lighter;margin-right: 20px;color: rgb(53, 53, 53);">Notification Center</div></div>
    
    <div id="main-activity-menu">
		<? foreach($menu as $item): ?>
        	<div id="activity-menu-<?= $item['title'] ?>" class="activity-menu cursor <?= ( !is_null($item['new']) ? 'highlightable' : '') ?>" data-title="<?= $item['title'] ?>">
            	<div class="activity-menu-icon" style="background-image: url(/images/<?= $item['img'] ?>)">
                </div>
                <div class="activity-menu-title">
                	<?= $item['title'] ?>
                    <span><?= $item['stat'] ?></span>
                </div>
                 <? if($item['new'] && $item['new'] > 0): ?>
                    <div class="new-bubs"><p id="new-count-<?= $item['title'] ?>"><?= $item['new'] ?></p></div>
                <? endif ?>
            </div>
		<? endforeach ?>
    </div>
    <? foreach($categories as $category): ?>
        <div id="sub-cat-<?= strtoupper($category['title']) ?>" class="activity-sub-section">
            <div class="notification-title">
                <img src="/images/<?= $category['img_src'] ?>" />
                <div class="title-bar-title"><?= $category['title'] ?></div>
             </div>
            <? foreach($category as $message): ?>
				<?php if($message['read'] == NULL): ?>
                <? $date = explode(" ", $message['created']) ?>
                <? $img_url = getUrl( (!empty($message['posting_id']) ? $message['posting_id'] : '') ) ?>
                    <div id="note-<?= $message['activity_log_id'] ?>" data-read="false" data-id="<?= $message['activity_log_id'] ?>" data-cat="<?= strtoupper($category['title']) ?>" class="notification">
                        <div class="open-me" data-id="<?= $message['activity_log_id'] ?>" data-cat="<?= strtoupper($category['title']) ?>">
                            <div id="light-<?= $message['activity_log_id'] ?>" class="notification-light on"></div>
                            <div class="note-content"><?= $message['username'].' '.$category['statement'].' '.(!empty($message['comment']) ? $message['comment'] : "") ?></div>
                            <div class="note-timestamp"><?= $date[0] ?></div>
                        </div>
                        <img class="close-me" src="/images/x_light.png" data-cat="<?= strtoupper($category['title']) ?>" data-id="<?= $message['activity_log_id'] ?>">
                    </div>
                    <div id="note-detail-<?= $message['activity_log_id'] ?>" class="note-detail">                     
                        <div class="avatar-frame">
                            <a href="/<?= $message['username'] ?>"><img src="http://www.dahliawolf.com/avatar.php?user_id=<?= $message['user_id'] ?>&width=150"></a>
                        </div>
                        <div class="note-detail-content">
                            <div class="note-activity">
                                <a href="http://www.dahliawolf.com/<?= $message['username'] ?>"><?= $message['username'] ?></a>
                                <?= $category['statement'].' '.(!empty($message['comment']) ? $message['comment'] : "") ?></div>
                        </div>
                        <?php if($img_url != "" && isset($img_url) ): ?>
                        <div class="avatar-frame">
                            <a href="/post/<?= $message['posting_id'] ?>"><img src="<?= $img_url ?>&width=50" /></a>
                        </div>
                        <? endif ?>
                    </div>	
                <? endif ?>
            <? endforeach ?>
         </div>
    <? endforeach ?>
</div>
<? endif ?>
<script>
	var theLog = new Object();
	theLog.atHome = true;
	theLog.slideSpeed = 200;
	theLog.homePage = $('#main-activity-menu');
	theLog.isAvailable = true;
	theLog.activeSection = null;
	theLog.me = $('#activityPage');
	
	theLog.showMe = function(){
		theLog.me.show();
		
		$('#view-port').animate({left: '-'+100+'%'}, theLog.slideSpeed);
		theLog.me.animate({left:0}, theLog.slideSpeed, function(){
			theLog.isAvailable = true;
		});
	}
	
	theLog.shutDown = function(){
		$('#view-port').animate({left: 0}, theLog.slideSpeed);
		theLog.me.animate({left: 100+'%'}, theLog.slideSpeed, function(){
			theLog.me.hide();
		});
	}
	
	theLog.goBack = function(){
		if(!theLog.atHome){
			theLog.activeSection.animate({left:100+'%'}, theLog.slideSpeed, function(){
				theLog.activeSection.hide();
			});
			theLog.homePage.animate({left:0}, theLog.slideSpeed);
			theLog.atHome = true;
		}else if(theLog.atHome){
			theLog.shutDown();
		}
	}
	
	theLog.removeNote = function(id){
		$('#note-detail-'+id).slideUp(100, function(){
			$('#note-'+id).slideUp(200, function(){
				$('#note-'+id).remove();
				$('#note-detail-'+id).remove();
			});
		});
	}
	
	theLog.toggleLight = function(id){
		$('#light-'+id).removeClass('on').addClass('off');
	}
	
	theLog.markAsRead = function(id, cat, remove){
		if(id && id > 0 && theUser.id && theLog.isAvailable){
			theLog.isAvailable = false;
			URL = '/action/markasread.php?user_id='+theUser.id+'&activity_log_id='+id;
			$.ajax(URL).done(function(){
				theLog.isAvailable = true;
				if( $('#note-'+id).data('read') == false ){
					//newCounts.update(cat);
					$('#note-'+id).data('read', true)
				}
				if(remove){
					theLog.removeNote(id);
				}else{
					theLog.toggleLight(id);
				}
			})
		}
	}
	
	theLog.openMessage = function(){
		id = parseInt( $(this).data('id') );
		cat = $(this).data('cat');
		read = $('#note-'+id).data('read');
		message = $('#note-detail-'+id);
		if( !message.is(':visible') ){
			message.slideDown(200);
			if(!read){
				theLog.markAsRead(id, cat, false);
			}
		}else{
			message.slideUp(200, function(){
				//
			});
		}
	}
	
	theLog.init = function(){
		$('.activity-menu').bind('click', theLog.showSub);
		$('.open-me').on('mousedown, click', theLog.openMessage);
		$('.close-me').on('mousedown, click', function(){
			id = parseInt( $(this).data('id') );
			cat = $(this).data('cat');
			theLog.markAsRead(id, cat, true);
		});
		$('#backButt').on('mousedown, click', theLog.goBack);
	}
	
	theLog.hideHome = function(){
		theLog.homePage.animate({left: '-'+100+'%'}, theLog.slideSpeed,function(){
			theLog.atHome = false;
		});
	}
	
	theLog.showSub = function(){
		cat = $(this).data('title');
		outlet = $('#sub-cat-'+cat);
		theLog.activeSection = outlet;
		if(theLog.atHome){
			theLog.hideHome();
		}
		outlet.show();
		outlet.animate({left:0}, theLog.slideSpeed, function(){
			//
		});
	}
	
	theLog.init();
</script>
