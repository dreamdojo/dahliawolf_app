function dahliawolfApi() {

}

dahliawolfApi.prototype.getBankPosts = function() {
    $.ajax('http://dev.dahliawolf.com/api/?api=posting&function=all_posts&offset=0&limit=12').done(function(data){
        console.log( data );
    });
}

dahliawolfApi.prototype.getUserDetails = function(id, callback) {
    if(id) {
        $.ajax('http://dev.dahliawolf.com/api/?api=user&function=get_user&viewer_user_id='+theUser.id+'&user_id='+id).done(function(data){
            callback(data);
        });
    } else {
       alert('NO ID');
    }
}

dahliawolfApi.prototype.followUser = function(id, callback) {
    if(id) {
        $.ajax('http://dev.dahliawolf.com/api/?api=user&function=get_user&viewer_user_id='+theUser.id+'&user_id='+id).done(function(data){
            callback(data);
        });
    } else {
        alert('NO ID');
    }
}

api = new dahliawolfApi();