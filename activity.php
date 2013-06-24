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
	
	//var_dump($categories['comments']);
	//var_dump($data);
?>

<div id="theShaft">
	<div id="leftCol">
		<? foreach($menu as $item): ?>
        	<div id="activity-menu-<?= $item['title'] ?>" class="activity-menu cursor <?= ( !is_null($item['new']) ? 'highlightable' : '') ?>" data-title="<?= $item['title'] ?>">
            	<div class="activity-menu-icon" style="background-image: url(images/<?= $item['img'] ?>)">
                </div>
                <div class="activity-menu-title">
                	<?= $item['title'] ?>
                    <span><?= $item['stat'] ?></span>
                    <? if($item['new'] && $item['new'] > 0): ?>
                    	<div class="new-bubs"><p id="new-count-<?= $item['title'] ?>"><?= $item['new'] ?></p></div>
                    <? endif ?>
                </div>
            </div>
		<? endforeach ?>
    </div>
    <div id="mainCol">
    	<? foreach($categories as $category): ?>
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
                            <div class="content"><?= $message['username'].' '.$category['statement'].' '.(!empty($message['comment']) ? $message['comment'] : "") ?></div>
                            <div class="note-timestamp"><?= $date[0] ?></div>
                        </div>
                        <img class="close-me" src="images/x_light.png" data-cat="<?= strtoupper($category['title']) ?>" data-id="<?= $message['activity_log_id'] ?>">
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
                        	<a href="/post/<?= $message['posting_id'] ?>"><img src="<?= $img_url ?>&width=150" /></a>
                        </div>
                        <? endif ?>
                    </div>	
                <? endif ?>
            <? endforeach ?>
      	<? endforeach ?>
    </div>
	<div style="clear:both"></div>
</div>

<?php include "footer.php" ?>
<script>
var messages = new Object();
messages['message'] = new Array();
messages['message']['posting_like'] = "LIKES ONE OF YOUR IMAGES";
messages['message']['follow'] = 'IS NOW FOLLOWING YOU';
messages['message']['comment'] = 'SAYS';
messages['message']['posts'] = ''

messages['COMMENTS'] = <?= json_encode($categories['comments']) ?>;
messages['LIKES'] = <?= json_encode($categories['likes']) ?>;
messages['POSTS'] = <?= json_encode($categories['posts']) ?>;
messages['FOLLOWERS'] = <?= json_encode($categories['followers']) ?>;



//****************************************

var theNote = new Object();
theNote.isAvailable = true;

theNote.menuClicked = function(title){
	theNote.fillDisplay( messages[title], title );
}

theNote.fillDisplay = function(messages, cat){
	$.each(messages, function(index, message){
		theNote.displayNote(message, cat);
	});
	theNote.bindMessages();
}

theNote.displayNote = function(note, cat){
	if(typeof note == 'object'){
		date = note.created.split(' ')[0];
		str = '<div id="note-'+note.activity_log_id+'" data-read="'+(note.read ? true : false)+'" data-id="'+note.activity_log_id+'" data-cat="'+cat+'" class="notification">';
		str += '<div class="open-me" data-id="'+note.activity_log_id+'" data-cat="'+cat+'">';
		str += '<div id="light-'+note.activity_log_id+'" class="notification-light '+(note.read ? 'off' : 'on')+'"></div>';
		str += '<div class="content">'+note.username+' '+messages['message'][note.entity]+' '+(note.entity == 'comment' ? note.comment : '')+' </div>';
		str += '<div class="note-timestamp">'+date+'</div>';
		str += '</div>';
		str += '<img class="close-me" src="images/x_light.png" data-cat="'+cat+'" data-id="'+note.activity_log_id+'">';
		str += '</div>';
		str += '<div id="note-detail-'+note.activity_log_id+'" class="note-detail">';                    
		str += '<div class="avatar-frame">';
		str += '<a href="/'+note.username+'"><img src="http://www.dahliawolf.com/avatar.php?user_id='+note.user_id+'&amp;width=150"></a>';
		str += '</div>'
		str += '<div class="note-detail-content">';
		str += '<div class="note-activity">';
		str += '<a href="http://www.dahliawolf.com/'+note.username+'">'+note.username+' </a>';
		str += messages['message'][note.entity]+' '+(note.entity == 'comment' ? note.comment : '')+' </div>';
		str += '</div>';
		str += '<div class="avatar-frame">';
		str += '<a href="/post/'+note.posting_id+'"><img src="http://repository.offlinela.com/upload/image.php?imagename=b5dbab50f642bc5e8e004418de1ce548.jpg"></a>';
		str += '</div></div>';
		theNote.display.append(str);
	}
}

theNote.clearDisplay = function(){
	theNote.display.empty();
}

theNote.toggleDeets = function(){
	detail = $('#note-detail-'+parseInt($(this).data('id')));
	if( !detail.is(':visible') ){
		theNote.markAsRead(parseInt($(this).data('id')), $(this).data('cat'),  false);
		detail.slideDown(200);
	}else{
		detail.slideUp(200);
	}
}
theNote.toggleLight = function(id){
	$('#light-'+id).removeClass('on').addClass('off');
}
theNote.removeNote = function(id){
	$('#note-detail-'+id).slideUp(100, function(){
		$('#note-'+id).slideUp(200, function(){
			$('#note-'+id).remove();
			$('#note-detail-'+id).remove();
		});
	});
}
theNote.deleteNote = function(){
	id = parseInt($(this).data('id'));
	theNote.markAsRead(id, $(this).data('cat'), true);
}

theNote.markAsRead = function(id, cat, remove){
	if(id && id > 0 && theUser.id && theNote.isAvailable){
		theNote.isAvailable = false;
		URL = '/action/markasread.php?user_id='+theUser.id+'&activity_log_id='+id;
		$.ajax(URL).done(function(){
			theNote.isAvailable = true;
			if( $('#note-'+id).data('read') == false ){
				newCounts.update(cat);
				$('#note-'+id).data('read', true)
			}
			if(remove){
				theNote.removeNote(id);
			}else{
				theNote.toggleLight(id);
			}
		})
	}
}

theNote.toggleHeight = function(){
	console.log($('#theShaft').height() +' '+ $(window).height());
	if($('#theShaft').height() < $(window).height() ){
		$('#theShaft').css('height', 103+'%');
	}else{
		$('#theShaft').css('height', 'auto');
	}
}
theNote.bindMessages = function(){
	$('.open-me').bind('click', this.toggleDeets);
	$('.close-me').bind('click', this.deleteNote);
}

theNote.init = function(){
	theNote.bindMessages();
	$('.activity-menu').bind('click', function(){
		theNote.clearDisplay();
		theNote.menuClicked( $(this).data('title') );
		$('.activity-menu').removeClass('invite-selected');
		$(this).addClass('invite-selected');
		theNote.toggleHeight();
	});
	//theNote.toggleHeight();
	theNote.display = $('#mainCol');
	
}
//***************************************
var newCounts = new Object();

newCounts.init = function(){
	this.counts = new Array()
	this.counts = {	"LIKES" : parseInt( $('#new-count-LIKES').html() ),
					"COMMENTS" : parseInt( $('#new-count-COMMENTS').html() ),
					"FOLLOWERS" : parseInt( $('#new-count-FOLLOWERS').html() ),
					"POSTS" : parseInt( $('#new-count-POSTS').html() )
	};
}

newCounts.update = function(cat){
	this.counts[cat]--;
	$('#new-count-'+cat).html(this.counts[cat]);
}

//********************************************

newCounts.init();

$(function(){
	theNote.init();
});

</script>