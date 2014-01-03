<style>
    textarea, input{padding:0px;}
	#pop-com{width: 400px; height: 80px; font-size: 12px;}
		
</style>


   <div id="upoload-img-box">
   <div style="margin-bottom:5px; float: right;"><a onclick="postBox.closeMe();"><img src="/skin/img/closegray.png"></a></div>
   <form action="blop" onsubmit="return theBank.postImage(<?= $_GET['id'] ?>, $('#pop-com').val())" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">
    <div style="width:600px; margin: 0 auto;">
         <div id="upload-img-frame"><img src="<?= $_GET['theurl'] ?>" width="100%"></div>
         <div style="width: 100%; text-align: center;margin-top: 5px;">
             <textarea id="pop-com" name="description" placeholder="Rep Yo Steez" ></textarea>
         </div>
         <div style="margin-top: 5px;">
        	<div style="padding-top: 7px; text-align: center;">
        		<?
        		/*
				<img name="submit" src="/skin/img/postitbtn2.png" style="border:none;margin-top: 10px; cursor: pointer" onclick="$(this).closest('form').submit()" id="import-butt">
        		*/
        		?>
        		<input type="image" src="/images/btn/post-image-red.jpg" id="sub-pop-butt" style="width: 200px; border:none;margin-top: 10px; cursor: pointer" />
        	</div>
            <input type="submit" style="display:none" id="form-sub">
   		</div>
    </div>
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />  
</form>
</div>