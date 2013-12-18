<!doctype html>
<html>
<head>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<style>
    ul{list-style: none;}
    li{list-style: none;}
    #mainCol{width: 1000px; margin: 0px auto; text-align: center; position: relative;}
    .robot{text-align: right;margin-right: 190px;font-size: 28px;font-family: helvetica;}
    #geoBotCommands li{list-style: none;width: 300px;border: blue 5px solid;border-radius: 14px;padding: 10px;float: left;cursor: pointer;margin-right: 10px;margin-bottom: 10px;}
    #geoBotCommands li:hover{border-color: lightblue;}
    .actionInput{position: absolute; border: #000 5px solid; display: none;top: 11%;left: 55%; text-align: left;-webkit-margin-before: 0px;-webkit-padding-start: 10px;padding-right: 10px;}
    .actionInput label{float: left;}
    .actionInput li{padding: 10px 0px;}
    .actionInput input{margin-left: 5px;width: 100px;}
    .actionInput button{width: 160px; padding: 10px;}
    #loader{position: absolute;top: 11%;color: red;font-size: 21px;width: 145px;left: 13%;border: #000 5px solid;border-radius: 21%;padding: 15px; display: none;}
</style>
<?php include_once "bots.php"; ?>
<body>
    <div id="mainCol">
        <div id="loader">IM WORKING ON IT FOO!!!</div>
        <div class="talkBubble">I AM GEOBOT!!!</div>
        <img class="robot" src="images/robot.jpg" width="30%;">
        <ul id="showLoveInput" class="actionInput">
            <li><label>POST: </label><input id="posting_id"></li>
            <li><label>BOTS: </label><input id="posting_love_bot_count"></li>
            <li><button id="submitLoves">DO IT</button></li>
        </ul>

        <ul id="geoBotCommands">
            <li id="postAddLoves">LOVE POST</li>
            <li>FOLLOW</li>
            <li>COMMENT</li>
            <li>MAKE BOTS</li>
        </ul>
    </div>
</body>
</html>
<script>
    function geobot(bots) {
        this.bots = bots;

        $('#postAddLoves').on('click', function() {
            $('#showLoveInput').fadeIn(200);
        });
        $('#submitLoves').on('click', this.lovePost);
    }

    geobot.prototype = {
        get botLimit() {return this.bots.length}
    }

    geobot.prototype.listBots = function() {
        console.log(this.bots);
    }

    geobot.prototype.showLoader = function() {
        $('#loader').fadeIn(200);
    }

    geobot.prototype.hideLoader = function() {
        $('#loader').fadeOut(200);
    }

    geobot.prototype.lovePost = function() {
        var id = Number( $('#posting_id').val() );
        var count = Number( $('#posting_love_bot_count').val() );
        if(id && count && count < Geobot.bots.length) {
            $('#showLoveInput').hide();
            $('#posting_id').val('');
            $('#posting_love_bot_count').val('');
            Geobot.showLoader();
            $.post('addLikes.php',{posting_id:id, limit:count}, function(data) {
                Geobot.hideLoader();
            });
        } else {
            alert('YOU FORGOT SUMPIN PUMPAH');
        }
    }

    $(function() {
        Geobot = new geobot(<?= json_encode($geobots) ?>);
    });
</script>