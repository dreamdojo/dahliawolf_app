<?
    $pageTitle = "Following";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";


?>
<style>
    .avatarShadow{box-shadow: rgb(133, 133, 133) 1px 11px 15px -7px;}
    #userListBanner{width: 1100px;margin: 0px auto;height: 200px;border-bottom: #c2c2c2 thin solid;padding-top: 20px;}
    #userListBanner .avatarFrame{overflow: hidden;border-radius: 80px;height: 150px;width: 150px; float: left;}
    #userListBanner ul{float: left;margin-top: 50px;margin-left: 10px;font-size: 18px;}
    #userListBanner .followLand{ float: right;}

    #userListCol {width: 1100px;height: 100px;margin: 0px auto;position: relative;}
    #userListCol .userFrame{width: 100%;height: 150px; margin-top: 10px;}
    #userListCol .avatarFrame{overflow: hidden;height: 110px;width: 110px;border-radius: 57px;margin-left: 10px;float: left;margin-top: 20px;}
    #userListCol .avatarFrame img{width: 100%;}
    #userListCol .dataList{float: left;margin-top: 30px; margin-left: 10px;font-size: 18px;width: 160px;}
    #userListCol .postList li{overflow: hidden;width: 130px;float: left;height: 150px;margin-left: 20px;}
    #userListCol .postList li img{min-height: 100%;}
    #userListCol .dlUsername{width: 150px;text-overflow: ellipsis;overflow: hidden;}
</style>

<div id="userListBanner">
    <div class="avatarFrame avatarShadow"><img src="<?= $userConfig['avatar'] ?>&width=200"></div>
    <ul>
        <li style="font-size: 21px;"><?= $userConfig['username'] ?></li>
        <li><?= $userConfig['location'] ?></li>
    </ul>
    <ul class="followLand">
        <li>FOLLOWERS <?= $userConfig['followers'] ?></li>
        <li>FOLLOWING <?= $userConfig['following'] ?></li>
    </ul>
</div>
<div id="userListCol"></div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
    function userList() {
        this.limit = 20;
        this.offset = 0;
        this.users = [];
        this.isReloadAvailable = true;
        this.$bucket = $('#userListCol');

        this.bindScroll();
    }

    userList.prototype.bindScroll = function() {
        var _this = this;

        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 200 && _this.isReloadAvailable ) {
                _this.isReloadAvailable = false;
                _this.getUsers();
            }
        });
    }

    userList.prototype.getUsers = function() {
        var _this = this;

        $.getJSON('/api/?api=user&function=get_top_following&user_id='+theUser.id+'&limit='+this.limit+'&offset='+this.offset, function(data) {
            _this.offset += data.data.length;
            _this.isReloadAvailable = true;
            _this.addUsersToStack(data.data);
        });
    }

    userList.prototype.addUsersToStack = function(array) {
        var _this = this;

        $.each(array, function(index, user) {
             _this.users.push( new userList.prototype.user(user) );
        });
    }

    userList.prototype.user = function(data) {
        this.data = data;

        this.addMeToBucket();
    }

    userList.prototype.user.prototype.addMeToBucket = function() {
        var str = '';
        $.each(this.data.posts, function(x, post) {
           str += '<li><a href="/post/'+post.posting_id+'"><img src="'+post.image_url+'&width=125"></a></li>';
        });

        this.$userFrame = $('<div class="userFrame"></div>').appendTo( dahliawolfUserList.$bucket );
        this.$userFrame.append('<div class="avatarFrame avatarShadow"><a href="/'+this.data.username+'"><img src="'+this.data.avatar+'&width=100"></a></div>');
        this.$userFrame.append('<ul class="dataList"><a href="/'+this.data.username+'"><li class="dlUsername">'+this.data.username+'</li></a></ul>');
        this.$userFrame.append('<ul class="postList">'+str+'</ul>');
    }

    $(function() {
        dahliawolfUserList = new userList();
        dahliawolfUserList.getUsers();
    })

</script>