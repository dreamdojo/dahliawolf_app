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
</style>
<?php include_once "bots.php"; ?>
<body>
    <div id="mainCol">
        <div class="talkBubble">I AM GEOBOT!!!</div>
        <img class="robot" src="images/robot.jpg" width="30%;">
        <ul id="showLoveInput" class="actionInput">
            <li><label>POST: </label><input id="posting_id"></li>
            <li><label>BOTS: </label><input id="posting_id"></li>
            <li><button id="submitLoves">DO IT</button></li>
        </ul>

        <ul id="geoBotCommands">
            <li id="postAddLoves">LOVE POST</li>
            <li>FOLLOW</li>
            <li>COMMENT</li>
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
    }

    geobot.prototype.listBots = function() {
        console.log(this.bots);
    }

    geobot.prototype.lovePost = function() {

    }

    $(function() {
        Geobot = new geobot(<?= json_encode($geobots) ?>);
    });
</script>