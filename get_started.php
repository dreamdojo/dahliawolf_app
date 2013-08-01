<?
    include "head.php";
    include "header.php";
    include "post_slideout.php";
?>

<style>
    #trainingDay {overflow: hidden;}
    #trainingDay h2{padding-top: 15px;text-transform: uppercase;font-weight: 100;text-align: center;}
    #trainingDay h1{letter-spacing: 0px;font-weight: 100;margin-top: 0px; margin-bottom: 50px;}
    .getStartedButton{background-color: #000;color: #fff;padding: 8px 35px;width: auto;display: initial;font-size: 25px;font-weight: 100; cursor: pointer;}
    .getStartedButton:hover{opacity: .7; }
    .trainingContent{position: absolute; width: 100%;}
    .trainingContent:nth-child(1) + .trainingContent{left:100%;}
    @keyframes offToTheLeft { from {left: 0%;} to {left: -100%;}}
    @keyframes deadCenter { from {left: 100%;} to {left: 0%;}}
    @-webkit-keyframes offToTheLeft { from {left: 0%;} to {left: -100%;} }
    @-webkit-keyframes deadCenter { from {left: 100%;} to {left: 0%;} }
    .seeyah{animation: offToTheLeft 1s;-webkit-animation: offToTheLeft 1s;left:-100%;}
    .hello{animation:deadCenter 1s; -webkit-animation: deadCenter 1s; left: 0px;}
</style>

<div id="trainingDay" class="lessonBox">
    <div class="trainingContent">
        <h2>WELCOME <?= $_SESSION['user']['username'] ?></h2>
        <h1>READY TO START INSPIRING NEW FASHION</h1>
        <div class="getStartedButton">GET STARTED</div>
    </div>
    <div class="trainingContent">
        <h2>1. INSPIRE > 2. FOLLOW</h2>
        <h1>POST IMAGES TO INSPIRE NEW FASHION</h1>
    </div>

</div>

<?php include "footer.php" ?>

<script>
function getStarted() {

    this.init();
}

getStarted.prototype.init = function() {

    theLesson.isOpen = true;
    $('#trainingDay').slideDown(200);
    $('.getStartedButton').bind('click', function() {
        thePost.buttonPushed();
        $('.trainingContent').first().addClass('seeyah').on('webkitAnimationEnd', function(){
            $(this).remove();
        }).next().addClass('hello');
    });
}


$(function() {
    startingGuide = new getStarted();
});



</script>