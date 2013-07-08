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
    if(api && apiFunction && params) {
        theCallUrl = '/api/?api='+api+'&function='+apiFunction+params;
        console.log(theCallUrl);
        $.ajax(theCallUrl).done(function(data){
            if(callback && typeof callback === 'function') {
                callback(data);
            }
        }).fail(function(){
            console.log('oh no something broke');
        });
    }
}// MAIN API CALL

dahliawolfApi.prototype.getFeedPosts = function(offset, limit, callback) {
    if(offset) {
        params = '&offset='+offset;
    } else {
        params = '&offset=0';
    }
    if(limit) {
        params += '&limit='+limit;
    }
    if(theUser.id) {
        params += '&viewer_user_id='+theUser.id;
    }
    params += '&status=Approved';

    this.callApi('posting', 'all_posts', params, callback);
}// GETS FEED POSTS

dahliawolfApi.prototype.getBankPosts = function(offset, limit, callback) {
    if(offset) {
        params = '&offset='+offset;
    } else {
        params = '&offset=0';
    }
    if(limit) {
        params += '&limit='+limit;
    }
    params += '&status=Approved';
    this.callApi('feed_image', 'get_feed_images', params, callback);
}// GETS IMAGES FOR THE BANK

dahliawolfApi.prototype.getPostDetails = function(id, callback) {
    console.log(id);
    if(id === 'newest') {
        params = '&posting_id=';
    } else if(id) {
        params = '&posting_id='+id;
    }
    console.log(id);
    if(theUser.id) {
        params += '&viewer_user_id='+theUser.id;
    }
    console.log('hi');
    this.callApi('posting', 'get_post', params, callback);
}// Get post details

dahliawolfApi.prototype.lovePost = function(id, callback) {//********** User Likes post
    if(theUser.id) {
        if(id) {
            params = '&user_id='+theUser.id;
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
            params = '&user_id='+theUser.id;
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
            params = '&user_id='+id;
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
            params = '&follower_user_id='+theUser.id;
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
            params = '&follower_user_id='+theUser.id;
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
            params = '&posting_id='+id;
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
        params = '&user_id='+theUser.id
        params += '&api_website_id=2';
    }
    this.callApi('activity_log', 'get_grouped_log', params, callback);
}//GETS ACTIVITY FEED

dahliawolfApi.prototype.markActivityAsRead = function(id, callback) {
    if(theUser.id) {
        params = '&user_id='+theUser.id;
        params += '&activity_log_id='+id;

        this.callApi('activity_log', 'mark_read', params, callback);
    } else {
        new_loginscreen();
    }
}// Mark an activity as read

$(function(){
    api = new dahliawolfApi();
});
