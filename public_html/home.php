<?php
    $pageTitle = "Homepage";
    if(isset($_COOKIE["dahliaUser"]) && isset($_COOKIE["token"])){
        $_SESSION['user'] = unserialize($_COOKIE["dahliaUser"]);
        $_SESSION['token'] = $_COOKIE["token"];
    }
    include "head.php";
?>
    <style>
        #dahliaHeader{position: relative;}
        body{margin-top: 0px;}
        #sort-bar{margin-top: 5px;}
        #joinBanner span{color: #F03E63;}
        #joinBanner ul{width: 450px;display: inline-block;margin: 0px auto;text-align: center;}
        #joinBanner li{float: left; width: 33%;}
        .bits{font-size: 18px;padding: 40px;color: #666;min-height: 50px;}
        .bits p{position: absolute;width: 100%;left: 0; display: none;}
        .bits .default{display: block;}
        #theMethod li{cursor: pointer;}
    </style>

<div id="joinBanner">
    <img class="hiw" src="/public_html/images/howitworks.png">
    <div id="hiw-slide">
        <div id="theCloser">X</div>
        <video id="hiwVideo" controls poster="http://www.dahliawolf.com/images/how-it-works-video.png" >
            <source src="http://www.dahliawolf.com/images/video/hiw_mobile.mp4" type="video/mp4">
            <source src="http://www.dahliawolf.com/images/video/hiw_mobile.ogg" type="video/ogg">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="bits">
        <p class="default">YOU <span>POST</span> FASHION IMAGES</BR>WE TURN YOUR IMAGES INTO <span>CLOTHING</span></p>
        <p class="inspire">YOU POST IMAGES AND THE COMMUNITY VOTES<br>GET ENOUGH VOTES AND WE DESIGN AN ITEM FOR THE SHOP</p>
        <p class="design">BASED ON THE IMAGES YOU POST AND RECEIVE ENOUGH VOTES</br>WE CREATE A FASHION ITEM JUST FOR YOU TO BE SOLD IN OUR SHOP</p>
        <p class="earn">FOR EVERY ITEM THAT YOU INSPIRE</br>YOU GET A CHECK FOR 5% OF ALL SALES OF THAT ITEM!!</p>
    </div>
    <ul id="theMethod">
        <li data-section="inspire"><img src="/public_html/images/hb_insp.png"></li>
        <li data-section="design"><img src="/public_html/images/hb_des.png"></li>
        <li data-section="earn"><img src="/public_html/images/hb_earn.png"></li>
    </ul>
</div>

<?
    include "header.php";
    include "blocks/filter.php";
?>
    <div id="voteBucket"></div>
<?php
    include "footer.php";
?>
<script>
    $(function() {
        dahliawolfFeed = new voteFeed({mode:'spine' <? !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <? !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
    });

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

        new learnEm();
    });

    function learnEm() {
        var text = {'default': 'YOU <span>POST</span> FASHION IMAGES</BR>WE TURN YOUR IMAGES INTO <span>CLOTHING</span>',
            'inspire' : 'YOU POST IMAGES AND THE COMMUNITY VOTES<br>GET ENOUGH VOTES AND WE DESIGN AN ITEM FOR THE SHOP',
            'design' : 'BASED ON THE IMAGES THAT RECIEVE ENOUGH VOTES</br>WE CREATE A FASHION ITEM JUST FOR YOU TO BE SOLD IN OUR SHOP',
            'earn' : 'FOR EVERY ITEM THAT YOU INSPIRE</br>YOU GET A CHECK FOR 5% OF ALL SALES OF THAT ITEM!!'
        };
        var $view = $('.bits');
        var $def = $('.bits .default');
        var timer = 100;
        var $last = null;

        $('#theMethod li').hover(function() {
            if($last && $last.is(':visible')) {
                $last.hide();
            }
            $def.fadeOut(timer);
            $('.'+$(this).data('section')).fadeIn(timer);
        }, function() {
            $last = $('.'+$(this).data('section')).fadeOut(timer);
        });
        $('#theMethod').on('mouseleave', function() {
            $def.fadeIn(timer);
        });
    }
</script>
