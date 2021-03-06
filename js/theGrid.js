/*
 rousted by:
 _______  _______  _______  _______  _______  _______  _______          
(  ____ \(  ____ \(  ___  )(  ____ \(  ____ \(  ____ )(  ____ \|\     /|
| (    \/| (    \/| (   ) || (    \/| (    \/| (    )|| (    \/( \   / )
| |      | (__    | |   | || (__    | (__    | (____)|| (__     \ (_) / 
| | ____ |  __)   | |   | ||  __)   |  __)   |     __)|  __)     \   /  
| | \_  )| (      | |   | || (      | (      | (\ (   | (         ) (   
| (___) || (____/\| (___) || )      | )      | ) \ \__| (____/\   | |   
(_______)(_______/(_______)|/       |/       |/   \__/(_______/   \_/   
                                                                        
																		*/

var theGrid = new Object();
theGrid.posts = new Array();
theGrid.limit = 15;
theGrid.offset = 0;
theGrid.isAvailable = true;
theGrid.viewer_user_id = null;
theGrid.searchTerm = null;
theGrid.sortTerm = null;
theGrid.urls = [];
theGrid.urls['like'] = '/action/like?posting_id=';
theGrid.urls['unlike'] = '/action/unlike?posting_id=';
theGrid.htText = 'style="min-height: 100%; min-width:101%; width:auto;"';
theGrid.$view = $('#theGrid');

theGrid.showLoader = function() {
	//$('#theGrid').append('<div id="theGridLoader"><img src="/images/loading-feed.gif"></div>');
    dahliaLoader.show();
}
theGrid.destroyLoader = function() {
    dahliaLoader.hide();
	//$('#theGridLoader').remove();
}

theGrid.adjustMargins = function() {
    if(window.innerWidth > 320*3) {
        $('#theGrid').width(320*3).css('margin', 0+'px auto');
    }else {
        $('#theGrid').css('margin-left', (window.innerWidth % 320)/2).css('width', 'auto');
    }
}

theGrid.likeAction = function(){
    id = parseInt( $(this).data('id') );
    likeBox = $('#post-'+id).find('.postGridLikeCount');
    likeImage = $('#post-'+id).find('.postGridLikeImage');
    likeCount = parseInt( likeBox.html() );
	_this = $('#post-'+id).find('.vote-frame');
	if(id && id > 0 && theUser.id && theUser.id > 0){
		if( $(_this).hasClass('grid-like') ){
            dahliawolf.post.love(id);
			$(_this).removeClass('grid-like').addClass('grid-unlike').data('action', 'unlike');
            likeImage.removeClass('postGridUnLiked').addClass('postGridLiked');
            likeCount++;
		}else{
            dahliawolf.post.unlove(id);
            likeImage.removeClass('postGridLiked').addClass('postGridUnLiked');
			$(_this).removeClass('grid-unlike').addClass('grid-like').data('action', 'like');
            likeCount--;
		}
        likeBox.html(likeCount);
	}else{
		new_loginscreen();
	}
}

theGrid.getImages = function() {
	if(theGrid.isAvailable){
		theGrid.isAvailable = false;
		
		URL = theGrid.getUrl();
		
		theGrid.showLoader();
		$.getJSON(URL, function(data){
			theGrid.destroyLoader();
			$.each(data, function(index, post){
				theGrid.posts[post.posting_id] = new theGrid.post(post);
                theGrid.adjustMargins();
			});
			theGrid.container.append('<div style="clear:left"></div>');
			theGrid.offset += theGrid.limit;
			theGrid.isAvailable = true;
		});
	}
}

theGrid.getUrl = function() {
	URL = '/action/getFeedGrid.php?limit='+theGrid.limit+'&offset='+theGrid.offset;
	if(theUser.id){
		URL += '&viewer_user_id='+theUser.id;
	}
	if (theGrid.searchTerm) {
		URL += '&q='+theGrid.searchTerm;
		//URL += '&username_like='+theGrid.searchTerm;
	}if(theGrid.sortTerm){
		URL += '&sort='+theGrid.sortTerm;
	}
	return URL;
}
	
// posts object
theGrid.post = function(obj) {
	if(typeof obj == 'object'){
		this.data = obj;
		this.displayPost();
	}
}

theGrid.post.prototype.displayPost = function() {
    str = '<div id=post-'+this.data.posting_id+' class="post-frame color-'+Math.floor(Math.random()*5)+'">';
	str += '<div rel="grid-vote" class="vote-frame '+(parseInt(this.data.is_liked) ? 'grid-unlike' : 'grid-like')+'" data-id="'+this.data.posting_id+'"></div>';
	str += '<a href="/post-details?posting_id='+this.data.posting_id+'" class="image" rel="modal">';
	str += '<img src="'+this.data.image_url+'&width=300" class="'+(theGrid.offset < theGrid.limit ? '' : 'lazy')+' zoom-in" data-src="'+this.data.image_url+'&width=300" '+(Number(this.data.width) >= Number(this.data.height) ? theGrid.htText : '')+'>';
	str += '</a>';
    str += '<div class="gridPostDeets"><div class="gridUsername dahliaHead" data-id="'+this.data.user_id+'"><a href="/'+this.data.username+'">'+this.data.username+'</a></div>' +
        '<div class="gridLovesBox"><div class="postGridLikeImage '+(parseInt(this.data.is_liked) ? 'postGridLiked' : 'postGridUnLiked')+'" rel="grid-vote" data-id="'+this.data.posting_id+'"></div><p class="postGridLikeCount">'+this.data.total_likes+'</p></div>';
	str+= '</div>';
    theGrid.container.append(str);
    var $frame = $('#post-'+this.data.posting_id);
    $frame.append(new shareBall(this.data));
    $frame.find('.vote-frame').hover(function() {
        $frame.find('.hoverBall').css({'-webkit-transform': 'rotate(-50deg)', 'transform' : 'rotate(-45deg)', '-ms-transform': 'rotate(-45deg)'});
    }, function() {
        $frame.find('.hoverBall').css({'-webkit-transform': 'rotate(-7deg)', 'transform' : 'rotate(0deg)', '-ms-transform': 'rotate(0deg)'});
    });
}

theGrid.infiniteScroll = function(){
	$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
		  theGrid.getImages();
	   }
	});
}

theGrid.bindVoteButtons = function(){
	$(document).on('click', 'div[rel="grid-vote"]', theGrid.likeAction);
}

theGrid.init = function(sortTerm, searchTerm) {
	theGrid.sortTerm = (sortTerm ? sortTerm : null);
	theGrid.searchTerm = (searchTerm ? searchTerm : null);
	theGrid.container = $('#theGrid');
	theGrid.infiniteScroll();
	theGrid.bindVoteButtons();
	theGrid.getImages();
    theGrid.adjustMargins();
    $(window).resize(theGrid.adjustMargins);
    $(document).on('mouseover', '.vote-frame', function() {
        var $this = $(this);
        $this.css({'transform' : 'scale(1.05)', '-ms-transform': 'scale(1.05)', '-webkit-transform':  'scale(1.05)'}).on('webkitTransitionEnd transitionend', function() {
            $this.unbind().css({'transform' : 'scale(1)', '-ms-transform': 'scale(1)', '-webkit-transform':  'scale(1)'});
        });
    });
}