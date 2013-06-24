//********************************* toggle Login
function userLogin () {
	this.view = $('#loginPage');
	this.displayError = $('#loginErrorCode');
	this.signUpView = $('#signUpForm');
	this.loginView = $('#loginForm');
	this.toggleButton = $('#toggleLoginType');
	this.loginMsg = $('#loginMsg');
	this.fbHolder = $('.faceBookLoginPlace img');
	
	$('.login-place').bind('tap', $.proxy(this.toggleWindow, this) );
	$('#closeLoginPop').bind('tap', $.proxy(this.toggleWindow, this) );
	$('#toggleLoginType').bind('tap', $.proxy(this.toggleLoginForm, this) );
	$('#signUpForm').submit(this.submitNewUser);
	$('#loginForm').submit(this.loginUser);
}

userLogin.prototype.toggleLoginForm = function() {
	if( this.signUpView.hasClass('hidden') ){
		this.signUpView.removeClass('hidden');
		this.loginView.addClass('hidden');
		this.toggleButton.html('Login');
		this.loginMsg.html('or Register with email');
		this.fbHolder.attr('src', '/skin/img/signinfacebook.png');
	} else {
		this.signUpView.addClass('hidden');
		this.loginView.removeClass('hidden');
		this.toggleButton.html('Register');
		this.loginMsg.html('or Login with email');
		this.fbHolder.attr('src', 'http://www.dahliawolf.com/images/signinfacebook2.png');
	}
}

userLogin.prototype.loginUser = function(e) {
    e.preventDefault();
	$('#loginErrorCode').empty();
	var formdata = new Array();
	formdata = $(e.target).serializeArray();
	
	var username = formdata[0].value.trim();
	var password = formdata[1].value.trim();
	
	$.post( $(e.target).attr('action'), {identity : username, credential : password, ajax : true}, function(data){
		var result = $.parseJSON(data);
		if (!result.success) {
			var str = '';
			$.each(result.errors, function(index, error){
				str += error;
			});
			$('#loginErrorCode').html(str);
		} else {
			document.location.reload();
		}
	});
}


userLogin.prototype.submitNewUser = function(e) {
    e.preventDefault();
	$('#loginErrorCode').empty();
	var formdata = new Array();
	formdata = $(e.target).serializeArray();
	
	var username = formdata[0].value.trim();
	var email = formdata[1].value.trim();
	var password = formdata[2].value.trim();
	
	$.post( $(e.target).attr('action'), {user_username : username, user_email : email,  user_password : password, ajax : true}, function(data){
		var result = $.parseJSON(data);
		if (!result.success) {
			var str = '';
			$.each(result.errors, function(index, error){
				str += error;
			});
			$('#loginErrorCode').html(str);
		} else {
			document.location.reload();
		}
	});
}

userLogin.prototype.toggleWindow = function() {
	var $this = this
	if(!this.view.is(':visible') ) {
		this.view.show().animate({'bottom' : 0 + '%'}, 400);
	} else {
		this.view.animate({'bottom' : '-'+100+'%'}, 400, function(){
			$(this).hide();
			$this.displayError.empty();
		});
	}
}

//*********************************  post image
function m_post_image(id, description){// ************************* AJAX CALL TO POST IMAGE AND DELETE FROM IMAGE BANK
	if(id && id != ''){
		$.post('../action/post_feed_image.php', { id: id, description: description}).done(function(){
			document.location = 'post-bank.php';
		});
	}else{
		//if no id
	}
	return false;
}
//*******************************************************************************************************************************************
ajax_loading = false;
function m_refillImages(){// GET MORE IMAGES FROM DAHLIA WOLF REPOSITORY *****************************
	if(!ajax_loading){
		domain_keyword = 'pinterest';
		offset=0;
		ajax_loading = true;
		
		var URLFILL = "../includes/php/m_ajax_getFeed.php?offset=" + offset;
		if (domain_keyword) {
			URLFILL += '&domain_keyword=' + domain_keyword;
		}
		if (user_id) {
			//URLFILL += '&user_id=' +user_id;
		}
		console.log(URLFILL)
		$.ajax({
		   url: URLFILL,
		   context: document.body
		}).done(function(data){
			for(i = 0; i < data.data.length;i++){
				if(data.data[i].baseurl){
					var src = data.data[i].source + data.data[i].imageURL;
					grid = ((data.data[i].dimensionsX>data.data[i].dimensionsY)? 'height' : 'width');
					appendStr = '<div class="pb-frame '+((i % 3 == 2) ? 'pb-even' : 'pb-odd')+'" id="imgFrame-'+data.data[i].id+'"><a href="post_image.php?id='+data.data[i].id+'&theurl='+src+'"><img id="post-image-'+data.data[i].id+'" src="'+src+'" style="'+grid+':100%"></a></div>';
					$('#feed-wrap').append(appendStr);
				}
			}
			ajax_loading = false;
		});
	}
}
//***********************************************************************************************************************

