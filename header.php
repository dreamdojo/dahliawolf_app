<?php if(!IS_LOGGED_IN): ?>
    <?php include "login_pop.php"; ?>
<?php endif ?>
<?php require_once 'blocks/analytics.php'; ?>

<body style="overflow-x: hidden;">

<div id="loadme"></div>

<div id="fb-root"></div>

<script>
    window.fbAsyncInit = function() {
        // init the FB JS SDK
        FB.init({
            appId      : '552515884776900',                        // App ID from the app dashboard
            channelUrl : '//www.dahliawolf.com/channel.html', // Channel file for x-domain comms
            status     : true,                                 // Check Facebook Login status
            xfbml      : true                                  // Look for social plugins on the page
        });

        // Additional initialization code such as adding Event Listeners goes here
    };

    // Load the SDK asynchronously
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all/debug.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    $(document).ready(function()
    {
        $("#ScrollToTop").click(function()
        {
            $(window).scrollTop(0);

            return false;
        });
        function scrollToTopCheck() {
            if ($(window).scrollTop() > 500) $("#ScrollToTop").show();
            else $("#ScrollToTop").hide();
        }
        $(window).scroll(scrollToTopCheck);
        scrollToTopCheck();
        // Fancy Form
        $(".FancyForm input[type=text], .FancyForm input[type=password], .FancyForm textarea").each(function() {
            if ($(this).val()) $(this).addClass("NotEmpty");
        }).change(function() {
                if ($(this).val()) $(this).addClass("NotEmpty");
                else  $(this).removeClass("NotEmpty");
            });
    });

    //Google Aanalytics
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-34564940-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>

<div id="modal" class="modal">
    <div id="modal-content">
        <img id="modal-image" />
    </div>
</div>

<a name="top"></a>

<div id="dahliaHeader" class="avatarShadow">
    <div id="dahliaMainMenuButton">
        <ul class="theMainMenu">
            <li><a href="/inspire">INSPIRE</a></li>
            <li><a href="/spine">VOTE</a></li>
            <li><a href="/shop">SHOP</a></li>
        </ul>
    </div>
    <a href="/"><div id="dahliaLogo"></div></a>
    <ul class="native_head">
        <li>
            <a href="https://itunes.apple.com/us/app/dahlia-wolf-fashion/id718253685?ls=1&mt=8">
                <img src="/images/nh_ios.png">
            </a>
        </li>
        <li>
            <a href="https://play.google.com/store/apps/details?id=com.zyonnetworks.dahliawolf2&hl=en">
                <img src="/images/nh_droid.png">
            </a>
        </li>
    </ul>
    <ul id="mainMenu">
        <li><a href="/inspire"><span class="<?= $self == '/inspire.php' ? 'pinkMe' : '' ?>">INSPIRE+</a><div class="mmBorder"></div></li>
        <li><a href="/vote"><span class="<?= $self == '/grid.php' || $self == '/spine.php' || $self == '/vote.php'  || $self == '/index.php' ? 'pinkMe' : '' ?>">VOTE</a><div class="mmBorder"></div></li>
        <li><a href="/shop"><span class="<?= $self == '/shop/index.php' ? 'pinkMe' : '' ?>">SHOP</a></li>
    </ul>

    <div id="rightHandMenu">
        <div id="tourButton"></div>
        <div id="shoppingCart" <?= count($_data['cart']['products']) ? 'style="background-image: url(\'/images/shoppingCart_on.png\');"' : '' ?>>
            <?php if(count($_data['cart']['products'])): ?>
                <a href="/shop/cart"><div class="cartCount"><?= getTotalProductsInCart($_data['cart']['products']) ?></div></a>
                <ul id="dahliaCart">
                    <div class="cart_bezier"></div>
                    <?php foreach( $_data['cart']['products'] as $product ): ?>
                        <ul>
                            <li><img src="http://content.dahliawolf.com/shop/product/image.php?file_id=<?= $product['product_info']['product_file_id'] ?>&width=80"></li>
                            <li style="line-height: 20px;"><?= $product['product_info']['product_name'] ?></li>
                            <li>$<?= money_format('%i', ($product['product_info']['sale_price'] ? $product['product_info']['sale_price'] : $product['product_info']['price'])) ?></li>
                            <li><?= $product['attributes'] ?></li>
                            <li>Quantity <?= $product['quantity'] ?> </li>
                        </ul>
                    <?php endforeach ?>
                    <a href="/shop/cart"><li class="cta">Edit bag/ Check out</li></a>
                </ul>
            <? else: ?>
                <a href="/shop/cart"><div class="cartCount"></div></a>
            <? endif ?>
        </div>
        <div id="searchButton"></div>
        <div id="userMenu">
            <div class="rtBorder"></div>
            <div class="menuBars"><img src="/images/menu-bars.png"></div>
            <? if(IS_LOGGED_IN): ?>
                <div class="avatarFrame theUsersAvatar"><a href="/<?= $_SESSION['user']['username'] ?>"><img src="<?= $userConfig['avatar'] ?>&width=100"></a></div>
                <div class="userName"><a href="/<?= $_SESSION['user']['username'] ?>" style="color: #B1B1B1 !important;"><?= $_SESSION['user']['username'] ?></a></div>
            <? endif ?>
            <ul id="theDropdown">
                <div class="header-bezier"></div>
                <? if(IS_LOGGED_IN): ?>
                    <a href="/<?= $_SESSION['user']['username'] ?>"><li style="border-top: none;">Profile</li></a>
                    <a href="/<?= $_SESSION['user']['username'] ?>?dashboard=true"><li>Dashboard</li></a>
                    <!--<a href="/activity"><li>Activity</li></a>-->
                    <a href="/invite"><li>Grow My Clique</li></a>
                    <a href="/account/settings"><li>Settings</li></a>
                    <a href="/shop/my-orders"><li>Orders</li></a>
                <? endif ?>
                <a href="/goodies"><li>Goodies</li></a>
                <a href="http://blog.dahliawolf.com/"><li>Blog</li></a>
                <!--<a href="/shop/my-wishlist"><li>Wishlist</li></a>-->
                <a href="/pinit"><li>Inspire Tool</li></a>
                <a href="/wolf-pack"><li style="border-bottom: none;">Pack Leaders</li></a>
                <a href="/faqs"><li>FAQ</li></a>
                <? if(IS_LOGGED_IN): ?>
                    <a href="/action/logout"><li>Logout</li></a>
                <? endif ?>
                <li class="top-menu-footer"><a href="/help">How it Works</a> - <a href="/tos">Legal</a> - <a href="/contact">Contact</a> - <bold>© Dahlia Wolf 2013</bold></li>
            </ul>
        </div>
        <? if(!IS_LOGGED_IN): ?>
            <ul class="loginDept">
                <li onclick="loginscreen('login')">Login<div class="mmBorder"></div></li>
                <li onclick="loginscreen('signup')" style="margin-right: 20px; color: #F03E63;">Signup</li>
            </ul>
        <? endif ?>
    </div>
    <div id="searchBar">
        <input type="text" placeholder="Start typing to search...">
    </div>
