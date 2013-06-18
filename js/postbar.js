var feedIndex = 100;
var FEEDIMGWIDTH = 195;
var post_mode = 'spine';


function loadFeed(feedSrc, feedBox){//LOAD FEED FROM USERS PINTEREST OR INSTAGRAM ***************************************
	var theFeed = new Array;
	theFeed['instagram'] = 'getfeedfrominstagram.php';
	theFeed['pinterest'] = 'getfeedfrompinterest.php';
	doLoad('Loading...');
	
	$.getJSON(theFeed[feedSrc], function(feedArray){	
		if(feedBox && feedArray){
			feedBox.empty();
			feedBox.width(feedArray.data.length*FEEDIMGWIDTH);
			if(feedBox.width()>window.innerWidth){
				$('.right-arrow').show()
			}
			$('#filter-cover').hide();
			$('#img-uploader').fadeOut(100);
			for(i = 0; i < feedArray.data.length;i++){
				if(feedArray.data[i].images.standard_resolution.url){
					appendStr = '<div class="img-feed-frame" class="'+feedSrc+' soc-img-frame" id="imgFrame-'+(i+feedIndex)+'"><img src="'+feedArray.data[i].images.thumbnail.url+'" style="width: 100%; position:absolute; min-height:180px;" onclick="post_image("")">';
					feedBox.append(appendStr);
					$('#inst-butt').hide();
					$('#pint-butt').hide();
					bind_feed();
					stopLoad();
				}
			}
		}
	});
}

function post_image(id, description){// ************************* AJAX CALL TO POST IMAGE AND DELETE FROM IMAGE BANK
	if(id && id != ''){
		image = $('#post-image-'+id);
		$('#upoload-img-box').hide();
		$.post('action/post_feed_image.php', { id: id, description: description}).done(function(){
			$('#imgFrame-'+id).animate({width:0}, 400, function(){
				$('#imgFrame-'+id).remove();
				$('#thePinForm')[0].reset();
				
				// Check current #scroll-src state
				$scroll_src = $('#scroll-src');
				var domain_keyword = $scroll_src.data('domain_keyword');
				var user_id = $scroll_src.data('user_id');
				
				if (user_id) {
					refillImages(domain_keyword, user_id);
				}
				else {
					refillImages(domain_keyword);
				}
				
				update_user_points(20);
				if(post_mode == 'welcome'){
					increaseCount(image);
				}
			});
		});
	}else{
		console.log('sumpin missing')
	}
	return false;
}

function like_post(id){
	if(id && id > 0){
		$.post('action/like.php', { posting_id: id}).done(function(data){
			l_cnt = parseInt($.trim($('#like-count-'+id).html()));
			l_cnt++;
			$('#like-count-'+id).html(l_cnt);
			$('#link-'+id).css('background', 'url(../images/heart.png) no-repeat 0 0');
			console.log(data);
		});
	}
}


function preview_image(input) {// PREVIEW IMAGE USER HAS UPLOADED ****************************************
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			jQuery('#uploader-img').attr('src', e.target.result);
			stopLoad();
		}
		reader.readAsDataURL(input.files[0]);
		photo.set = 1;
	} 
}