<?
$pageTitle = "Profile";
include "head.php";

if(!$_data['user']['user_id']) {
    $_SESSION['errors'][0] = 'You have wandered off the beaten path :(';
    include "header.php";
    die();
}
include "header.php";

require DR . '/includes/php/classes/Product_Listing.php';

define('MY_PROFILE', (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] == $_data['user']['user_id'] ? true : false) );

$feedType = ($_data['view'] == 'wild-4s' ? 'loves' : 'posts');

?>
<style>
#mainProfileColumn{width:1000px; margin:0px auto; margin-top: 110px; background-color:#f7f7f7; overflow:hidden; /*border:#e9e9e9 2px solid;*/ font-family:Helvetica, sans-serif;}
#userPostGallery{ width:520%; height:350px; position:relative; overflow:hidden; background-color:#000;}
#userPostGallery img{height:100%; float:left;}
#userProfileDeets{height:140px; width: 98.5%;margin-left: .75%; background-color:#fff; position: relative;}
#userProfileDeetsOverlay{width:100%; height: 129%; bottom:0px; position:absolute;}
#userProfileMenuBar{ margin-top: 10px;height: 47px;width: 98.5%;margin-left: .75%;background-color: #fff;margin-bottom: 10px;}
#profilePostBin{}
.userProfileAvatarHome{width: 140px; height:100%; float:left;padding-top: 10px;margin-left: 10px;}
.userProfileAvatarFrame{overflow: hidden;border-radius: 110px;border: 2px solid white;box-shadow: rgb(133, 133, 133) 1px 11px 15px -7px;max-height: 150px;}
.userProfileAvatarFrame img{width:100%;}
#userProfileDeetsRightCol{float:right; height:100%; width:500px;}
.userProfileDeetsList{ text-align:left; height:100%; float:left;margin-top: 7px;margin-left: 20px;max-width: 300px;word-wrap: break-word;}
.userProfileDeetsList li{ margin-bottom: 10px;font-family: helvetica;font-weight: 100;}
.followersLink{ height: 38px;text-align: right;font-size: 19px;margin-right: 40px;font-weight: 100;color: #fff;float: right;}
.followersLink p{background-color: rgb(255, 255, 255);text-align: center;color: rgb(231, 105, 144);font-size: 17px;padding: 2px 20px 2px 20px;cursor: pointer;margin-top: 5.5px;font-weight:normal;opacity:.9;border: rgb(231, 100, 140) 1px solid;}
.followersLink a{ color:#fff !important;}
.userProfileStatList{ height: 65px;width: 100%;text-align: right;float: right;margin-top: 34px;opacity: .6;margin-right: -86px;}
.userProfileStatList li{ height:100%; width:20%; float:left;}
#userProfileShareBox{height: 76%;width: 400px;float: left;margin-left: 10px;margin-top: 6px;opacity: .5;}
#userProfileShareBox li{height: 70%;width: 27px;float: left;margin-top: 5px; cursor:pointer;}
#togglePostsLove{ height:100%; width:200px; float:left;}
.togglePostsButton{height: 22px;width: 44%;margin-left: 5%;margin-top: 9px;float: left;padding-top: 4px;color: rgb(185, 185, 185);text-align: center;font-size: 15px;font-weight: 100;cursor: pointer;}
#postsGridToggleButton{ height:100%; float:right; width:100px; margin-right:10px; position:absolute; top:0px;}
.profileUsername{font-size: 25px;}
.profileLocation{font-size: 16px;}
.profileRed{ color: #ff2e6e;font-family: helvetica;font-size: 16px;}
.toggleSelected{color: rgb(94, 94, 94);
border: rgb(94, 94, 94) 1px solid;}
.overlayLayer{ position:absolute; left:-1%; top:0px; height:100%; width:102%; background-color:#fff; opacity:.5; }
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
.statTitle{margin-top: 34px;text-align: center;color: rgb(99, 99, 99);font-size: 18px;font-family: helvetica;font-weight: 100;}
.statPoints{margin-top: -11px;text-align: center;}
.boutitboutit{color:#969696;font-size: 17px;height: 63px;overflow: hidden;text-overflow: ellipsis;width: 350px;}
.profileFollowing{color: #c2c2c2 !important; border: #c2c2c2 thin solid !important;}
</style>
<? //var_dump($_data['user']) ?>

<div id="mainProfileColumn">
	<div id="userPostGallery">
    	<? if(count($_data['posts']) >= 6): ?>
			<? for($x = 0; $x < 7; $x++) {
                echo '<a href="/post-details?posting_id='.$_data['posts'][$x]['posting_id'].'" rel="modal"><img class="titlePostImage" src="'.$_data['posts'][$x]['image_url'].'"/></a>';
            }?>
        <? else: ?>
        	<img src="/images/profileFiller.jpg" />
		<? endif ?>
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
                    <li class="profileUsername"><a href="<?= $_data['user']['user_id'] ?>" rel="message">@<?= $_data['user']['username'] ?></a></li>
                    <li class="profileLocation"><?= $_data['user']['location'] ?></li>
                    <li class="boutitboutit"><?= $_data['user']['about'] ?></li>
                    <li class="profileLocation"><a href="http://<?= $_data['user']['website'] ?>" target="_blank" style="font-weight: bold !important;"><?= $_data['user']['website'] ?></a></li>
                    <? if(MY_PROFILE): ?> 
                    	<li><a href="/account/settings"><span class="profileRed">Edit</span></a></li>
                    <? endif ?>
                </ul>
                <div id="userProfileDeetsRightCol">
                        <div class="followersLink" <?= (MY_PROFILE ? 'style="opacity:0;"' : '' ) ?> >
                            <p id="followingStatus" class="<?= ($_data['user']['is_followed']  ? 'profileFollowing' : '') ?>"><?= ($_data['user']['is_followed']  ? 'Following' : 'Follow+' ) ?></p>
                        </div>
                    
                    <ul class="userProfileStatList">
                        <li id="profileStatRank"><p class="statTitle">Rank</p><p class="profileRed statPoints"><?= $_data['user']['rank'] ?></p></li>
                        <li id="profileStatPoints"><p class="statTitle">Points</p><p class="profileRed statPoints"><?= $_data['user']['points'] ?></p></li>
                        <a href="/<?= $_data['user']['username'] ?>/followers"><li id="profileStatFollow"><p class="statTitle">Followers</p><p id="followersCount" class="profileRed statPoints"><?= $_data['user']['followers'] ?></p></li></a>
                        <a href="/<?= $_data['user']['username'] ?>/following"><li id="profileStatFollow"><p class="statTitle">Following</p><p id="followersCount" class="profileRed statPoints"><?= $_data['user']['following'] ?></p></li></a>
                       <!-- <li id="profileStatShare"><p class="statTitle">Shares</p><p class="profileRed statPoints">28</p></li> -->
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
            <a href="/<?= $_data['user']['username'] ?>"><div class="togglePostsButton <?= ( empty($_GET['view']) ? 'toggleSelected' : '' ) ?>">POSTS</div></a>
            <a href="/<?= $_data['user']['username'] ?>/loves"><div class="togglePostsButton <?= ( !empty($_GET['view']) ? 'toggleSelected' : '' ) ?>">LOVES</div></a>
        </div>
        
    </div>


    <div id="userPostGrid"></div>
</div>	
<script>
	theUserProfileData = new userProfile(<?= json_encode($_data['posts']) ?>, <?= json_encode($_data['user']) ?>);
    var thePostGrid = new postDetailGrid( theUserProfileData.data.user_id, $(window), true, "<?= $feedType ?>" );
</script> 
<?
include "footer.php";
?>