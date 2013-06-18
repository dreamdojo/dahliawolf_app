<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Post Details - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
if(isset($_SESSION['guide_vote']) && $_SESSION['guide_vote']){
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/guide_pop.php";
	$_SESSION['guide_vote'] = false;
}

$params = array(
	'posting_id' => $_data['post']['previous_posting_id'],
	'viewer_user_id' => $_SESSION['user']['user_id']
);

$data_next = api_call('posting', 'get_post', $params, true);
$data_next['post'] = $data_next['data'];


?>
<style>
#screen-frame{ position:absolute; height: 70%; width:90%; left:5%; margin-top:2%;border: 1px solid rgb(209, 209, 209);}
.outside-frame{ width: 100%;height: 100%;margin: 0px auto;  position:absolute;}
.inside-frame{ width:100%; margin:0px auto; height:87%; overflow:hidden; background-image: url(images/loading3.gif);background-repeat:no-repeat;background-size: 50% auto;background-position: center; text-align:center;}
.post-deets{height:13%;width: 100%;padding-top: 1%;margin: 0px auto;background-color: white;}
.deets-half{width: 49%;float: left;text-align: center; color:rgb(109, 109, 109); font-size: 1.4em; background-color:#f3f3f3; height:90%; overflow:hidden;}
.hearts{margin-top:40%;}
#hotornot{ height: 12%;width: 98%;margin: 0px auto;position: absolute;bottom: 15%;}
.vote-sect{width:50%; float:left; height:100%;}
#vote-sect-yes{background-image: url(images/vote-light-yes-off.png); background-repeat:no-repeat;background-size: auto 100%;}
#vote-sect-no{background-image: url(images/vote-light-no-off.png); background-repeat:no-repeat;background-size: auto 100%; background-position-x: 100%;}
#hearts{height: 75%;width: 35%;margin: 0px auto;padding-top: 2%;}
.heart-pic{background-image:url(images/wild-at-heart.png); background-repeat:no-repeat; background-size:100% 100%; float:left;height: 100%;width: 55%;}
#hearts span{float: left;margin-left: 4%;margin-top: 7%;}
#poster{height: 75%;width: 58%;margin-left: 10%;padding-top: 3%;}
#post-name{font-size: .7em;width: 57%; float: left;margin-top: 6%;}
.active{z-index: 1000002;}
.next{z-index:1000001;}
.tall{height:100%;}
.wide{width:100%;}
.vote-pop{margin-top: 0%; position:absolute;width: 46%; height: 75%; z-index:1000000000; display:none;}
.vote-not{background-image:url(images/leave.png); background-size:100% auto; margin-left: 52%;background-repeat: no-repeat;}
.vote-hot{background-image:url(images/love.png); background-size:100% auto;background-repeat: no-repeat;}
.stack{z-index: 1000003; position:relative;}
.popup-description{position: absolute;width: 100%;top: 80%;color: #fff;font-size: 1.2em; text-align:center;}
.popup-button-box{position: absolute;height: 60px;width: 100%;opacity: .8;bottom: 5px;z-index: 10000;}
.popup-button{ color: #fff;float: left;width: 47%;position: relative; font-size:1.5em; height:100%; margin-left: 2%;}
.popup-button p{margin-top: 14%;}

.loveit{color:#FFF; background-color:#f28096;}
.leaveit{background-color:#6e6e6e; color:#FFF; }

#wammy-box{ position:fixed; top: 0px; left:0px; width:100%; height:100%; color:#e28395; z-index: 1000000000000; display:none; text-align:center;}
.wb-header{margin-top: 5%;}
.wammy-box-bg{ position:absolute; background-color:#000; opacity:.83; height:100%; width:100%; z-index: -1; margin-bottom: 5%;}
.line-one{font-size:1.5em; color:#e28395}
.line-two{font-size:1.7em; color:#e28395; font-weight:bold; margin-bottom: 3%;}
.wb-item-title{font-size:1em; color:#fff;}
.wb-img-box{width:100%; height: 47%; margin-top:5%;}
.wb-img-frame{width: 45%; height:89%; float:left; border:#fff thin solid; border-radius:.2em; overflow: hidden; margin-left: 3%; position:relative;}
.wb-img-frame-pic{ width:100%; min-height: 100%;}
.wb-butt{ background-color:#e28395; color:#FFF; text-align:center;width: 70%;margin: 0px auto;margin-bottom: 3%;padding-top: 2%;padding-bottom: 2%;border-radius: .4em;}
#back-butt{background-color:#6e7273;}
.inspire-me{position:absolute; left:0px; top:0px; width:50% !important;}
#left-border{position:absolute;height: 100%;left: -5%;bottom: 0px;width: 5%; z-index:1;}
#bottom-border{position:absolute;bottom: -4.5%;left: -3.5%;width: 103.5%; z-index:1;}

#voteOptions{position:absolute; width:100%; height:45px; background-color:white; opacity:.7; top:0px;}
#voteOptionDone{background: url(/mobile/images/deetDone.png) no-repeat;background-size: auto 100%;height: 60%;margin-top: 13px;width: 30%;float: left;position: relative;margin-left: 4%;}
#voteOptionDetail{height: 60%;margin-top: 13px;width: 30%;float: right;position: relative;margin-right: 4%;background: url(/mobile/images/deetPostDetails.png) no-repeat;background-size: auto 100%;background-position-x: 100%;}

.postUserAvatarFrame{height: 85%; margin-top:2%; margin-left: 5.5px;width: 10%; overflow:hidden; float:left;}
.postUserAvatarFrame img{width:100%;}
.postUserDeets{float: left;height: 100%; margin-top:3%; font-size: 1.2em;margin-left: 2%;color: rgb(107, 107, 107);}
.postFollowUser{float: right;
background-color: rgb(255, 255, 255);
padding: .5em 1em;
color: rgb(255, 89, 89);
margin-top: 2.4%;
margin-right: 2%;
font-size: .8em;
border: 1px solid rgb(253, 167, 167);}
</style>

<? //var_dump($_data['post']); ?> 
<div id="blackOut">
</div>

<div id="wammy-box">
	<div class="wammy-box-bg"></div>
    <div class="wb-header">
    	<div class="line-one">
        	ITEM YOU LOVE
        </div>
        <div class="line-two">
        	IS NOW IN THE STORE
        </div>
        <div class="wb-item-title">
        	THE BLUE DRESS
        </div>
    </div>
    <div class="wb-img-box">
        <div class="wb-img-frame">
        	<img class="wb-img-frame-pic" src="http://www.dahliawolf.com/import/pics/853.jpeg"/>
            <img src="images/inspiration.png" class="inspire-me" />
        </div>
        <div class="wb-img-frame">
        	<img class="wb-img-frame-pic" src="http://www.dahliawolf.com/import/pics/image.php?imagename=861.jpeg" />
        </div>
    </div>
    <div class="wb-butt-box">
    	<div class="wb-butt" id="get-butt">GET IT NOW</div>
        <div class="wb-butt" id="back-butt">BACK TO VOTING</div>
    </div>
    
</div>

<div id="screen-frame">
    
    <img id="left-border" src="images/left-border.png" />
   <!-- <img id="bottom-border" src="images/bottom-border.png" />   -->
    
    <div class="outside-frame optimize-me active" id="swipe-me-<?= $_data['post']['posting_id'] ?>">
    	<div id="vote-not-<?= $_data['post']['posting_id'] ?>" class="vote-pop vote-not"></div>
		<div id="vote-hot-<?= $_data['post']['posting_id'] ?>" class="vote-pop vote-hot"></div>
        
        <div class="inside-frame">
            <img id="image-<?= $_data['post']['posting_id'] ?>" class="stack wide" src="<?= $_data['post']['source'] . $_data['post']['imagename'] ?>" />
        </div>
        <div class="post-deets">
        	<div class="postUserAvatarFrame" onClick="goHere('profile.php?username=<?= $_data['post']['username'] ?>');" >
            	<img src="<?= $_data['post']['avatar'] ?>" />
            </div>
            <div class="postUserDeets">
            	<div clas="postUserName" onClick="goHere('profile.php?username=<?= $_data['post']['username'] ?>');" ><?= $_data['post']['username'] ?></div>
            </div>
            <div class="postFollowUser">FOLLOW</div>
        </div>
    </div>
 
    <div class="outside-frame optimize-me next" id="swipe-me-<?= $data_next['post']['posting_id'] ?>">
    	<div id="vote-not-<?= $data_next['post']['posting_id'] ?>" class="vote-pop vote-not"></div>
		<div id="vote-hot-<?= $data_next['post']['posting_id'] ?>" class="vote-pop vote-hot"></div>
        
        <div class="inside-frame">
            <img id="image-<?= $data_next['post']['posting_id'] ?>" class="stack wide" src="<?= $data_next['post']['source'] . $data_next['post']['imagename'] ?>" />
        </div>
        <div class="post-deets">
        	<div class="postUserAvatarFrame" onClick="goHere('profile.php?username=<?= $data_next['post']['username'] ?>');">
            	<img src="<?= $data_next['post']['avatar'] ?>" />
            </div>
            <div class="postUserDeets">
            	<div clas="postUserName" onClick="goHere('profile.php?username=<?= $data_next['post']['username'] ?>');"><?= $data_next['post']['username'] ?></div>
            </div>
            <div class="postFollowUser">FOLLOW</div>
        </div>
    </div>
</div>

<script src="js/jquery.event.move.js"></script>
<script src="js/twerkin.js"></script>
<script>
$('#view-port').addClass('unscrollable');

if($(window).height() < 360){
	$('body').height(120+'%');
	window.scrollTo(0, 0);
}

$(document).bind('touchmove', function(e) {
    e.preventDefault();
});


$(window).bind('load', function(){
	twerkin.init('action/getBankDetail.php', parseInt('<?= $_data['post']['posting_id'] ?>'), parseInt('<?= $_data['post']['previous_posting_id'] ?>'));
});

$('#back-butt').bind('click', function(){
	$('#wammy-box').hide();
});
$('#get-butt').bind('click', function(){
	goHere('explore.php');
});
</script>