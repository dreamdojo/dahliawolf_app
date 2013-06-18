<?
$pageTitle = "Post Menu - Dahlia\Wolf";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";   
?>

<style>
.pm-opt{ background:url(images/pm_bg.jpg) repeat; background-size:auto 100%;height: 105px; width: 100%;margin-top: 10px; position:relative;}
.pm-block{height: 81%;width: 100%; margin:0px auto;}
#pm-tap{background: url(../mobile/images/pm-tap.png) no-repeat 46% 75%;background-size: 54%;}
#pm-cr{background: url(../mobile/images/pm-cr.png) no-repeat 46% 75%;background-size: 54%;}
#pm-dw{background: url(../mobile/images/pm-dw.png) no-repeat 46% 75%;background-size: 54%;}
</style>

	<div class="activity-bar">POST</div>
    <div class="pm-opt">
    	<form action="../action/post_image.php" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">
        	<input type="file" name="iurl" id="file" accept="image/*" capture="camera" style="display:none" onchange="$('#thePinForm').submit();">
            <input type="hidden" name="subpin" value="1">
            <textarea name="description" id="comment" style="display:none">#dahliawolf</textarea>
        </form>
    	<div class="pm-block" id="pm-tap" onclick="$('#file').click()"></div>
    </div>
    <div class="pm-opt" onclick="$('#file').click();">
    	<div class="pm-block" id="pm-cr"></div>
    </div>
    <a href="post-bank.php">
    	<div class="pm-opt">
    		<div class="pm-block" id="pm-dw"></div>
    	</div>
    </a>
<? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>