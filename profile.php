<?
$pageTitle = "Profile";
include "head.php";
include "header.php";

require DR . '/includes/php/classes/Product_Listing.php';

define('MY_PROFILE', (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] == $_data['user']['user_id'] ? true : false) );
?>
<style>
#mainProfileColumn{width:1000px; margin:0px auto; margin-top: 110px; background-color:#f7f7f7; overflow:hidden; border:#e9e9e9 2px solid; font:Helvetica, sans-serif;}
#userPostGallery{ width:520%; height:300px; position:relative; overflow:hidden; background-color:#000;}
#userPostGallery img{height:100%; float:left;}
#userProfileDeets{height:150px; width: 98.5%;margin-left: .75%; background-color:#fff; position: relative;}
#userProfileDeetsOverlay{width:100%; height: 125%; bottom:0px; position:absolute;}
#userProfileMenuBar{ margin-top:10px; height: 35px; width: 98.5%;margin-left: .75%; background-color:#fff;}
#profilePostBin{}
.userProfileAvatarHome{width: 150px; height:100%; float:left;padding-top: 10px;margin-left: 20px;}
.userProfileAvatarFrame{overflow:hidden;border-radius: 110px; box-shadow: #000 1px 11px 15px -7px; max-height: 150px;}
.userProfileAvatarFrame img{width:100%;}
#userProfileDeetsRightCol{float:right; height:100%; width:300px;}
.userProfileDeetsList{ text-align:left; height:100%; float:left;margin-top: 7px;margin-left: 20px;max-width: 300px;word-wrap: break-word;}
.userProfileDeetsList li{ margin-bottom:10px;}
.followersLink{ width:100%; height:50px; text-align:right;font-size: 15px; margin-right: 40px; color:#fff; float:right;}
.followersLink p{padding-top: 7px;}
.followersLink a{ color:#fff !important;}
.userProfileStatList{ height:65px; width:100%; text-align: right;float: right;margin-top: 30px; opacity:.6;}
.userProfileStatList li{ height:100%; width:20%; float:left;}
#userProfileShareBox{height:100%; width:400px; float:left; margin-left:10px; opacity:.6;}
#userProfileShareBox li{height: 70%;width: 27px;float: left;margin-top: 5px; cursor:pointer;}
#togglePostsLove{ height:100%; width:200px; float:left;}
.togglePostsButton{height: 25px;width: 44%;margin-left: 5%;float: left;padding-top: 9px;text-align: center;font-size: 12px; cursor:pointer;}
#postsGridToggleButton{ height:100%; float:right; width:100px; margin-right:10px; position:absolute; top:0px;}
.profileUsername{font-size: 21px;}
.profileLocation{font-size: 14px;}
.profileRed{ color:#c82727}
.toggleSelected{ color:#c82727; border:#c82727 thin solid;}
.overlayLayer{ position:absolute; left:-1%; top:0px; height:100%; width:102%; background-color:#fff; opacity:.7; }
.levelWrap{position:relative;}
#profileShareFacebook{ background-image:url(/images/profile/1.png); background-repeat: no-repeat; background-size:auto 100%;}
#profileSharePinterest{ background-image:url(/images/profile/2.png); background-repeat: no-repeat; background-size:auto 100%;}
#profileShareInstagram{ background-image:url(/images/profile/3.png); background-repeat: no-repeat; background-size:auto 100%;}
#profileShareTumblr{ background-image:url(/images/profile/4.png); background-repeat: no-repeat; background-size:auto 100%;}
#profileShareTwitter{ background-image:url(/images/profile/5.png); background-repeat: no-repeat; background-size:auto 100%;}
#profileShareEmail{ background-image:url(/images/profile/6.png); background-repeat: no-repeat; background-size:auto 100%;}
#profileStatRank{ background-image:url(/images/profile/A.png); background-repeat:no-repeat; background-size:auto 50%; background-position: 50% 0;}
#profileStatPoints{ background-image:url(/images/profile/B.png); background-repeat:no-repeat; background-size:auto 50%; background-position: 50% 0;}
#profileStatFollow{ background-image:url(/images/profile/C.png); background-repeat:no-repeat; background-size:auto 50%; background-position: 50% 0;}
#profileStatShare{ background-image:url(/images/profile/D.png); background-repeat:no-repeat; background-size:auto 50%; background-position: 50% 0;}
.statTitle{margin-top: 34px;text-align: center;color: #c2c2c2;font-size: 12px;}
.statPoints{margin-top: -5px;margin-right: 14px;}
.boutitboutit{color:#969696;}
</style>
<? //var_dump($_data['user']) ?>
<div id="mainProfileColumn">
	<div id="userPostGallery">
    	<? for($x = 0; $x < 7; $x++) {
			echo '<a href="/post-details?posting_id='.$_data['posts'][$x]['posting_id'].'" rel="modal"><img class="titlePostImage" src="'.$_data['posts'][$x]['image_url'].'"/></a>';
		}?>
	</div>
    <div id="userProfileDeets">
    	<div id="userProfileDeetsOverlay">
        	<div class="overlayLayer"></div>
            <div class="levelWrap">
                <div class="userProfileAvatarHome">
                    <div class="userProfileAvatarFrame">
                        <a href="<?= $_data['user']['avatar'] ?>" target="_blank"><img alt="<?= $_SESSION['user']['username'] ?>" src="<?= $_data['user']['avatar'] ?>&amp;width=152"/></a>
                    </div>
                </div>
                <ul class="userProfileDeetsList">
                    <li class="profileUsername"><?= $_data['user']['username'] ?></li>
                    <li class="profileLocation"><?= $_data['user']['location'] ?></li>
                    <li class="boutitboutit"><?= $_data['user']['about'] ?></li>
                    <? if(MY_PROFILE): ?> 
                    	<li><a href="/account/settings"><span class="profileRed">Edit</span></a></li>
                    <? endif ?>
                </ul>
                <div id="userProfileDeetsRightCol">
                    <div class="followersLink"><p><a href="/<?= $_data['user']['username'] ?>/followers">Followers</a> <span id="followersCount"><?= $_data['user']['followers'] ?></span><p></div>
                    <ul class="userProfileStatList">
                        <li id="profileStatRank"><p class="statTitle">Rank</p><p class="profileRed statPoints"><?= $_data['user']['rank'] ?></p></li>
                        <li id="profileStatPoints"><p class="statTitle">Points</p><p class="profileRed statPoints"><?= $_data['user']['points'] ?></p></li>
                        <? if(!MY_PROFILE): ?> 
                        	<li id="profileStatFollow" class="cursor"><p id="followingStatus" class="statTitle"><?= ($_data['user']['is_followed'] ? 'UNFOLLOW' : 'FOLLOW') ?></p></li>
                        <? endif ?>
                        <li id="profileStatShare"><p class="statTitle">SHARE</p></li>
                </div>
       		</div>
    	</div>
    </div>
    <div id="userProfileMenuBar">
    	<ul id="userProfileShareBox">
        	<li onclick="facebookFeed('http://www.dahliawolf.com/images/logo.png', 'http://www.dahliawolf.com/<?= $_SESSION['user']['username'] ?>', 'OMGeeezy follow me on Dahliawolf and vote on some of my posts!');" id="profileShareFacebook"></li>
             <a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com/<?= $_SESSION['user']['username'] ?>&media=<?= $_data['user']['avatar'] ?>" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
            	<li id="profileSharePinterest"></li>
            </a>
            <li id="profileShareInstagram"></li>
            <a href="http://www.tumblr.com/share/photo?source=<?= rawurlencode( $_data['user']['avatar'] )?>&caption=<?= rawurlencode( "OMG Check out my profile on Dahliawolf and vote on my posts you LOVE! Thanks smiles:)" )?>&click_thru=<?= rawurlencode( "http://www.dahliawolf.com/".$_SESSION['user']['username'] ) ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
            	<li id="profileShareTumblr"></li>
            </a>
            <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&amp;url=http://www.dahliawolf.com/<?= $_SESSION['user']['username'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
            	<li id="profileShareTwitter"></li>
            </a>
            <a href='mailto:?subject=Check out my profile on Dahliawolf&body=Check out my profile on Dahliawolf and vote some of posts and help get my items chosen to make new fashions! Thank you :) http://www.dahliawolf.com/<?= $_SESSION['user']['username'] ?>'>
            	<li id="profileShareEmail"></li>
            </a>
        </ul>
        <div id="togglePostsLove">
        	<a href="/<?= $_data['user']['username'] ?>"><div class="togglePostsButton <?= ( empty($_GET['view']) ? 'toggleSelected' : '' ) ?>">MY POSTS</div></a>
            <a href="/<?= $_data['user']['username'] ?>/loves"><div class="togglePostsButton <?= ( !empty($_GET['view']) ? 'toggleSelected' : '' ) ?>">MY LOVES</div></a>
        </div>
        
    </div>
    
    <div class="ColumnContainer">
	    <?
	    if (!empty($_data['posts'])) {
	    	//require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/classes/Spine.php';
			$Spine = new Spine();
			//$Spine->output($_data['posts'], 'spine');
			$Spine->output($_data['posts'], 'spine', '/spine-chunk.php?username=' . $_data['user']['username']);
		}
	    ?>
    </div>
    
</div>	
<script>
	theUserProfileData = new userProfile(<?= json_encode($_data['posts']) ?>, <?= json_encode($_data['user']) ?>);
</script> 
<?
include "footer.php";
?>