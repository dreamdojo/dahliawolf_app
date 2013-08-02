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
theGrid.htText = 'style="height:100%; min-width:100%; width:auto;"';

theGrid.showLoader = function() {
	$('#theGrid').append('<div id="theGridLoader"><img src="/images/loading-feed.gif"></div>');
}
theGrid.destroyLoader = function() {
	$('#theGridLoader').remove();
}

theGrid.likeAction = function(){
	console.log('yooo');
    id = parseInt( $(this).data('id') );
    likeBox = $('#post-'+id).find('.postGridLikeCount');
    likeImage = $('#post-'+id).find('.postGridLikeImage');
    likeCount = parseInt( likeBox.html() );
	_this = $('#post-'+id).find('.vote-frame');
	if(id && id > 0 && theUser.id && theUser.id > 0){
		if( $(_this).hasClass('grid-like') ){
            api.lovePost(id);
			$(_this).removeClass('grid-like').addClass('grid-unlike').data('action', 'unlike');
            likeImage.removeClass('postGridUnLiked').addClass('postGridLiked');
            likeCount++;
		}else{
            api.unlovePost(id);
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
	str += '<img src="'+this.data.image_url+'" class="'+(theGrid.offset < theGrid.limit ? '' : 'lazy')+' zoom-in" data-src="'+this.data.image_url+'" '+(this.data.width >= this.data.height ? theGrid.htText : '')+'>';
	str += '</a>';
    str += '<div class="gridPostDeets"><div class="gridUsername dahliaHead" data-id="'+this.data.user_id+'"><a href="/'+this.data.username+'">'+this.data.username+'</a></div>' +
        '<div class="gridLovesBox"><div class="postGridLikeImage '+(parseInt(this.data.is_liked) ? 'postGridLiked' : 'postGridUnLiked')+'" rel="grid-vote" data-id="'+this.data.posting_id+'"></div><p class="postGridLikeCount">'+this.data.total_likes+'</p></div>';
	str+= '</div>';
	theGrid.container.append(str);
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
}