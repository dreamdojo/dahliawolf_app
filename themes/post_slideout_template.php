
<style>
.bank-frame{position:relative;min-height: 200px;}
.bankPosted{position: relative;top: 27%;width: 100%;font-family: futura, Arial, Helvetica, sans-serif; margin-left: 12px;}
.bankInnerPosted{font-size: 40px;margin-bottom: -10px; }
.bankshare{font-size: 20px;margin-top: 30px;}
.bankExplain{position: relative;top: 42%;font-size: 14px;width: 230px;left: 50%;margin-left: -103px;}
.banklink{ font-size: 16px;margin-top: 10px;}
.banklink a{color: #fff;background-color: #ff406d;padding: 4px 32px;margin-top: 0px;}
#thePercentageContainer{position: absolute;height: 100%;top: 0px;background-color: #c2c2c2;left: 0px;width: 100%;}
#thePercentageBar{position: absolute;height: 100%;background-color: #FA9B9B;width: 100%;top: 0px; width: 0%;}
#PercentageCounter{position: absolute; width: 100px; left: 50%; margin-left: -50px;font-size: 27px;line-height: 55px;color: #fff; z-index: 1;}
#PercentageCounter p{margin-bottom: 0px;height: 60px;}
#closeUpload{position: absolute;top: 7px;background-color: #000;color: #fff;right: 10px;font-size: 20px;border: #fff 3px solid;z-index: 10;padding: 8px 15px;border-radius: 42px;z-index: 1; cursor: pointer;}
.uploadPreview-frame img{ width:100%;}
.view-upload-button{float: left;background-color: #ff416d;font-size: 15px;color: #fff;height: 21px;margin-top: -24px;line-height: 20px;padding: 0px 10px;}
.bar-frame{height: 45px;background-color: #fff;float: left;width: 750px;margin-top: 6px;margin-left: 10px;}
.title-roll{background-color: #e4e2e3;padding: 12px;font-size: 22px; position: fixed;width: 975px;z-index: 1; font-weight:bold;}
.gridzy{height: 350px;width: 325px;overflow: hidden;float: left;}
.gridzy .b-roll-img{min-height: 100%;width: 100%;}
.gridzy .tag{height: 60px; margin-left: -55px;position: absolute;top: 35px; left: 95%;}
.first{ margin-top:55px;}
#viewToggle{height: 30px;width: 65px;position: absolute;right: 0px;top: 9px;margin-right: 20px; cursor:pointer;}
.toggleViewGrid{ background-image:url(/images/view_toggle.png); background-size:100% 100%;}
.toggleViewLine{ background-image:url(/images/view_toggle2.png); background-size:100% 100%;}
#inspireBackButton{ position: absolute;left: 20px;height: 30px;width: 70px;margin-top: -3px;background-image: url(/images/inspireBackButton.png);background-size: 100% 100%;background-repeat: no-repeat; cursor:pointer;}
#inspireBackButton:hover{ opacity:.7;}
.bankExplain a{color:#ff406d;}
.postPostingWrap{position: absolute;width: 100%;text-align: center;top: 25%;}
#sparticus{ position: fixed; height: 500px; width: 300px;}
</style>


<form action="action/post_image.php" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">
<div id="theFork">
    <div class="animated-word">INSPIRE NEW FASHION</div>
</div>

<div id="bank-roll">
</div>

<div id="bank-overlay">
</div>

<div id="post-me">
	<div id="u-clsr" onclick="imgUpload.closeMe()">X</div>
    <div class="uploader-frame">
    	<img id="user-uploaded-img" />
    </div>
    
        <input type="hidden" name="subpin" value="1">       
        <div style="text-align: center;"><textarea name="description" id="comment">#dahliawolf</textarea></div>
        <div style="text-align: center;padding-bottom: 25px; margin-top: 10px;"><input name="submit" type="image" src="/images/postitbtn2.png" onclick="$(this).hide()" id="image-sub"></div>
</div>
</form>
<script>
	
	function new_loginscreen(){
        sendToAnal({name:'Hit login Wall'});
		$('#mask').fadeIn(200, function(){
			$('#sign-up-modal').show();
			$('#mask').bind('click', close_new_loginscreen);
		});
	}
	function close_new_loginscreen(){
		$('#mask').fadeOut(100);
		$('#sign-up-modal').fadeOut(100);
		$('#mask').unbind('click');
	}
	
	$('body').on('dragover', function(e){
		e.preventDefault();
		e.stopPropagation();
	});
	$('body').on('dragenter', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});
	
	$('body').on('drop', function(e){
		if(e.originalEvent.dataTransfer){
			if(e.originalEvent.dataTransfer.files.length) {
				e.preventDefault();
				e.stopPropagation();
				imgUpload.files = e.originalEvent.dataTransfer.files;
				imgUpload.submitImage( e.originalEvent.dataTransfer.files[0]);
			}   
		}
	});
	
	//********** OLD VERSION **************************
    var imgUpload = new Object();
	imgUpload.isOpen = false;
	imgUpload.outlet = $('#post-me');
	imgUpload.theForm = $('#thePinForm')[0];
	imgUpload.uploadButton = $('#uploadButton');
	imgUpload.xfers = new Array();
	imgUpload.isAvailable = true;
	imgUpload.index = 0;
	
	imgUpload.loadImage = iuLoader;
	imgUpload.showMe = uiShow;
	imgUpload.closeMe = uiHide;
	imgUpload.userUpload = userUpload;
	imgUpload.submitImage = submitImage;
	
	imgUpload.uploadButton.bind('click', imgUpload.userUpload);

    imgUpload.checkFile = function(file) {
        var ext = file.name.split('.').pop().toLowerCase();

        if(ext !== 'jpg' && ext !== 'gif' && ext !== 'png' && ext !== 'jpeg' ) {
            alert('Invalid File Type');
            return false;
        } else if(file.size < 1000) {
            alert('File is too small');
            return false;
        } else if(file.size > 5000000);
        return true;
    }
	
	function submitImage(file){
		if( !imgUpload.checkFile(file) ) {
            return 0;
        }

        if(theUser.id && imgUpload.isAvailable){
            sendToAnal({name:'Uploaded an Image'});
            imgUpload.isAvailable = false;

			URL = 'action/post_image.php?ajax=true';
			
			MyForm = new FormData();
			MyForm.append("iurl", file);
			
			imgUpload.oReq = new XMLHttpRequest();
			imgUpload.oReq.upload.reader =  new FileReader();
			
			imgUpload.oReq.upload.file = file;
			
			imgUpload.oReq.upload.showPreview = showPreview; 
			
			imgUpload.oReq.upload.addEventListener("loadstart", transferStart, false);
			imgUpload.oReq.upload.addEventListener("progress", transferUpdate, false);
			imgUpload.oReq.onreadystatechange = transferComplete;
			
			imgUpload.oReq.open("POST", URL);
			imgUpload.oReq.send(MyForm);
			
		}else{
			new_loginscreen();
		}
	}

    imgUpload.closeUpload = function() {
        imgUpload.container.fadeOut(200, function() {
            imgUpload.container.remove();
        });
    }
	
	function transferStart(e){
		imgUpload.container = $('<div id="thePercentageContainer"></div>').appendTo('#bankOptions');
        imgUpload.container.append('<div id="PercentageCounter"><div>').append('<div id="thePercentageBar"></div>').append('<div id="closeUpload">X</div>');
        $('#closeUpload').bind('click', imgUpload.closeUpload);
	}
	function transferUpdate(e){
		$('#thePercentageBar').css('width', ((e.loaded/e.total)*100)+'%');
        $('#PercentageCounter').html( Math.ceil( ((e.loaded/e.total)*100) ) +'%' );
	}
	function transferComplete(){
		if( this.readyState == 4){
            var data = $.parseJSON(this.responseText);
            console.log(data);
            if(data.success) {
                setTimeout(function() {
                    $('#thePercentageContainer').remove();
                    var _data = data.data;
                    var str = '<div class="postFrame grid" draggable="true" ondragstart="drag(event);"><div class="postButton" style="display: none;">POST</div>';
                    str+= '<img src="'+_data.new_image_url+'" style="opacity: 0.6;"><div class="postPostingWrap"><div class="bankPosted">' +
                        '<p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+_data.posting_id+'">VIEW POST</a></p></div>' +
                        '<div class="bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+dahliawolf.username+'">profile</a>' +
                        '<p class="bankshare"><a href="#" onclick="sendMessageProduct('+_data.posting_id+')"><img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a>' +
                        '<a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#">' +
                        '<img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div></div>';
                    $('#bankBucket').prepend(str);
                }, 1000);
            } else {
                imgUpload.closeUpload();
                alert(data.errors);
            }
			imgUpload.isAvailable = true;
		}
	}
	
	function userUpload(){
		$('#file').click();
	}
	
	function uiShow(){
		this.outlet.show();
		this.isOpen = true;
	}
	
	function uiHide(){
		this.outlet.hide();
		this.theForm.reset();
		this.isOpen = false;
	}
	
	function showPreview(){
		this.reader.onload = function (e) {
			jQuery('#uploadPreview-'+imgUpload.index).attr('src', e.target.result);
			//stopLoad();
		}
		this.reader.readAsDataURL(this.file);
	}
	
	function iuLoader(input){
		this.showMe();
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				jQuery('#user-uploaded-img').attr('src', e.target.result);
				stopLoad();
			}
			reader.readAsDataURL(input.files[0]);
		} 
	}
</script>