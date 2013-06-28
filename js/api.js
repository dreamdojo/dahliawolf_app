function dahliawolfApi() {
    this.apiUrl = "http://dev.dahliawolf.com/api/?";

}

dahliawolfApi.prototype.callApi = function(api, apiFunction, params, callback) {
    if(api && apiFunction && params) {
        theCallUrl = 'http://dev.dahliawolf.com/api/?api='+api+'&function='+apiFunction+params;
        console.log(theCallUrl);
        $.ajax(theCallUrl).done(function(data){
            if(callback && typeof callback === 'function') {
                callback(data);
            }
        });
    }
}

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
}

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
}

dahliawolfApi.prototype.getPostDetails = function(id, callback) {
    if(id) {
        if(theUser.id) {
            params = '&posting_id='+id;
        }
        if(theUser.id) {
            params += '&viewer_user_id='+theUser.id;
        }

        this.callApi('posting', 'get_post', params, callback);

    } else {
        alert('NO ID');
    }
}// Get post details

dahliawolfApi.prototype.lovePost = function(id, callback) {//********** User Likes post
    if(theUser.id) {
        if(id) {
            params = '&user_id='+id;
            params += '&posting_id='+theUser.id;
            params += '&like_type_id=1';

            this.callApi('posting', 'add_post_like', params, callback);

        } else {
            alert('NO ID');
        }
    } else {
        //login
    }
}

dahliawolfApi.prototype.unlovePost = function(id, callback) {//****** User Unlikes post
    if(theUser.id) {
        if(id) {
            params = '&user_id='+id;
            params += '&posting_id='+theUser.id;
            params += '&like_type_id=1';

            this.callApi('posting', 'delete_post_like', params, callback);

        } else {
            alert('NO ID');
        }
    } else {
        //login
    }
}

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
}

dahliawolfApi.prototype.followUser = function(id, callback) {//************** Follow user
    if(theUser.id) {
        if(id) {
            params = '&follower_user_id='+id;
            params += '&user_id='+theUser.id;

            this.callApi('user', 'follow', params, callback);

        } else {
            alert('NO ID TO FOLLOW');
        }
    } else {
        //login
    }
}

dahliawolfApi.prototype.unfollowUser = function(id, callback) { //********  Unfollow user
    if(theUser.id) {
        if(id) {
            params = '&follower_user_id='+id;
            params += '&user_id='+theUser.id;

            this.callApi('user', 'unfollow', params, callback);

        } else {
            alert('NO ID TO FOLLOW');
        }
    } else {
        //login
    }
}

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
        //login
    }
}

$(function(){
    api = new dahliawolfApi();
    api.getBankPosts(0, 12, function(data){
       console.log(data);
    });
});
