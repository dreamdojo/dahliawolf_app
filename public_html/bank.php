<?
    $pageTitle = "Inspire";
    if( !isset($_GET['get_started']) ) {
        include "head.php";
        include "header.php";
    }
?>
<style>
    #bankOptions{height:60px; width:100%; display:none; overflow:hidden;position: relative;z-index: 100;margin-top: 0px;border-bottom: #b6b6b6 1px solid;}
    #bankCenter{height:60px; max-width: 1100px;width: 100%; margin:0px auto;}
    #bankCenter .bankSection{ width:24%; height:81%; float:left; border-right:#b6b6b6 1px solid;padding-top: 11px; color:rgb(104, 104, 104);}
    #bankCenter .bankSection:hover{background-color:#ebebeb;}
    .no-right-border{border-right:none !important;}
    .bankSection p{font-size: 13px;margin-top: 9px;margin-left: 10px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
    .bankSection img{float: left;margin-left: 10px;margin-right: 10px;}
    #dndeezy{border: #777777 2px dotted;width: 80%;margin-left: 10%;border-radius: 8px;text-align: center;margin-top: -4px;min-height: 80%;}
    #getPinterestName{ position:absolute; left:-100%; height:100%; width:100%;background-color: #fff;top: 0px;}
    #importFromPinterest{ position:relative; overflow:hidden;}
    #thePinterestName{height: 75%;margin-top: 2%;margin-left: 2%;width: 75%;font-size: 14px;text-indent: 3px; float:left;}
    #goPinterestButton{ height:100%; width:20%; float:left; background-image:url(/images/pinterestGo.png); background-size: 86% 80%;background-repeat: no-repeat;background-position: 7%;}
    #bankBucket{width: 100%;max-width: 960px; margin: 0px auto; height: 100%;padding-top: 10px; padding-bottom: 100px;}
    #bankBucket .postFrame{overflow: hidden; position: relative;background-size: auto 100%;background-position: 50%;background-repeat: no-repeat;}
    #bankBucket .postFrame:hover .postButton{display: block;}
    #bankBucket .grid{float: left; width: 300px;height: 300px; margin: 10px;}
    #bankBucket .line{width: 80%; margin: 10px auto;overflow: hidden;margin-bottom: 10px;margin-top: 10px; max-width: 500px;}
    #bankBucket .postFrame img{width: 100%;}
    #bankBucket .postButton{position: absolute; display:none; right: 50%;top: 50%;background-color: #008caf; width: 90px;height: 90px;border-radius: 50px;text-align: center;line-height: 90px;margin-top: -45px;margin-right: -45px;font-size: 15px;cursor: pointer;font-family: futura;font-weight: bolder;color: #fff;}
    #bankBucket .postButton:hover{opacity: .7;}
    #bankBucket h2{text-align: center;width: 80%;margin: 30px auto;}
    #bankBucket .postSource{position: absolute;bottom: 0px;width: 100%;text-align: center;font-size: 12px;height: 25px;line-height: 25px;background-color: #fff;opacity: .7;color: #000;}
    .option{display: none;}
    #bankOptions{display: block; position: fixed; background-color: #fff;}
    #viewToggle{background-image: url("/images/inspireToggle_BG.png");background-position: 0%;position: absolute;right: -11px;width: 45px;background-repeat: no-repeat;overflow: hidden; height: 30px;margin-right: 20px;top: 2px; cursor: pointer;}
    .title-roll{font-size: 22px;width: 97%; max-width: 940px;z-index: 1;font-weight: bold;margin: 0px auto; top: 10px; margin-bottom: 10px;position: relative;text-align: center; height: 35px; background-color: #fff;}
    .xDomainStatus{position: absolute;height: 100%;width: 100%;background-color: #c2c2c2;z-index: 111;top: 0px;left: 0px;}
    .xDomainStatus p{width: 1000px;margin: 0px auto;font-size: 27px;text-align: center;line-height: 60px;}
    #postTitleContent{font-size:15px; line-height: 35px; text-transform: uppercase;}

    .postFrame .progressCount{font-size: 20px; color: red;line-height: 150px; text-align: center; width: 100%;}
    .loading{background-size: 70% auto !important;}
</style>

<?php
    if(!empty($_GET['fashiolista'])) {
        include_once 'blocks/fashiolista.php';
    }
?>


<!--<div id="bankOptions" class="drop-shadow" style="display: none;">
    <div id="bankCenter">
        <div class="bankSection">
            <img class="fork-img" id="uploadButton" src="/images/select-files.png" style="float: right;" />
            <form id="postUploadForm" action="/public_html/action/post_image.php" method="post" enctype="multipart/form-data">
                <input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onChange="new postUpload(this.files[0]);">
                <input type="hidden" name="takeMeBack" value="takemehome">
            </form>
        </div>
        <div class="bankSection">
            <div id="dndeezy" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="disallowDrop(event)">
                <p>Drag n Drop File Here</p>
            </div>
        </div>
        <div id="importFromPinterest" class="bankSection cursor">
            <img src="/images/tumblr_logo.png" style="width: 31px;">
            <p>Select Images From Your Tumblr</p>
        </div>
        <div id="importFromInstagram" class="bankSection no-right-border cursor">
            <img src="/images/bank-instagram.png">
            <p>Select Images From Your Instagram</p>
        </div>
    </div>
</div>-->

<div class="title-roll"><div id="inspireBackButton" class="hidden"></div><span id="postTitleContent"><span class="preHeader"><?= $_GET['feed'] ?> BANK</span></div>
<div id="bankBucket"></div>

<?php //include "footer.php" ?>
<script>
    $(function() {
        postBank.init({feedType:'<?= $_GET['feed'] ?>'});
    });
</script>