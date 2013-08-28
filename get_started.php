<?
    $pageTitle = "Get Started";
    include "head.php";
    include "header.php";
    include "post_slideout.php";

    $params = array(
        'username' => $_SESSION['user']['username']
    );

    $data = api_call('user', 'get_following', $params, true);
    $_data['users'] = $data['data'];
?>

<style>
    #trainingDay {overflow: hidden; font-family: helvetica; }
    #trainingDay h2{padding-top: 15px;text-transform: uppercase;font-weight: 100;text-align: center;width: 232px;margin: 0px auto;position: relative;font-size: 18px;}
    #trainingDay h1{letter-spacing: 0px;font-weight: 100;margin-top: 12px; margin-bottom: 50px; font-size: 23px;}
    #trainingDay ul{width: 620px;margin: 0px auto;margin-top: -20px; position: relative;}
    #trainingDay li{list-style: none;float: left;width: 75px;height: 75px;margin-right: 49px;background-color: #c2c2c2;line-height: 75px;font-size: 25px;color: #fff;position: absolute;overflow: hidden;}
    #trainingDay li img{position: absolute;left: 0;top: 0;margin: 0;width: 100%;}
    .getStartedButton{background-color: #c04158;color: #fff;padding: 8px 35px;width: auto;display: initial;font-size: 25px;font-weight: 100; cursor: pointer;}
    .getStartedButton:hover{opacity: .7; }
    .trainingContent{position: absolute; width: 100%;}
    .trainingContent:nth-child(1) + .trainingContent{left:100%;}
    .trainingContent span{position: relative;}
    .trainingActive{background-color: #c04158;color: #fff;position: absolute;height: 100%;width: 112px;margin-top: -7px;left: 7px;}
    #rainGutter{position: absolute; width:1000px; left: 50%; margin-left: -500px; top: 316px;}
    .userDrop{width: 190px; height:220px; position: absolute;overflow: hidden; top:-500px;text-align: center;}
    .dropAvatarFrame{ width: 63%;height: 119px;overflow: hidden;border-radius: 100px; border:#e9edf0 thin solid; margin: 0px auto;margin-top: 20px;}
    .dropAvatarFrame img{width: 100%;}
    .dropUsername{width: 100%;text-align: center;font-size: 18px;}
    .seeyah{left: -100%;}
    .hello{left: 0%;}
    .dropToggleFollow{text-align: center;display: inline-block;padding: 5px 20px;font-size: 12px; cursor: pointer;color: #c04158;border: #c04158 thin solid;}
    .isDropFollowing{color: #A8A8A8; border: #A8A8A8 thin solid;}
    .enterSiteButton{background-color: #000; color: #fff; display: none; position: absolute;bottom: 70px;left: 50%;margin-left: -62px;font-size: 18px;padding: 7px 18px;}
    .enterSiteButton:hover{opacity:.7;}
    #skipButton{position: absolute; right: 40px; left: 50%; margin-left: -500px; bottom: 10px; text-align: right;}
    #skipButton p{font-size: 16px;background-color: #fff;padding: 4px 20px;border: #000 thin solid;float: right;}
    #inspireSection{margin-top: -73px;}
</style>

<div id="trainingDay" class="lessonBox">
    <div class="trainingContent">
        <h2 style="color: #c04158; width: 300px;">WELCOME <?= $_SESSION['user']['username'] ?></h2>
        <h1>READY TO START INSPIRING NEW FASHION?</h1>
        <div class="getStartedButton">GET STARTED</div>
    </div>
    <div class="trainingContent">
        <h2>
            <div class="trainingActive"></div>
            <span style="color: #fff;">1. INSPIRE</span>
            <span style="margin-left: 15px;">2. FOLLOW</span>
        </h2>
        <h1>POST IMAGES TO INSPIRE NEW FASHION</h1>
        <ul>
            <li style="z-index: 10;">1</li>
            <li>2</li>
            <li>3</li>
            <li>4</li>
            <li>5</li>
        </ul>
    </div>
    <div id="skipButton"><a href="/spine"><p>SKIP</p></a></div>
</div>
<div id="inspireSection"></div>

<div id="rainGutter"></div>

<?php include "footer.php" ?>

<script>
function getStarted() {
    this.$frames = $('#trainingDay li');
    this.$rainGutter = $('#rainGutter');
    this.$stepOne = $('.trainingContent span').eq(0).first();
    this.$stepTwo = $('.trainingContent span').eq(1).last();
    this.$inspire = $('#inspireSection');
    this.usersPerRow = 5;


    this.init();
}

getStarted.prototype.init = function() {
    var _this = this;

    this.$inspire.on('click', '.postButton', this.addPost);
    this.$inspire.on('click', '.postPostingWrap', function(e) {
        e.preventDefault();
        alert('Your image has been posted and will be visible on your profile');
    });
    $('#trainingDay').prependTo('body').slideDown(200);
    $('.getStartedButton').bind('click', function() {
        setTimeout(function(){
            $('body').append('<div id="bankBucket"></div>');
            $('#inspireSection').load('/inspire?get_started=true');
        }, 400);
        setTimeout(function() {
            $('.trainingContent').first().animate({left: '-'+100+'%'}, 300,  function(){
                setTimeout(function() {
                    _this.spreadFrames( _this.$frames.eq(1) );
                }, 1000);
                $(this).remove();
            }).next().animate({left:0}, 300);
        }, 10);
    });

    $('#rainGutter').on('click', '.dropToggleFollow', this.toggleFollow);
}

getStarted.prototype.setUsersToFollow = function(data) {
    this.usersToFollow = data;
}

getStarted.prototype.spreadFrames = function(pic) {
    var _this = this;

    if( $('.opened').length < this.$frames.length-1 ) {
        pic.animate({'left': (pic.prev().position().left + 125) }, 200, function() {
            $(this).addClass('opened');
            _this.spreadFrames(_this.$frames.eq($('.opened').length+1) );
        });
    }
}

getStarted.prototype.animateLeft = function(pic) {
    var _this = this;

    $(pic).animate({left: '-'+100+'%'}, 200, function() {
        $(pic).remove();
        if( $('#trainingDay li').length > 0 ) {
            _this.animateLeft( $('#trainingDay li').first() );
        } else {
            $('#trainingDay h1').slideUp(200, function() {
                var __this = this;
                $('.trainingActive').animate({left: ($('#trainingDay h2 span').last().position().left + 6)}, 300, function() {
                    _this.$stepOne.css('color', '#000');
                    _this.$stepTwo.css('color', '#FFF');
                    $(__this).html('WE RECOMMEND THAT YOU FOLLOW THE FOLLOWING BADASS MEMBERS');
                    $(__this).slideDown(400);
                    _this.makeItRain();
                });
            });
        }
    });
}

getStarted.prototype.moveToStepTwo = function() {
    var _this = this;

    sendToAnal({name:'Step One completed'});
    this.$inspire.fadeOut(200);
    setTimeout(function() {
        _this.animateLeft( _this.$frames.first() );
    }, 100);

    $('.trainingContent').first().addClass('seeyah').on('webkitTransitionEnd', function(){
        $(this).remove();
    });
}

getStarted.prototype.addPost = function() {
    $("<img src='"+$(this).parent().find('img').attr('src')+"'>").appendTo( startingGuide.$frames.eq( $('.trainingPostComplete').length ).addClass('trainingPostComplete') );

    if($('.trainingPostComplete').length == 5) {
        setTimeout(function() {
            startingGuide.moveToStepTwo();
        }, 200);
    }
}

getStarted.prototype.makeItRain = function() {
    var _this = this;
    var leftTemps = [0, 200, 400, 600, 800];

    $.each(this.usersToFollow, function(index, user) {
        var str = '<div class="userDrop" style="left:'+leftTemps[index % _this.usersPerRow]+'px"><div class="dropAvatarFrame"><img src="'+user.avatar+'&width=100"></div><div class="dropUsername">'+user.username+'</div><div class="dropToggleFollow isDropFollowing" data-id="'+user.user_id+'">FOLLOWING</div></div>';
        _this.$rainGutter.append(str);
    });

    this.animateFalling( $('.userDrop').first() );
}

getStarted.prototype.animateFalling = function(drop) {
    var _this = this;
    var topDist = Math.floor($('.dropped').length / this.usersPerRow) * $('.dropped').height();
    drop.animate({top:topDist}, 200, function() {
        if( $(this).next().length ) {
            _this.animateFalling($(this).next());
        } else {
            _this.showEnterButton();
        }
    }).addClass('dropped');
}

getStarted.prototype.showEnterButton = function() {
    $('#trainingDay').append( '<a href="/spine"><div class="enterSiteButton">ENTER SITE</div></a>' );
    $('.enterSiteButton').fadeIn(400);
}

getStarted.prototype.toggleFollow = function() {
    var $button = $(this);
    var is_following = $button.hasClass('isDropFollowing');
    var id = Number( $button.data('id') );

    if(is_following) {
        $button.removeClass('isDropFollowing').html('FOLLOW');
        api.followUser(id);
    } else {
        $button.addClass('isDropFollowing').html('FOLLOWING');
        api.unfollowUser(id);
    }
}


$(function() {
    startingGuide = new getStarted();
    startingGuide.setUsersToFollow(<?= json_encode($_data['users']) ?>);
    $('.header').on('click', 'a', function(e) {
        e.preventDefault();
        e.stopPropagation();
        alert('Press the red "GET STARTED" button to well, get started:)');
    })
});



</script>