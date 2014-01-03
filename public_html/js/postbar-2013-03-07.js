var feedIndex = 100;
var FEEDIMGWIDTH = 195;


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

function post_image(src, name){
	if(src && src != ''){
		$.post('action/ajax_post_image.php', { src: src, name: name}).done(function(data){
			console.log(data);
		});
	}
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

function refillImages(){// GET MORE IMAGES FROM DAHLIA WOLF REPOSITORY *****************************
			ajax_loading = true;
				var URLFILL = "includes/php/ajax_getFeed.php";
				$.ajax({
				   url: URLFILL,
				   context: document.body
				}).done(function(data){
					for(i = 0; i < data.data.length;i++){
						if(data.data[i].baseurl){
							appendStr = '<div class="'+data.source+' soc-img-frame" id="imgFrame-'+(i+feedIndex)+'"><img src="'+data.data[i].baseurl+'" style="width: 100%; position:absolute; min-height:180px;" onclick="post_image(\''+data.data[i].baseurl+'\', \''+data.data[i].imagename+'\')">';
							$('#scroll-src').append(appendStr);
							$('#inst-butt').hide();
							$('#pint-butt').hide();
						}
					}
					$('#filter-cover').hide();
					$('.right-arrow').show();
					console.log(data);
					ajax_loading = false;
				});
				$('#scroll-src').width($('#scroll-src').width()+10500);
		}

function preview_image(input) {// PREVIEW IMAGE USER HAS UPLOADED ****************************************
	if (input.files && input.files[0]) {
		doLoad('Uploading...');
		var reader = new FileReader();
		reader.onload = function (e) {
			jQuery('#uploader-img').attr('src', e.target.result);
			stopLoad();
		}
		reader.readAsDataURL(input.files[0]);
		photo.set = 1;
	} 
}