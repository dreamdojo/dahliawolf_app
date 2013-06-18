<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Profile - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}

?>
<style>
.prof-sect{ width: 100%;
min-width: 100%;
height: 100px;
margin-top: 5px;
overflow: hidden;}
.prof-sect .left-col{width:35%; float:left; max-height:175px; overflow:hidden;}
.prof-sect .left-col img{width:100%;}
.prof-sect .right-col{width: 38%;float: left; color:#8a8a8a; padding-left:2%;height: 100%;}
.prof-sect .middle-col .p-tit{font-size: 2em;
font-weight: lighter;
color: rgb(60, 60, 60);}
.dahlia{color:#ac4759; font-weight:bold;padding-bottom: 5px;}
.edit-butt{background-color:#898989;padding: 1% 0% 1% 0%;width: 36%;text-align: center;font-weight: bold;font-size: 1.2em;}
.prof-sect .middle-col{width:20%; float:left; height:100%;padding-left: 1%;}
.middle-col li{padding-bottom: 4px;}
.p-img-frame{float:left;width: 22.75%;height: 100%;overflow: hidden; margin-right:1%;}
.p-img-frame img{width:100%;}
.p-row{width: 100%;margin-left: 3%;height: 100px; margin-top:5px;}
.butts{height:40px; width:30%; float:left; margin-left:2%;color:#8a8a8a;}
.butts p{padding-top: 13px; text-align: center;}
.b-links{margin-top: 20px;}
.butty-bg{background-color:white; background-size:100% 100%;}
.t-butts{width: 35%;margin-right: 20px;
text-align: center;
padding-top: 5px;
padding-bottom: 5px;
padding-left: 10px;
float: right;
border: 1px solid #e74867;
padding-right: 10px;}
.t-butts a{ color:#8a8a8a !important;}
#follower-info-section{ height:30px; width:100%;margin-top: 5px;}
.follow-box{ border:#5b5b5c thin solid; border-radius:.2em; width:48%; height:100%;float: left; color:#5b5b5c; margin-right:1%;}
.follow-box p{margin-top: 5px;margin-left: 2%;}
#statRow{ width:100%; height:80px;margin-top: 5px;}
#statRow .profStat{width:24%; float:left; height:100%; background-color:#fff; margin-right:1%;}
.profSectTitle{ width:94%; margin-top:5px; background-color:white; margin-left:3%; color:gray;height: 20px;}
.profSectTitle p{padding-top: 2.5px;margin-left: 3%;}
.profStatTitle{height:50%; background-color:white; width:100%;}
.profStatNumber{width:100%; height:50%; text-align:center;}
.profStatNumber p{color:#a1a1a1; padding-top:10px; font-size:1.5em;}
#profStatRank{ background-image:url(/mobile/images/nakedRank.png); background-size:auto 75%; background-position:center; background-repeat:no-repeat;}
#profStatPosts{ background-image:url(/mobile/images/nakedPosts.png); background-size:auto 75%; background-position:center; background-repeat:no-repeat;}
#profStatLoves{ background-image:url(/mobile/images/nakedLoves.png); background-size:auto 75%; background-position:center; background-repeat:no-repeat;}
#profStatPoints{ background-image:url(/mobile/images/nakedPoints.png); background-size:auto 75%; background-position:center; background-repeat:no-repeat;}
.prof-sect h3{color:#959595 !important;}
</style>

<? //var_dump($_data) ?>
<div class="feed-wrap">
    <div class="prof-sect">
    	<div class="left-col">
			<img alt="<?= $_SESSION['user']['username'] ?>" src="<?= $_data['user']['avatar'] ?>"/> 
        </div>
        <div class="middle-col">
			<ul>
            	<li>
                	<div class="p-tit"><?= $_data['user']['username'] ?></div>
                </li>
                <li>
            		<h3><?= $_data['user']['location'] ?></h3>
                </li>
            </ul>
       </div>
       <div class="right-col">
       	<? if (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] == $_data['user']['user_id']): ?>
    			<div class="butty-bg t-butts"><a href="/mobile/account/settings.php?session_type=<?= $_GET['session_type'] ?>">EDIT</a></div>
    		<? endif ?>
			
			<? if(!empty($_SESSION['user']) && $_SESSION['user']['user_id'] != $_data['user']['user_id']): ?>
				<? $is_followed = !empty($_data['user']['is_followed']) ?>
				
                <div class="sysBoardFollowAllButton butty-bg t-butts<?= $is_followed ? ' hidden' : '' ?>" id="FADD97">
                    <a href="/action/follow.php?user_id=<?= $_data['user']['user_id'] ?>&session_type=<?= $_GET['session_type'] ?>" class="Button12 Button OrangeButton" rel="follow">
                        <strong>Follow</strong><span></span>
                    </a>
				</div>            
                <div class="sysBoardUnFollowAllButton butty-bg t-butts<?= !$is_followed ? ' hidden' : '' ?>" id="FREM97">
                    <a href="/action/unfollow.php?user_id=<?= $_data['user']['user_id'] ?>&session_type=<?= $_GET['session_type'] ?>" class="Button12 Button OrangeButton disabled" rel="unfollow">
                        <strong>Unfollow</strong><span></span>
                    </a>
                </div>
			<? endif ?>
       </div>
   </div>
   
   	<div id="statRow">
   		<div class="profStat">
    		<div id="profStatRank" class="profStatTitle"></div>
            <div class="profStatNumber"><p><?= $_data['user']['rank'] ?></p></div>
        </div>
        <div class="profStat">
    		<div id="profStatPosts" class="profStatTitle"></div>
            <div class="profStatNumber"><p></p></div>
        </div>
        <div class="profStat">
    		<div id="profStatLoves" class="profStatTitle"></div>
            <div class="profStatNumber"><p></p></div>
        </div>
        <div  class="profStat">
    		<div id="profStatPoints" class="profStatTitle"></div>
            <div class="profStatNumber"><p><?= number_format($_data['user']['points']) ?></p></div>
        </div>
   	</div>
    <div class="profSectTitle"><p>LOVES</p></div>
    <div class="prof-wilds p-row">
    <a href="account/wild-4s.php?session_type=web">
        <? for($x = 4;$x<8;$x++): ?>
            <div  class="p-img-frame">
                <img src="<?= $_data['posts'][$x]['image_url'] ?>" />
            </div>
        <? endfor ?>
    </div>
    </a>
   	
    <div class="profSectTitle"><p>POSTS</p></div>
    <div class="prof-posts p-row">
   	<a href="account/posts.php?session_type=web">
        <? for($x = 0;$x<4;$x++): ?>
            <div  class="p-img-frame">
                <img src="<?= $_data['posts'][$x]['image_url'] ?>" />
            </div>
        <? endfor ?>
   </div>
   </a>
   
   <div class="b-links">
   		<a href="following.php?username=<?= $_data['user']['username'] ?>">
        	<div class="butts butty-bg"><p>FOLLOWING</p></div>
        </a>
    	<a href="followers.php?username=<?= $_data['user']['username'] ?>">
        	<div class="butts butty-bg"><p>FOLLOWERS</p></div>
        </a>
        <a href="/mobile/my-runway.php?username=<?= $_SESSION['user']['username'] ?>&session_type=<?= $_GET['session_type']?>">
        	<div class="butts butty-bg"><p>SHOWROOM</p></div>
        </a>
   </div>	
</div>

<? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>