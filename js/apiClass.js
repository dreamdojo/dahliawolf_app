function User(userData) {
    if(userData) {
        this.data = userData;
    } else {
        this.data = {};
    }
    this.member = new Member();
    this.post = new Post();
    this.post = new Post();
    this.share = new Share();
}

User.prototype = {
    get userId()    {return this.data.user_id;},
    get username()  {return this.data.username;},
    get location()  {return this.data.location;},
    get shopUrl()    {return '/'+this.data.username+'/shop/';},
    get avatar()    {return this.data.avatar;},
    get $avatar()    {return $('<img src="'+this.data.avatar+'">');},
    get firstName() {return this.data.first_name;},
    get lastName()  {return this.data.last_name;},
    get fullName()  {return this.data.first_name + ' '+this.data.last_name;},
    get followers() {return this.data.followers;},
    get increaseFollowers() { return ++this.data.followers;},
    get decreaseFollowers() { return --this.data.followers;},
    get isLoggedIn() {return (this.data.user_id && this.data.user_id > 0 ? true : false);},

    getAttribute : function(attr) {return (this.data[attr] ? this.data[attr] : 'Invalid');}
};

User.prototype.setFriends = function(data) {
    this.friends = data;
}

User.prototype.isFacebookFriend = function(id) {
    var retVal = false;
    if(this.friends.length) {
        $.each(this.friends, function(index, friend) {
            if(friend.fb_uid == id) {
                retVal = friend;
                return;
            }
        });
    } else {
        holla.log('no friends set');
    }
    return retVal;
}

User.prototype.isFriend = function(id) {
    return true;
}
//************************************************************************************ API

function Api() {
    this.baseUrl = '/api/1-0/';
}

Api.prototype.callApi = function(data) {
    that = this;
    data.use_hmac_check = 0;

    if(dahliawolf.isLoggedIn) {
        var url = this.baseUrl+this.apiApi;
        $.getJSON(url, data, function(data) {
            if(typeof that.callback === 'function') {
                that.callback(data);
            }
        });
    } else {
        console.log('not logged in');
    }
}
//************************************************************************************ MEMBER
Member.prototype = new Api();
Member.prototype.constructor = Member;

function Member() {
    this.apiApi = 'user.json';
}

Member.prototype.follow = function(id, callback) {
    this.apiFunction = 'follow';
    this.callApi({user_follow_id : id, user_id : dahliawolf.userId});
    this.callback = callback;
    return this;
}

Member.prototype.unfollow = function(id, callback) {
    this.apiFunction = 'unfollow';
    this.user_id = id;
    this.callApi();
    return this;
}
//************************************************************************************ POST
function Post() {
    this.apiApi = 'post.json'
}
Post.prototype = new Api();
Post.prototype.constructor = Post;

Post.prototype.love = function(id, callback) {
    this.apiFunction = 'love';
    this.posting_id = id;
    this.callApi();
    return this;
}

Post.prototype.unlove = function(id, callback) {
    this.apiFunction = 'unlove';
    this.posting_id = id;
    this.callApi();
    return this;
}

Post.prototype.delete = function(id, callback) {
    this.apiFunction = 'delete';
    this.callApi();
    return this;
}

//**************************************************************************************** SHARING

function Share() {
    this.apiApi = 'sharing.json';
}

Share.prototype = new Api();
Share.prototype.constructor = Share;

Share.prototype.add = function(id, net, type, posting_owner, callback) {
    this.callback = callback;
    //http://dev.dahliawolf.com/api/1-0/sharing.json?function=add_share&product_id=123&sharing_user_id=658&network=facebook&type=product&product_owner_user_id=658&use_hmac_check=0
    //http://dev.dahliawolf.com/api/1-0/sharing.json?function=get_shares&type=product&product_id=123&use_hmac_check=0
    if(type === 'posting') {
        this.callApi({function : 'add_share', posting_id : id, sharing_user_id : dahliawolf.userId, network : net, type : type, posting_owner_user_id : posting_owner });
    } else {
        this.callApi({function : 'add_share', id_product : id, sharing_user_id : dahliawolf.userId, network : net, type : type, posting_owner_user_id : posting_owner });
    }
}

Share.prototype.get = function(id, type, callback) {
    this.callback = callback;
    this.callApi({function : 'get_shares', posting_id : id, type : type});
}

