<?
    $pageTitle = "Profile";
    include "head.php";

    if(!$_data['user']['user_id']) {
        $_SESSION['errors'][0] = 'You have wandered off the beaten path :(';
        include "header.php";
        die();
    }
    include "header.php";

    define('MY_PROFILE', (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] == $_data['user']['user_id'] ? true : false) );

    $feedType = ($_data['view'] == 'wild-4s' ? 'loves' : 'posts');
?>

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