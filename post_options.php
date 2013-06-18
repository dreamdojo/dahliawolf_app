<style>
    textarea, input{padding:0px;}
	#pop-com{width: 400px; height: 80px; font-size: 12px;}
	.options-frame{width:100%;}
	.clser{position: absolute;right: 41px;margin-top: -26px;}
</style>


<div class="options-frame">
   <div class="clser"><a onclick="postBox.closeMe(<?= $_GET['id'] ?>);"><img src="/skin/img/closegray.png"></a></div>
       <form action="blop" onsubmit="return theBank.postImage(<?= $_GET['id'] ?>, $('#pop-com-<?= $_GET['id'] ?>').val() )" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">
            <div style="width:600px; margin: 0 auto;">
                 <div style="width: 100%; text-align: center;margin-top: 5px;">
                     <textarea id="pop-com-<?= $_GET['id'] ?>" class="socialize" name="description" placeholder="Write something! Don't be lazy." ></textarea>
                 </div>
                 <div style="margin-top: 5px;">
                    <div style="padding-top: 7px; text-align: center;">
                        <input type="image" src="/images/btn/post-image-red.jpg" id="sub-pop-butt-<?= $_GET['id'] ?>" style="width: 200px; border:none;margin-top: 10px; cursor: pointer" />
                    </div>
                    <input type="submit" style="display:none" id="form-sub">
                </div>
            </div>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />  
        </form>
</div>
<script>
$('.socialize').bind('click', pplFinder.start);
</script>