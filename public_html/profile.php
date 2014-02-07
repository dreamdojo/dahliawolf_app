<?
    $pageTitle =  !empty($_GET['dashboard']) ? 'Dashboard' : 'Profile' ." - ".$_GET['username'];
    include "head.php";

    $params = array(
        'username' => strtolower($_GET['username']),
        'limit' => 0
    );

    if (IS_LOGGED_IN) {
        $params['viewer_user_id'] = $_SESSION['user']['user_id'];
    }
    $data = api_call('user', 'get_user', $params, true);
    $_data['user'] = $data['data'];
    if (empty($_data['user'])) {
        default_redirect();
    }

    $params = array(
        'user_id' => $_data['user']['user_id'],
        'limit' => 8
    );

    $posts_data = api_call('posting', 'all_posts', $params, true);

    $_data['posts'] = $posts_data['data'];

    define('MY_PROFILE', (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] == $_data['user']['user_id'] ? true : false) );

    $url = 'http://www.dahliawolf.com/api/1-0/posting.json?function=get_user_faves&use_hmac_check=0&viewer_user_id='.$_SESSION['user']['user_id'].'&user_id='.$_data['user']['user_id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
    $faves = $result->data->get_user_faves;

    if(!$_data['user']['user_id']) {
        $_SESSION['errors'][0] = 'You have wandered off the beaten path :(';
        include "header.php";
        die();
    }
    include "header.php";
?>

<? if(!isset($_GET['dashboard']) || !MY_PROFILE): ?>
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
                <div id="avatarHome" class="userProfileAvatarHome">

                </div>
                <ul class="userProfileDeetsList">
                    <li class="profileUsername"><a href="@<?= $_data['user']['username'] ?>" style="float: left;" rel="message">@<?= $_data['user']['username'] ?></a>
                        <?= $_data['user']['verified'] && $_data['user']['membership_level'] != 'VIP' ? '<div class="memberStats"><a href="/help/verified"><img src="/images/verified.png"></a><div class="ms_ro" style="background-image: url(\'/images/verified_RO.png\')"></div></div>' : ''  ?>
                        <?= $_data['user']['membership_level'] == 'VIP' ? '<div class="memberStats"><a href="/help/vip"><img src="/images/vip.png"></a><div class="ms_ro" style="background-image: url(\'/images/vip_RO.png\')"></div></div>' : ''  ?>
                        <div style="clear: left;"></div>
                    </li>
                    <li class="profileLocation"><?= $_data['user']['location'] ?></li>
                    <li class="profileLocation"><a href="http://<?= $_data['user']['website'] ?>" target="_blank" style="font-weight: bold !important;"><?= $_data['user']['website'] ?></a></li>
                    <li class="boutitboutit"><?= $_data['user']['about'] ?></li>
                    <? if(MY_PROFILE): ?> 
                    	<li style="margin-top: 5px !important;"><a href="/account/settings"><span class="profileRed">Edit</span></a></li>
                    <? endif ?>
                </ul>
                <div id="userProfileDeetsRightCol">
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
            <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.dahliawolf.com/<?= $_data['user']['username']  ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
                <li id="profileShareFacebook"></li>
            </a>
             <a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com/<?= $_data['user']['username']  ?>&media=<?= $_data['user']['avatar'] ?>" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
            	<li id="profileSharePinterest"></li>
            </a>
            <li id="profileShareInstagram"></li>
            <a href="http://www.tumblr.com/share/photo?source=<?= rawurlencode( $_data['user']['avatar'] )?>&caption=<?= rawurlencode( "Check out this profile on #Dahliawolf" )?>&click_thru=<?= rawurlencode( "http://www.dahliawolf.com/".$_data['user']['username'] ) ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
            	<li id="profileShareTumblr"></li>
            </a>
            <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&url=http://www.dahliawolf.com/<?= $_data['user']['username'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
            	<li id="profileShareTwitter"></li>
            </a>
            <a href='mailto:?subject=Check out <?= $_data['user']['username'] ?>'s profile on Dahliawolf&body=http://www.dahliawolf.com/<?= $_SESSION['user']['username'] ?>'>
            	<li id="profileShareEmail"></li>
            </a>
        </ul>
        <div id="togglePostsLove">
            <div data-filter="posts" class="togglePostsButton <?= ( empty($_GET['view']) ? 'toggleSelected' : '' ) ?>">POSTS</div>
            <div data-filter="loves" class="togglePostsButton <?= ( !empty($_GET['view']) ? 'toggleSelected' : '' ) ?>">LOVES</div>
        </div>

    </div>


    <div id="userPostGrid">
    </div>
</div>

<? elseif(MY_PROFILE && isset($_GET['dashboard'])): ?>
    <? include "dashboard.php"; ?>
<? endif ?>
<?
    //include "footer.php";
?>

<? if(!isset($_GET['dashboard'])): ?>
<script>
    <?php if(!IS_LOGGED_IN): ?>
        new_loginscreen();
    <? endif ?>
    $(function() {
        theUserProfileData = new userProfile(<?= json_encode($_data['posts']) ?>, <?= json_encode($_data['user']) ?>);
        thePostGrid = new postDetailGrid( theUserProfileData.data.user_id, $(window), true, "<?= !empty($_GET['view']) ? $_GET['view'] : 'posts' ?>" );
        thePostGrid.setFaves(<?= json_encode($faves) ?>);
    });

    function userProfile(posts, data) {
        this.posts = posts;
        this.data = data;
        this.data.is_followed = parseInt(this.data.is_followed);
        this.animationIndex = 7;
        this.bindFrontEnd();

        if(this.posts.length >= 6) {
            setTimeout($.proxy(this.doUserPostBarMagic, this), 10000);
        }

        $('#avatarHome').append(new dahliawolf.$hoverAvatar(data));

    }

    userProfile.prototype.doUserPostBarMagic = function() {
        if(this.animationIndex >= (this.posts.length-1)) {
            this.animationIndex = 0;
        }
        $this = this;
        this.animationIndex++;
        $.each( $('#userPostGallery img'), function(index, element){
            $(element).css('left' , $(element).position().left);
        });
        $('.titlePostImage').css('position', 'absolute');
        $.each( $('#userPostGallery img'), function(index, element){
            $(element).animate({left: ( $(element).position().left - $('.titlePostImage').eq(0).width() )}, 700, function() {
                if(index == ($('.titlePostImage').length - 1) ) {
                    $('.titlePostImage').eq(0).remove();
                    $('.titlePostImage').css('position', 'static');
                    $('#userPostGallery img').last().fadeIn(300);
                    $('#userPostGallery').append('<img class="titlePostImage" style="display:none;" src="'+$this.posts[$this.animationIndex].image_url+'">');
                    setTimeout($.proxy($this.doUserPostBarMagic, $this), 10000);
                }
            });
        });
    }

    userProfile.prototype.bindFrontEnd = function() {
        this.followButton = $('.followersLink');
        this.followerCount = $('#followersCount');
        this.followStatus = $('#followingStatus');

        this.followButton.bind('click', $.proxy(this.toggleFollow, this));
        $('#togglePostsLove div').on('click', this.toggleFeed);
    }

    userProfile.prototype.toggleFeed = function() {
        $('.toggleSelected').removeClass('toggleSelected');
        $(this).addClass('toggleSelected');
        thePostGrid.feedType = $(this).data('filter');
        thePostGrid.resetGrid();
    }

    userProfile.prototype.toggleFollow = function() {
        if(theUser.id){
            if(this.data.is_followed) {
                this.data.is_followed = false;
                this.data.followers--;
                this.followStatus.html('Follow').removeClass('profileFollowing');
                dahliawolf.member.unfollow(this.data.user_id);
            } else {
                this.data.is_followed = true;
                this.data.followers++;
                this.followStatus.html('Following').addClass('profileFollowing');
                dahliawolf.member.follow(this.data.user_id);
            }
            this.followerCount.html(this.data.followers);
        } else {
            new_loginscreen();
        }
    }
</script>
<? endif ?>