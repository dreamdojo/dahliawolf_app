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
    <img class="hiw" src="/images/watchMovie.png">

    <div class="bits">
        <p class="default">YOU <span>POST</span> FASHION IMAGES</BR>WE TURN YOUR IMAGES INTO <span>CLOTHING</span></p>
        <p class="inspire">YOU POST IMAGES AND THE COMMUNITY VOTES<br>GET ENOUGH VOTES AND WE DESIGN AN ITEM FOR THE SHOP</p>
        <p class="design">BASED ON THE IMAGES YOU POST AND RECEIVE ENOUGH VOTES</br>WE CREATE A FASHION ITEM JUST FOR YOU TO BE SOLD IN OUR SHOP</p>
        <p class="earn">FOR EVERY ITEM THAT YOU INSPIRE</br>YOU GET A CHECK FOR 5% OF ALL SALES OF THAT ITEM!!</p>
    </div>
    <ul id="theMethod">
        <li data-section="inspire"><img src="/images/hb_insp.png"></li>
        <li data-section="design"><img src="/images/hb_des.png"></li>
        <li data-section="earn"><img src="/images/hb_earn.png"></li>
    </ul>
</div>

<?
    include "header.php";
    include "blocks/filter.php";
?>
    <div id="voteBucket"></div>
<?php
    include "/footer.php";
?>
<script>
    $(function() {
        dahliawolfFeed = new voteFeed({mode:'grid' <? !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <? !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
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
