function User(userData) {
    if(userData) {
        this.data = userData;
    } else {
        this.data = {};
    }
    this.member = new Member();
    this.post = new Post();
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

User.prototype.isFriend = function(id) {
    return true;
}
//************************************************************************************ API

function Api() {
    this.baseUrl = '/api/1-0/';
}

Api.prototype.callApi = function(data) {
    var params = '';
    console.log(data);
    for (var key in data){
        if (data.hasOwnProperty(key)) {
            params += '&'+key+'='+data[key];
        }
    }

    if(dahliawolf.isLoggedIn) {
        console.log('calling api '+this.baseUrl+this.apiApi+'?function='+this.apiFunction+params);
        if(typeof this.callback === 'function') {
            this.callback();
        }
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
