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

    //Google Aanalytics
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-34564940-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        //ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
<style>
    #theDropPad{position: fixed; width: 100%; height: 100%; top: 0px; left: 0px;z-index: 1000000; display: none;}
    #theDropPad .theOverlay{position: absolute; width: 100%; height: 100%; background-color: #000; opacity: .8; left: 0px; top: 0px;}
    #theDropPad #dropUpdate{font-size: 80px; opacity:.85; width: 100%;margin-top: -50px;text-align: center;height: 100px;top: 50%;position: absolute; color: #fff; z-index: 10;}
    #theDropPad #actualDropPad{position: absolute; width: 100%; height: 100%; left: 0px; top: 0px; z-index: 100;}
    #theDropPad .postConfirm{position: absolute; overflow:hidden; width: 300px;background-color: #fff; top: 50%;left: 50%;height: 450px;margin-top: -225px; margin-left: -150px; z-index: 10000; display: none;transition: all 0.3s ease-in-out;-webkit-transition: all 0.3s ease-in-out;}
    #theDropPad .closer{position: absolute; right: 6px;top: 0px;font-size: 19px;color: #fff;}
    #theDropPad .title{background-color: #76bd23;line-height: 55px;height: 55px;text-align: center;color: #fff;font-size: 13px;}
    #theDropPad .theImage{height: 395px; width:100%; background-size: auto 100%; background-repeat: no-repeat; background-position: 50%;}
</style>

<?php require_once 'blocks/header.php'; ?>
<a name="top"></a>
<div id="theDropPad">
    <div id="dropUpdate">DROP IT LIKE ITS HOT</div>
    <div id="actualDropPad"></div>
    <div class="theOverlay"></div>
</div>


<style>
    #mobile_Menu{position: fixed; height: 100%; width: 80%;top: 0px; left: -80%; z-index: 100000000; display: none;}
    #mobile_Menu li{height: 50px;line-height: 50px;font-size: 13px;color: #fff;text-indent: 5%; border-bottom: #fff thin solid;}
    #mobile_Menu ul ul{min-height: 50px;line-height: 50px;font-size: 13px;color: #fff;text-indent: 5%; border-bottom: #fff thin solid;}
    #mobile_Menu .hasSubs{background-color: #c2c2c2; background-image: url("/images/mobileNavChev.jpg");background-repeat: no-repeat;background-size: auto 50px;background-position: 115% 0px;}
    #mobile_Menu .hasSubs li{display: none;}
    #mobile_Menu .showSubs li{display: block !important; border-bottom: none !important; border-top: #fff thin solid;}
</style>
<div id="mobile_Menu">
    <ul>
        <li>SEARCH ITEMS & PEOPLE</li>
        <li>LOGIN | SIGNUP</li>
        <li>CONTESTS</li>
        <li>GOODIES</li>
        <li>HOW IT WORKS</li>
        <li>CONNECT</li>
        <ul class="hasSubs">FAQ
                <li>BLOAH</li>
                <li>POOTY</li>
        </ul>
        <li>INFO</li>
        <li>LEGAL</li>
        <li>ABOUT</li>
        <li>PRESS</li>
    </ul>
</div>
<script>
    $(function() {
        $('#dahliaMainMenuButton').on('click', function() {
            if( !$('#mobile_Menu').is(':visible') ) {
                $('#mobile_Menu').show().animate({left:0});
                $('#dahliaHeader').animate({left:80+'%'});
            } else {
                $('#mobile_Menu').animate({left:'-'+80+'%'}, function() {
                    $(this).hide();
                });
                $('#dahliaHeader').animate({left:0});
            }
        });
        $('.hasSubs').on('click', function() {
            $(this).toggleClass('showSubs');
        });

        $('body').on('dragenter', function(e){
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            if(e.target != document.getElementById('actualDropPad') && !$('#theDropPad').is(':visible')) {
                console.log(e.srcElement);
                $('#theDropPad').fadeIn(100);
            }
        }).on('dragover', function(e){
            //console.log('daragover');
            e.preventDefault();
            e.stopPropagation();
        });

        $('#theDropPad').on('dragleave', function(e){
            e.preventDefault();
            e.stopPropagation();
            if(e.target != document.getElementById('theDropPad')) {
                $('#theDropPad').fadeOut(100);
            }
        });

        $('#theDropPad').on('drop', function(e){
            if(e.originalEvent.dataTransfer.files){
                if(e.originalEvent.dataTransfer.files.length) {
                    e.preventDefault();
                    e.stopPropagation();
                    new postUpload(e.originalEvent.dataTransfer.files[0]);
                } else {
                    $('#theDropPad').fadeOut(100);
                }
            } else {
                $('#theDropPad').fadeOut(100);
                alert('Drag and Drop not supported in your browser');
            }
        });
    });
</script>

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


<a class="Button WhiteButton Indicator" href="#" id="ScrollToTop" style="display: none;"><img src="/skin/img/gototop.jpg" width="61" height="64"></a>
<div class="cl"></div>
<div id="theOverlay"></div>
<div id="sys-profiler"></div>
<div id="sysMessageDialog" style="display: none;" title="Message"></div>
<div id="modal" class="modal"><div id="modal-content"><img id="modal-image" /></div></div>

<div id="sign-up-modal">
    <div class="sign-up-business">
        <a class="fbsignup" href="/social-login.php?social_network=facebook"><img src="/images/fb_pop_blocker.png" width="244" height="49"></a>
        <a href="/signup"><div class="mailme">or sign up the old school way with email</div></a>
    </div>
</div>

<?php require_once 'blocks/system_messages.php'; ?>
