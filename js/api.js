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

function dahliawolfApi() {
    this.apiUrl = "/api/?";

}

dahliawolfApi.prototype.callApi = function(api, apiFunction, params, callback) {
    if(api && apiFunction) {
        var theCallUrl = '/api/?api='+api+'&function='+apiFunction+params;
        console.log(theCallUrl);
        var xhr = $.ajax(theCallUrl).done(function(data){
            if(callback && typeof callback === 'function') {
                callback(data);
            }
        }).fail(function(){
            console.log('oh no something broke');
        });
        return xhr;
    }
}// MAIN API CALL

dahliawolfApi.prototype.getFeedPosts = function(data) {
    var api_function = 'all_posts';

    if(data.offset) {
        var params = '&offset='+data.offset;
    } else {
        var params = '&offset=0';
    }
    if(data.limit) {
        params += '&limit='+data.limit;
    }
    if(data.username) {
        params += '&username='+data.username;
    }
    if(data.view && data.view === 'wild-4s') {
        api_function = 'get_liked_posts';
    }

    if(data.sort) {
        params += '&sort='+data.sort;
        if(data.sort == 'following') {
            params += '&filter_by=following';
        }
        if(data.sort == 'hot') {
            params += '&order_by=total_likes';
            params += '&like_day_threshold=30';
        }
    }
    if(theUser.id) {
        params += '&viewer_user_id='+theUser.id;
    }
    params += '&status=Approved';

    this.callApi('posting', api_function, params, data.callback);
}// GETS FEED POSTS

dahliawolfApi.prototype.getBankPosts = function(offset, limit, callback) {
    if(offset) {
        var params = '&offset='+offset;
    } else {
        params = '&offset=0';
    }
    if(limit) {
        params += '&limit='+limit;
    }
    params += '&status=Approved';
    return this.callApi('feed_image', 'get_feed_images', params, callback);
}// GETS IMAGES FOR THE BANK

dahliawolfApi.prototype.getVotePosts = function(callback) {
    var params = '';

    if(theUser.id) {
        params += '&viewer_user_id='+theUser.id;
    }

    this.callApi('posting', 'get_vote_posts', params, callback);
}// GETS PRODUCTS FOR EXPLORE PAGE

dahliawolfApi.prototype.getPostDetails = function(id, callback) {
    if(id === 'newest') {
        var params = '&posting_id=';
    } else if(id) {
        params = '&posting_id='+id;
    }
    if(theUser.id) {
        params += '&viewer_user_id='+theUser.id;
    }
    this.callApi('posting', 'get_post', params, callback);
}// Get post details

dahliawolfApi.prototype.lovePost = function(id, callback) {//********** User Likes post
    if(theUser.id) {
        if(id) {
            var params = '&user_id='+theUser.id;
            params += '&posting_id='+id;
            params += '&like_type_id=1';

            this.callApi('posting', 'add_post_like', params, callback);

        } else {
            alert('NO ID');
        }
    } else {
        new_loginscreen();
    }
}// LOVES A POST

dahliawolfApi.prototype.unlovePost = function(id, callback) {//****** User Unlikes post
    if(theUser.id) {
        if(id) {
            var params = '&user_id='+theUser.id;
            params += '&posting_id='+id;
            params += '&like_type_id=1';

            this.callApi('posting', 'delete_post_like', params, callback);

        } else {
            alert('NO ID');
        }
    } else {
        new_loginscreen();
    }
}// UNLOVES A POST

dahliawolfApi.prototype.getUserDetails = function(id, callback) {//********** Get a users details
    if(id) {
        if(id) {
            var params = '&user_id='+id;
        }
        if(theUser.id) {
            params += '&viewer_user_id='+theUser.id;
        }

        this.callApi('user', 'get_user', params, callback);

    } else {
       alert('NO ID');
    }
}// GETS A SPECIFIC USERS DEETS

dahliawolfApi.prototype.followUser = function(id, callback) {//************** Follow user
    if(theUser.id) {
        if(id) {
            var params = '&follower_user_id='+theUser.id;
            params += '&user_id='+id;
            this.callApi('user', 'follow', params, callback);

        } else {
            alert('NO ID TO FOLLOW');
        }
    } else {
        new_loginscreen();
    }
}// FOLLOW USER

dahliawolfApi.prototype.unfollowUser = function(id, callback) { //********  Unfollow user
    if(theUser.id) {
        if(id) {
            var params = '&follower_user_id='+theUser.id;
            params += '&user_id='+id;

            this.callApi('user', 'unfollow', params, callback);

        } else {
            alert('NO ID TO FOLLOW');
        }
    } else {
        new_loginscreen();
    }
}// UNFOLLOW USER

dahliawolfApi.prototype.deletePost = function(id, callback) {
    if(theUser.id) {
        if(id) {
            var params = '&posting_id='+id;
            params += '&user_id='+theUser.id;

            this.callApi('posting', 'delete_post', params, callback);

        } else {
            alert('NO ID TO DELETE');
        }
    } else {
        new_loginscreen();
    }
}//DELETE USER POST

dahliawolfApi.prototype.getActivityLog = function(callback) {
    if(theUser.id){
        var params = '&user_id='+theUser.id
        params += '&api_website_id=2';
    }
    this.callApi('activity_log', 'get_grouped_log', params, callback);
}//GETS ACTIVITY FEED

dahliawolfApi.prototype.markActivityAsRead = function(id, callback) {
    if(theUser.id) {
        var params = '&user_id='+theUser.id;
        params += '&activity_log_id='+id;

        this.callApi('activity_log', 'mark_read', params, callback);
    } else {
        new_loginscreen();
    }
}// Mark an activity as read

dahliawolfApi.prototype.addItemToWishlist = function(data) {
    if(theUser.id) {
        var count = parseInt( $(data.obj).find('.wishlist_count_box').html() ) + 1;
        $(data.obj).find('.wishlist_count_box').html( count );
        $.ajax(data.call).done(function(retData) {
            console.log($.parseJSON(retData) );
        });
    } else {
        new_loginscreen();
    }
}

$(function(){
    api = new dahliawolfApi();
});