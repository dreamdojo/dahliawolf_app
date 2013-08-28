function User(userData) {
    if(userData) {
        this.data = userData;
    } else {
        this.data = {};
    }
    this.member = new Member(this.isLoggedIn);
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
//************************************************************************************ API
function Api() {
    this.baseUrl = '/api/1-0/';
}

Api.prototype.callApi = function() {
    if(this.isLoggedIn) {
        console.log('calling api '+this.baseUrl+this.apiApi+'?function='+this.apiFunction);
    } else {
        console.log('not logged in');
    }
}
//************************************************************************************ MEMBER
Member.prototype = new Api();
Member.prototype.constructor = Member;

function Member(isLoggedIn) {
    this.isLoggedIn = isLoggedIn;
    this.apiApi = 'person.json';
}

Member.prototype.follow = function(id, callback) {
    this.apiFunction = 'follow';
    this.callApi();
    return this;
}

Member.prototype.unfollow = function(id, callback) {
    this.apiFunction = 'unfollow';
    this.callApi();
    return this;
}
//************************************************************************************ POST
function Post(isLoggedIn) {
    this.isLoggedIn = isLoggedIn;
    this.apiApi = 'post.json'
}
Post.prototype = new Api();
Post.prototype.constructor = Post;

Post.prototype.love = function(id, callback) {
    this.apiFunction = 'love';
    this.callApi();
    return this;
}

Post.prototype.unlove = function(id, callback) {
    this.apiFunction = 'unlove';
    this.callApi();
    return this;
}

Post.prototype.delete = function(id, callback) {
    this.apiFunction = 'delete';
    this.callApi();
    return this;
}
