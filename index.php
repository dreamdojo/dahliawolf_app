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
        .bits{font-size: 18px;padding: 40px;color: #acacac; min-height: 50px;}
        .bits p{position: absolute;width: 100%;left: 0; display: none;}
        .bits .default{display: block;}
        #theMethod li{cursor: pointer;}
        #movieCurtain{position: absolute; width: 100%; height: 100%; left: 0px; top: 0px; background-color: #000; opacity: .8; z-index: 100;}
    </style>

<div id="movieTheatre">
    <div id="movieCurtain"></div>
    <?php include "video_page.php" ?>
    <div id="joinBanner">
        <div class="bits">
            <p class="default">YOU POST FASHION IMAGES</BR>WE TURN YOUR IMAGES INTO CLOTHING</p>
            <p class="inspire">YOU POST IMAGES AND THE COMMUNITY VOTES<br>GET ENOUGH VOTES AND WE DESIGN AN ITEM FOR THE SHOP</p>
            <p class="design">BASED ON THE IMAGES YOU POST AND RECEIVE ENOUGH VOTES</br>WE CREATE A FASHION ITEM JUST FOR YOU TO BE SOLD IN OUR SHOP</p>
            <p class="earn">FOR EVERY ITEM THAT YOU INSPIRE</br>YOU GET A CHECK FOR 5% OF ALL SALES OF THAT ITEM!!</p>
        </div>
        <ul id="theMethod">
            <li data-section="inspire"><a href="/help"><img src="/images/hb_insp.png"></a></li>
            <li data-section="design"><a href="/help"><img src="/images/hb_des.png"></a></li>
            <li data-section="earn"><a href="/help"><img src="/images/hb_earn.png"></a></li>
        </ul>
    </div>
</div>

<?
    include "header.php";
    include "blocks/filter.php";
?>
    <div id="voteBucket"></div>
<?php include "/footer.php"; ?>
<script>
    $(window).scrollTop($('#joinBanner').offset().top);
    SetTheater();
    $(function() {
        SetTheater();
        setTimeout(function() {
            window.scroll(0, $('#joinBanner').offset().top);
            SetTheater();
            document.getElementById("dwvideo").play();
        }, 2000);
        window.scroll(0, $('#joinBanner').offset().top);
        dahliawolfFeed = new voteFeed({mode:'grid' <? !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <? !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
    });

    $(function() {
       var $head = $('#dahliaHeader');
        SetTheater();
        $(window).scroll(function() {
           SetTheater();
            if($(this).scrollTop() > $('#movieTheatre').height()) {
                $head.css('position', 'fixed');
                document.getElementById("dwvideo").pause();
            } else {
                $head.css('position', 'relative');
                document.getElementById("dwvideo").play();
            }
       });

       $('.hiw').on('click', function() {
           var $movieScreen = $('<div id="tooltip-overlay"></div>').css({'opacity': 1}).appendTo($('body')).fadeIn(1000,function() {
               $movieScreen.load('/video_page.php');
               var $closer = $('<div class="closeMovie"><img src="/images/movieClose.png"></div>').appendTo($('body')).on('click', function(){
                   $closer.remove();
                   $movieScreen.empty().fadeOut(500, function() {
                        $movieScreen.remove();
                    });
               });
           });
       });

        new learnEm();
    });

    function SetTheater() {
        var $vid  = document.getElementById("dwvideo");
        var op = (1 - ((($('#joinBanner').offset().top - $(window).scrollTop()))/$('#joinBanner').offset().top));
        $('#movieCurtain').css('opacity', (op - .4));
        $('#joinBanner').css('opacity', op);
        if((1-op) < 0 && $vid.volume > 0) {
            $vid.volume = 0;
        }
        if((1-op) >= 0 && (1-op) <= 1) {
            $vid.volume = (Math.abs(1-op));
        }

    }

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
