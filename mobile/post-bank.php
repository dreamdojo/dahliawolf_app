<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Post Bank - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	if(!IS_LOGGED_IN){ header( 'Location: login.php?session_type=web' ); }
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
if(isset($_SESSION['guide_post']) && $_SESSION['guide_post']){
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/guide_pop.php";
	$_SESSION['guide_post'] = false;
}

?>

<style>
.pb-frame{width: 99%; min-height:200px; float: left;position: relative;overflow: hidden; background-color:#fff; background-image: url(images/loading3.gif);background-repeat:no-repeat;background-size: 50% auto;background-position: center; text-align:center; margin-right: 1%; position:relative; background-color: #ebebeb;}
.post-mode{height:99%;}
.pb-frame img{ width:90%; margin-top:10px; margin-bottom:10px; position:relative; }
.pb-odd{margin-right: 1.5%;}
.pb-lb{position:absolute; width:50px; height:50px; bottom:0px; left:0px; background-color:#1e1e1e; background-image:url(images/heart_bg.png); background-size:100% 100%;}
.lb-num{margin-left: -7px;color: #fff;margin-top: 13px; text-align:center;}
#upload-img-box{background-color:#3d4041; background-image: url(images/loading3.gif);background-repeat:no-repeat;background-size: 50% auto;background-position: center; text-align:center;}
.animate-me{transform: translate3d(0,0,0); -webkit-transform: translate3d(0,0,0);transition: height .5s, bottom 1s,  transform .5s; -webkit-transition: height .5s, bottom 1s, -webkit-transform .5s;}

#feed-wrap{width: 99%;height: 100%;margin-left: 1%;}

.post-box{background-color: rgb(0, 0, 0);height: 35%;position: absolute;bottom: -41%;width: 100%;opacity: .95;}
.post-box-post-mode{ bottom:0%;}
.pop-com{width: 91%;margin-top: 5%;height: 12%;font-size: 1em;padding-top: 1.1%;text-indent: 1.8em;}
#sub-pop-butt{border: none;cursor: pointer;width: 36.5%; background-color:#F00; margin-top: 4%;}
</style>

<div id="feed-wrap">
</div>

<? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>

<script type="text/javascript" src="js/feeder.js"></script>
<script type="text/javascript" src="js/scroller.js"></script>
<script>
var postItem = new Object();
postItem.isOpen = new Array();
postItem.currentId = 0;
postItem.slideUpSpeed = 300;
postItem.itemHeight = 40;

postItem.post = post;
postItem.showMe = piShow;
postItem.hideMe = piHide;
postItem.getPostBox = getPostBox;
postItem.postImage = postImage;
postItem.completePost = completePost;
postItem.centerImage = centerImage;

function centerImage(id){
	document.location = '#post-image-'+id;
}

function completePost(id){
	$('#theMess').empty().html('Image Has Been Posted');
	$('#alert-box').fadeIn(400, function(){
		setTimeout(function(){
			$('#alert-box').fadeOut(10);
		}, 200);
	});
	setTimeout(function(){
		$('#imgFrame-'+id).slideUp(postItem.slideUpSpeed, function(){
			$('#imgFrame-'+id).remove();
		});
	}, 600);
}

function getPostBox(id){
	if(id){
		return $('#post-box-'+id);
	}else{
		console.log('error: NO ID ENTERED WHEN GETTING POST ITEM')
	}
}

function piHide(id){
	theItem = postItem.getPostBox(id);
	//$('#imgFrame-'+id).removeClass('post-mode');
	//theItem.removeClass('post-box-post-mode');
	theItem.animate({bottom:'-'+41+'%'}, 200, function(){
		$('#imgFrame-'+id).css('height', 'auto');
		postItem.isOpen[id] = false;
	});
}

function piShow(id){
	if(!postItem.isOpen[id]){
		theBox = postItem.getPostBox(id);
		postItem.centerImage(id);
		//$('#imgFrame-'+id).addClass('post-mode');
		//theBox.addClass('post-box-post-mode');
		$('#imgFrame-'+id).animate({height:window.innerHeight+'px'}, 200, function(){
			theBox.animate({bottom:0+'%'}, 200, function(){
				postItem.isOpen[id] = true;
			});
		});
	}else{
		postItem.hideMe(id);
	}
}

function postImage(id, descr){
	description = descr;
	console.log(id + ' ' + descr);
	if(id != null && id > 0){
		$.post('../action/post_feed_image.php', { id: id, description: description});
		postItem.completePost(id);
	}
}


theFeed.init('bank', $('#feed-wrap'), 10);
scroller.Init('pb-frame', 1);
</script>