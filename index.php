<?php
    $pageTitle = "Homepage";
    include "head.php";
?>
<?php if(!IS_LOGGED_IN): ?>
    <style>
        #dahliaHeader{position: relative;}
        body{margin-top: 0px;}
        #sort-bar{margin-top: 5px;}
    </style>

<div id="joinBanner">
    <img class="hiw" src="/images/howitworks.png">
    <a href="/social-login.php?social_network=facebook">
        <img class="swf" src="/images/facebook.png">
    </a>
    <div id="hiw-slide">
        <div id="theCloser">X</div>
        <video id="hiwVideo" controls poster="http://www.dahliawolf.com/images/how-it-works-video.png" >
            <source src="http://www.dahliawolf.com/images/video/hiw_mobile.mp4" type="video/mp4">
            <source src="http://www.dahliawolf.com/images/video/hiw_mobile.ogg" type="video/ogg">
            Your browser does not support the video tag.
        </video>
    </div>
</div>
<? endif ?>

<?
    include "header.php";
    $Spine = new Spine();
    include "blocks/filter.php";
    $Spine->output($_data['posts']);
    include "footer.php";
?>
<script>
    $(function() {
       var $head = $('#dahliaHeader');
        $(window).scroll(function() {
            if($(this).scrollTop() > 400) {
                $head.css('position', 'fixed');
            } else {
                $head.css('position', 'relative');
            }
        });
        $('#theCloser').on('click', function() {
            document.getElementById('hiwVideo').pause();
            $('#hiw-slide').animate({'left':100+'%'}, 300, function() {
                $(this).hide();
            });
        });
        $('.hiw').on('click', function() {
           $('#hiw-slide').fadeIn(0, function() {
                $(this).animate({'left':0+'%'}, 300, function() {
                    document.getElementById('hiwVideo').play();
                });
           });
        });
    });
</script>