var feedIndex = 0;
function loadFeed(feedSrc, feedBox){
	var theFeed = new Array;
	theFeed['instagram'] = 'getfeedfrominstagram.php';
	theFeed['pinterest'] = 'getfeedfrompinterest.php';
	$.getJSON(theFeed[feedSrc], function(feedArray){	
		if(feedBox && feedArray){
			feedBox.empty();
			$('#filter-cover').hide();
			$('#img-uploader').fadeOut(100);
			for(i = 0; i < feedArray.data.length;i++){
				if(feedArray.data[i].images.standard_resolution.url){
					appendStr = '<div class="'+feedSrc+' soc-img-frame" id="imgFrame-'+(i)+'"><img src="'+feedArray.data[i].images.thumbnail.url+'" style="width: 100%; position:absolute; min-height:180px;">';
					feedBox.append(appendStr);
				}
			}
			$('.blackout').hide()
		}
	});
}
//***************************************** POST COMMENT **************************************************************
$(document).on('submit', '#m-comform', function(event) {
	var $comment = $('#thecomment');
	
	// comment is required
	if ($comment.val()) {
		var $this = $(this);
		var action = $this.attr('action');
		var data = $this.serialize();
		
		data += '&ajax=1';
		
		$.post(action, data, function(response) {
			response = $.parseJSON(response);
			var $modal_content = $('#modal-content');
			
			$modal_content.load($modal_content.data('href') + '&posted=1');
			
			update_user_points(response.data.points_earned);
		}, 'json').done(function(){
			location.reload();
		});
	}
	
	return false;
});
//*****************************
$("a").click(function (event) {
    event.preventDefault();
    window.location = $(this).attr("href");
});
//*******************************//

function preview_image(input) {
			if (input.files && input.files[0]) {
				$("#loadPage").show();
				var reader = new FileReader();
				reader.onload = function (e) {
					jQuery('#uploader-img').attr('src', e.target.result);
					$("#loadPage").hide();
					$('.img-uploader-image').show();
				}
				reader.readAsDataURL(input.files[0]);
				photo.set = 1;
			} 
		}


function do_unlike(Id, A_L, R_L, likes){
	REM_LIKE(Id, R_L, A_L);				
	$('#wild-img-'+Id).attr('src', 'http://www.dahliawolf.com/skin/img/like.png');
	likes--;
	$('#heart-img-'+Id).attr('onclick', 'do_multi_like("'+Id+'", "'+A_L+'", "'+R_L+'", "'+likes+'")');
	$('#wild-img-'+Id).attr('onclick', 'do_multi_like("'+Id+'", "'+A_L+'", "'+R_L+'", "'+likes+'")');
	$('#heart-img-'+Id).attr('src', 'http://www.dahliawolf.com/skin/img/broken.png');
	$('#chglikes'+Id).html('&nbsp;');
}

function do_multi_like(Id, A_L, R_L, likes) {
	$('#heart-img-'+Id).attr('src', 'http://www.dahliawolf.com/skin/img/heart.png');
	$('#wild-img-'+Id).attr('src', 'http://www.dahliawolf.com/skin/img/wild_like.png');
	$('#wild-img-'+Id).attr('onmouseout', '');
	$('#wild-img-'+Id).attr('onmouseover', '');
	ADD_LIKE(Id, A_L, R_L);
	$('#chglikes'+Id).html(likes);
	likes++;
	$('#heart-img-'+Id).attr('onclick', 'do_unlike("'+Id+'", "'+A_L+'", "'+R_L+'", "'+likes+'")');
	$('#wild-img-'+Id).attr('onclick', 'do_unlike("'+Id+'", "'+A_L+'", "'+R_L+'", "'+likes+'")');
}
function pop_like(Id, likes) {
	A_L = "A_L"+Id;
	R_L = "R_L"+Id;
	do_multi_like(Id, A_L, R_L, likes);
	$('#pop-heart-'+Id).attr('src', 'http://www.dahliawolf.com/skin/img/heart.png');
	$('#pop-heart-'+Id).attr('onclick', 'pop_unlike("'+Id+'", "'+likes+'")');
	likes++;
	$('#pop-like-count-'+Id).html(likes)
}
function pop_unlike(Id, likes) {
	A_L = "A_L"+Id;
	R_L = "R_L"+Id;
	do_unlike(Id, A_L, R_L, likes);
	$('#pop-heart-'+Id).attr('src', 'http://www.dahliawolf.com/skin/img/broken.png');
	$('#pop-heart-'+Id).attr('onclick', 'pop_like("'+Id+'", "'+likes+'")');
	likes--;
	$('#pop-like-count-'+Id).html('&nbsp;');
}
var flag_hover_1 = [false,false,false,false,false,false];
theuserPoints = parseInt('{GetUserPoints()}');

function doLoad(text){
	$('#img-upload-loader').slideDown(200);
	$('#loading-text').empty();
	$('#loading-text').append(text);
}
function goHere(loc, add) {
	if(add){
		document.location = 'http://www.dahliawolf.com/mobile/'+loc+'?session_type=web';
	}else{
		document.location = 'http://www.dahliawolf.com/mobile/'+loc+'&session_type=web';
	}
}

function sendMessage(id) {
	FB.ui({
		  method: 'send',
		  name: 'Check mah swag',
		  link: 'http://www.dahliawolf.com/post/'+id,
	});
}