</div>

<div id="dahliaHead">
    <div id="dahliaHeadAvatar"><img id="dahliaHeadAvatarSrc" src="" /></div>
    <div id="dahliaHeadFollowToggle"></div>
</div>

<div id="theLesson" class="lessonBox">
    <div id="lesson-title" class="lesson-section"></div>
    <div class="lesson-line"></div>
    <div id="lesson-content" class="lesson-content"></div>
    <div class="lesson-steps">
        <div style="padding-top: 29px;color: rgb(104, 104, 104);">Still have questions? Visit the <a href="/faqs">FAQs</a> or <a href="/help">How it Works</a></div>
    </div>
</div>

<div id="loadingView">
    <img src="/images/dw-logo.png">
</div>

<script>

    $(function(){
        theLesson.init('<?= $self ?>');
        dahliaLoader = new loadingBar();
    });
</script>


<form action="action/post_image.php" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">


<div id="post-me">
	<div id="u-clsr" onclick="imgUpload.closeMe()">X</div>
    <div class="uploader-frame">
    	<img id="user-uploaded-img" />
    </div>

        <input type="hidden" name="subpin" value="1">
        <div style="text-align: center;"><textarea name="description" id="comment">#dahliawolf</textarea></div>
        <div style="text-align: center;padding-bottom: 25px; margin-top: 10px;"><input name="submit" type="image" src="/images/postitbtn2.png" onclick="$(this).hide()" id="image-sub"></div>
</div>
</form>

<?
if (!empty($_SESSION['errors'])): ?>
    <script>
        _gaq.push(['_trackEvent','Errors' , '<?= $_SESSION['errors'][0] ?>']);
    </script>
	<div class="user-message user-error ui-state-error ui-corner-all">
        <div class='user-message-close'>X</div>
        <?php if (count($_SESSION['errors']) == 1 && trim($_SESSION['errors'][0]) != '' ): ?>
			<?php if (!empty($_SESSION['errors'][0])): ?>
				<p><?= $_SESSION['errors'][0] ?></p>
                <script>_gaq.push(['_trackEvent','Errors' , '<?= $_SESSION['errors'][0] ?>']);</script>
		    <?php endif ?>
		<?php else: ?>
			<ul>
				<?php foreach ($_SESSION['errors'] as $error): ?>
                    <script>_gaq.push(['_trackEvent','Errors' , '<?= $error ?>']);</script>
					<li><?= $error ?></li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
	</div>
	<?php unset($_SESSION['errors']); ?>
<?php endif ?>

<?php if( !empty($_SESSION['success']) ): ?>
    <script>
        _gaq.push(['_trackEvent','Success' , '<?= $_SESSION['success'] ?>']);
    </script>
    <div class="user-message user-success ui-state-highlight ui-corner-all">
        <div class='user-message-close'>X</div>
        <p><?= $_SESSION['success'] ?></p>
    </div>
    <?php unset($_SESSION['success']) ?>
<?php endif ?>
