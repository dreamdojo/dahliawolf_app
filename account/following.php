<?
    $pageTitle = "Following";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

    $params = array(
        'username' => strtolower($_GET['username']),
        'limit' => 0
    );

    if (IS_LOGGED_IN) {
        $params['viewer_user_id'] = $_SESSION['user']['user_id'];
    }
    $data = api_call('user', 'get_user', $params, true);
?>

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

    console.log(<? json_encode($data) ?>)

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
        this.$userFrame.find('.dataList').append('<div>FOLLOW</div>');
        this.$userFrame.append('<ul class="postList">'+str+'</ul>');
        console.log('pooty');
    }

    $(function() {
        dahliawolfUserList = new userList();
        dahliawolfUserList.getUsers();
    })

</script>