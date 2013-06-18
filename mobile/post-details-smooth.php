<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Post Details - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}

$params = array(
	'posting_id' => $_data['post']['previous_posting_id'],
	'viewer_user_id' => $_SESSION['user']['user_id']
);

$data_next = api_call('posting', 'get_post', $params, true);
$data_next['post'] = $data_next['data'];

?>
<style>
#screen-frame{ position:absolute; height: 72%; width:90%; left:5%;}
.outside-frame{ background-color: #FFF;width: 98%;height: 98%;margin: 0px auto; margin-top:2%; border-radius: .5em; position:absolute;}
.inside-frame{ width:98%; margin:0px auto; height:87%; overflow:hidden; padding-top: 1%; background-image: url(images/loading3.gif);background-repeat:no-repeat;background-size: 50% auto;background-position: center; text-align:center;}
.post-deets{height:11%;width: 98%;padding-top: 1%;margin: 0px auto;}
.deets-half{width: 49%;float: left;text-align: center; color:rgb(109, 109, 109); font-size: 1.4em; background-color:#f3f3f3; height:90%; overflow:hidden;}
.hearts{margin-top:40%;}
#hotornot{ height: 12%;width: 98%;margin: 0px auto;position: absolute;bottom: 15%;}
.vote-sect{width:50%; float:left; height:100%;}
#vote-sect-yes{background-image: url(images/vote-light-yes-off.png); background-repeat:no-repeat;background-size: auto 100%;}
#vote-sect-no{background-image: url(images/vote-light-no-off.png); background-repeat:no-repeat;background-size: auto 100%; background-position-x: 100%;}
#hearts{height: 75%;width: 35%;margin: 0px auto;padding-top: 2%;}
.heart-pic{background-image:url(images/wild-at-heart.png); background-repeat:no-repeat; background-size:100% 100%; float:left;height: 100%;width: 55%;}
#hearts span{float: left;margin-left: 4%;margin-top: 7%;}
#posty-avatar{background-image:url(images/posty_avatar.png); background-repeat:no-repeat; background-size:100% 100%; float:left;height: 100%;width: 25%;}
#poster{height: 75%;width: 58%;margin-left: 6px;padding-top: 3%;}
#post-name{font-size: .7em;width: 57%; float: left;margin-top: 6%;}
.active{z-index: 1000002;}
.next{z-index:1000001;}
.tall{height:100%;}
.wide{width:100%;}
.vote-pop{margin-top: 0%; position:absolute;width: 46%; height: 42%; z-index:1000000000; display:none;}
.vote-not{background-image:url(images/leave.png); background-size:100% auto; margin-left: 52%;background-repeat: no-repeat;}
.vote-hot{background-image:url(images/love.png); background-size:100% auto;background-repeat: no-repeat;}
.stack{z-index: 1000003; position:relative;}
.popup-description{position: absolute;width: 100%;top: 80%;color: #fff;font-size: 1.2em; text-align:center;}
.popup-button-box{position: absolute;height: 13%;width: 100%;background-color: #000;opacity: .7;bottom: 0px; z-index:10000;}
.popup-button{ border-top:#fff .1em solid;color: #fff;float: left;width: 49%;position: relative; font-size:1.2em; height:100%;}
.popup-button p{margin-top: 10%;}
.loveit{color:#98de8e;}
.leaveit{color:#fa817d;border-right:#c2c2c2 .1em solid;}

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
#left-border{position:absolute;height: 98%;left: -3.5%;bottom: 0px;width: 5%; z-index:1;}
#bottom-border{position:absolute;bottom: -3%;left: -3.5%;width: 100%; z-index:1;}
</style>

<? //var_dump($_data['post']); ?> 
<div id="blackOut"></div>

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
    <img id="bottom-border" src="images/bottom-border.png" />
    
    <div class="outside-frame active" id="swipe-me-<?= $_data['post']['posting_id'] ?>">
    	<div id="vote-not-<?= $_data['post']['posting_id'] ?>" class="vote-pop vote-not"></div>
		<div id="vote-hot-<?= $_data['post']['posting_id'] ?>" class="vote-pop vote-hot"></div>
        
        <div class="inside-frame">
            <img id="image-<?= $_data['post']['posting_id'] ?>" class="stack wide" src="<?= $_data['post']['source'] . $_data['post']['imagename'] ?>" />
        </div>
        <div class="post-deets">
        	<div class="deets-half">
                <div id="hearts">
                	<div class="heart-pic"></div>
                    <span><?= $_data['post']['likes'] ?></span>
                </div>
            </div>
            <div class="deets-half" style="margin-left:1%;width: 49.5%;">
            	<div id="poster">
                	<div id="posty-avatar">
                    </div>
                    <div id="post-name">
                    	<?= $_data['post']['username'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <div class="outside-frame next" id="swipe-me-<?= $data_next['post']['posting_id'] ?>">
    	<div id="vote-not-<?= $data_next['post']['posting_id'] ?>" class="vote-pop vote-not"></div>
		<div id="vote-hot-<?= $data_next['post']['posting_id'] ?>" class="vote-pop vote-hot"></div>
        
        <div class="inside-frame">
            <img id="image-<?= $data_next['post']['posting_id'] ?>" class="stack wide" src="<?= $data_next['post']['source'] . $data_next['post']['imagename'] ?>" />
        </div>
        <div class="post-deets">
        	<div class="deets-half">
                <div id="hearts">
                	<div class="heart-pic"></div>
                    <span><?= $data_next['post']['likes'] ?></span>
                </div>
            </div>
            <div class="deets-half" style="margin-left:1%;width: 49.5%;">
            	<div id="poster">
                	<div id="posty-avatar">
                    </div>
                    <div id="post-name">
                    	<?= $data_next['post']['username'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.event.move.js"></script>
<script src="js/twerkin.js"></script>
<script>
$(document).bind('touchmove', function(e) {
    e.preventDefault();
});


twerkin.init('action/getBankDetail.php', parseInt('<?= $_data['post']['posting_id'] ?>'), parseInt('<?= $_data['post']['previous_posting_id'] ?>'));

$('#back-butt').bind('click', function(){
	$('#wammy-box').hide();
});
$('#get-butt').bind('click', function(){
	goHere('explore.php');
});
</script>