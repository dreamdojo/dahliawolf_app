<?php
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
	
	$pageTitle = "Activity";
	include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
	include "header.php";
	if( empty($_SESSION['user']['user_id']) ){
		die();
	}

    $url = 'http://dev.dahliawolf.com/api/1-0/activity_log.json?&function=get_last_activity&user_id='.$_SESSION['user']['user_id'].'&use_hmac_check=0';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);

    $result = $result->data->get_last_activity->data;

    $categories = array();
    $categories['messages'] = $result->messages;
    $categories['comments'] = $result->comments;
	$categories['likes'] = $result->likes;
	$categories['followers'] = $result->followers;
?>
<style>
    #messageCol{border-top: #F03E63 30px solid; margin-top: 20px;}
    #catHeader{width: 100%; display: inline-block; margin: 50px 180px;}
    #catHeader li{width: 85px;float: left; margin-left:50px; height: 85px;line-height: 200px; text-transform:capitalize; text-align: center;
        font-size: 16px; position: relative; background-size: auto 100%; background-repeat: no-repeat; background-image: url("/images/activityIcons.png"); cursor: pointer;}
    #catHeader li .count{position: absolute; right: 0px; top: 0px; border: #fff 3px solid; border-radius: 20px; height: 20px; width: 20px;
        color: #fff; background-color: #F03E63;font-size: 9px;text-align: center;line-height: 20px;}
    .activityLog{width: 100%;height: 95px;line-height: 85px;padding-top: 10px;}
    .activityLog li{float: left;}
    #messageCol ul:nth-child(even){background-color: #f5f6f8;}
    #messageCol .message a{margin-left: 10px; color: #F03E63;}
    #messageCol .date{margin-right: 10px;}
    #messageCol .postImg{height: 85px;width: 85px;background-position: 50%;background-size: auto 100%;background-repeat: no-repeat;}
    .act-comments{background-position: -348px;}
    .comments_on{background-position: -929px;}
    .act-likes{background-position: -464px;}
    .likes_on{background-position: -1045px;}
    .act-messages{background-position: -232px;}
    .messages_on{background-position: -813px;}
    .followers_on{background-position: -581px;}
    #messageCol h2{width: 100%;text-align: center;margin-top: 20px;font-size: 18px;}
</style>

<div class="mainCol">
     <ul id="catHeader">
        <? foreach($categories as $title=>$category): ?>
            <li data-cat="<?= $title ?>" class="act-<?= $title ?>">
                <div class="count"><?= count($category) ?></div>
                <?= $title ?>
            </li>
        <? endforeach ?>
     </ul>
    <div id="messageCol">
    </div>
</div>

<script>
    $(function() {
        var that = this;
        var $view = $('#messageCol');

        $.each(<?= json_encode($categories['messages']) ?>, function(x, act) {
            $('#messageCol').append(new activity(act));
        });
        $.each(<?= json_encode($categories['likes']) ?>, function(x, act) {
            $('#messageCol').append(new activity(act));
        });
        $.each(<?= json_encode($categories['comments']) ?>, function(x, act) {
            $('#messageCol').append(new activity(act));
        });
        $.each(<?= json_encode($categories['followers']) ?>, function(x, act) {
            $('#messageCol').append(new activity(act));
        });

        if(!$('.activityLog').length) {
            $view.append('<h2>No new activity for you</h2>');
        }


        $('#catHeader').on('click', 'li', function() { //THIS IS BOOOOTY PLEASE FIX
            var cat = $(this).data('cat');
            $('.comments_on').removeClass('comments_on');
            $('.messages_on').removeClass('messages_on');
            $('.followers_on').removeClass('followers_on');
            $('.likes_on').removeClass('likes_on')
            $(this).addClass(cat+'_on');
            $view.empty();
            dahliawolf.loader.show();
            dahliawolf.activity.getCategory($(this).data('cat'), function(data){
                dahliawolf.loader.hide();
                if(data.data.get_by_type.length) {
                    $.each(data.data.get_by_type, function(x, msg) {
                        $view.append(new activity(msg));
                    });
                } else {
                    $view.append('<h2>No activity found for '+cat+'</h2>');
                }

            });
        });

    });

    function activity(data) {

        console.log(data);

        var $view = $('<ul class="activityLog"></ul>');
        var $avatar = $('<ul class="postDetailAvatarFrame avatarShutters" style="background-image: url(\''+data.avatar+'&width=100\')">');
        $('<li id="postDetailFollowButton">Follow</li>').appendTo($avatar).on('click', function() {

        });
        $('<li><a href="'+data.username+'" rel="message">Message</a></li>').appendTo($avatar).on('click', function() {

        });
        $('<li><a href="/'+data.username+'">Profile</a></li>').appendTo($avatar);
        $avatar.appendTo($view);

        switch(data.entity) {
            case 'follow' :
                var $message = $('<li class="message"><a href="/'+data.username+'">'+data.username+'</a> is now following you</li>').appendTo($view);
                break;
            case 'posting_like' :
                var $message = $('<li class="message"><a href="/'+data.username+'">'+data.username+'</a> liked your post</li>').appendTo($view);
                //var $post = $('<li class="postImg"></li>').css('background-image', 'url("'+data.image_url+'&width=85")').appendTo($view);
                break;
            case 'message' :
                var $message = $('<li class="message"><a href="/'+data.username+'">'+data.username+'</a> says '+socialize(data.body)+'</li>').appendTo($view);
                break;
            case 'comment' :
                var $message = $('<li class="message"><a href="/'+data.username+'">'+data.username+'</a> says '+socialize(data.comment)+'</li>').appendTo($view);
                break;
            case 'sale' :
                var $message = $('<li class="message"><a href="/'+data.username+'">'+data.username+'</a> purchased your product</li>').appendTo($view);
                break;
        }
        var $data = $('<li class="date">'+data.created+'</li>').css('float', 'right').appendTo($view);

        return $view;
    }

    activity.prototype = {
        get getDate() {return '';},
        get getMessage() {return '';}
    }
</script>
