<?php
    $pageTitle = "Homepage";
    include "head.php";
?>
<style>
    #joinBanner{height: 400px;width: 100%; min-width:600px; position: relative; background-image: url("/images/joinBanner.jpg");background-size: auto 100%;background-position: 50%;background-repeat: no-repeat;background-color: #dedede;}
    #joinBanner .hiw{position: absolute;right: 6%;margin-top: 44px;cursor: pointer;}
    #joinBanner .swf{position: absolute; right: 6%; margin-top: 319px;cursor: pointer;}
    #dahliaHeader{position: relative;}
    body{margin-top: 0px;}
    #sort-bar{margin-top: 5px;}
    #hiw-slide{display: none; left: 100%; height: 100%; background-color: #000; z-index: 1; position: absolute; width: 100%; text-align: center;}
    #hiw-slide video{height: 95%;margin-top: 10px;}
    #theCloser{position: absolute;right: 18px;top: 10px;font-size: 29px;color: #fff;cursor: pointer;}
    @media screen and (max-width: 770px) {
        #joinBanner .hiw{display: none;}
        #joinBanner .swf{display: none;}
    }
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
