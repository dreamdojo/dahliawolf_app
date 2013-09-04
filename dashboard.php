<style>
    #dashboardHeader{width: 100%; height: 200px; background-color: #f3f3f3;}
    #dashboardHeader .leftCol{float: left; width: 150px;}
    #dashboardHeader .dashboardInner{margin: 0px auto; width: 1000px; padding-top: 25px;}
    #dashboardHeader .avatarFrame{width: 100px;overflow: hidden; border-radius: 50px;margin-left: 25px;}
    #dashboardHeader .avatarFrame img{width: 100%;}
    #dashboardHeader .mLevel{font-size: 15px; color: #fff; font-weight: bolder; background-color: #ff0066; width: 175px;}
    #dashboardHeader .stats{width: 400px;float: left;margin-left: 10px;margin-top: 15px;}
    #dashboardHeader .cashOut{float: right; width: 300px; text-align: center;margin-top: 25px; font-size: 18px;}
    #dashboardHeader .dbButton{background-color: #fff; border: #000 thin solid; color: #000; padding: 2px 10px;}
    #dashboardHeader .vpp{margin-top: 20px; padding: 5px 0px; text-align: center;}
    #dashboardHeader .uname{font-size: 18px; text-indent: 0px !important;}
    #dashboardHeader .stats li{text-indent: 10px; padding: 3px 2px;}

    #dataCol{background-color: #f3f3f3; margin: 0px auto; width: 1000px; margin-top: 15px;}
    #dataCol .menuToggle{width: 200px; margin: 0px auto; height: 40px; float: left;}
    #dataCol .menuToggle li{width: 50px; margin-top: 10px; float: left;}
    #dataCol #filters{ width: 96%; margin-left: 2%; float: left; background-color: #fff; height: 25px; line-height: 25px;}
    #dataCol #filters li{float: left; text-align: center;width: 33%;}
    #dataCol #postSelector{ width: 98%;}

    #postBin{width: 96%; margin-left: 2%;}
    #postBin .dbPost{height: 300px; width: 100%; background-color: #fff; float: left; margin-top: 10px;}
    #postBin .dbPost li{ float: left; height: 250px; margin-top: 25px; text-align: center; font-size: 15px; position: relative;}
    #postBin .dbPost li:first-child{height: 100%; margin-top: 0px; background-size: 100%;background-repeat: no-repeat;}
    .postAction{ position: absolute;width: 100%;text-align: center;bottom: 0px; cursor: pointer;}

</style>
<div id="dashboardHeader">
    <div class="dashboardInner">
        <div class="leftCol">
            <div class="avatarFrame">
                <img src="<?= $_data['user']['avatar'] ?>&width=152">
            </div>
            <div class="dbButton vpp">VIEW PUBLIC PROFILE</div>
        </div>
        <ul class="stats">
            <li class="uname">@<?= $_data['user']['username'] ?></li>
            <li class="mLevel">MEMBERSHIP LEVEL</li>
            <li style="font-size: 12px;"><?= $_data['user']['followers'] ?> FOLLOWERS | <?= $_data['user']['following'] ?> FOLLOWING</li>
            <li style="font-size: 12px;"><?= $_data['user']['points'] ?> POINTS | </li>
        </ul>
        <ul class="cashOut">
            <li>ACCOUNT BALANCE</li>
            <li>$729</li>
            <li>CASH OUT</li>
        </ul>
    </div>
</div>
<div id="dataCol">
    <ul class="menuToggle">
        <li class="dbButton">POSTS</li>
        <li>PRODUCTS</li>
    </ul>
    <ul id="filters">
        <li style="width: 30%;">
            <ul id="postSelector">
                <li>ACTIVE</li>
                <li>EXPIRED</li>
                <li>WINNERS</li>
            </ul>
        </li>
        <li style="width: 25%;">VOTES</li>
        <li style="width: 15%;">VIEWS</li>
        <li style="width: 15%;">SHARES</li>
        <li style="width: 15%;">TIME LEFT</li>
    </ul>
    <div id="postBin"></div>
    <p style="clear: left;"></p>
</div>
<script>
    console.log(<?= json_encode($_data['user']) ?>);

    var dashboard = new Object();
    dashboard.limit = 12;
    dashboard.offset = 0;
    dashboard.feed = "posts";
    dashboard.$bin = $('#postBin');

    dashboard.getPosts = function() {
        var that = this;
        $.post('/action/getPostsByUser', {post_user_id : dahliawolf.userId, feed : this.feed, offset : this.offset, limit: this.limit}).done(function(data) {
            holla.log(data);
            $.each(data.data, function(index, post) {
                that.$bin.append(new dashboardPost(post));
            });
        });
    }

    function dashboardPost(data) {
        this.data = data;
        this.$post = $('<ul class="dbPost"></ul>');
        $('<li style="width: 30%; background-image: url(\''+this.data.image_url+'\')"></li>').appendTo(this.$post);
        this.$panel0 = $('<li style="width: 25%;"><p>'+this.data.total_likes+' TOTAL LOVES</p><p>'+(LOVE_REQUIRED - this.data.total_likes)+'</p></li>').appendTo(this.$post);
        this.$panel1 = $('<li style="width: 15%;"><p>2012 VIEWS</p></li>').appendTo(this.$post);
        this.$panel2 = $('<li style="width: 15%;"><p>12 SHARES</p></li>').appendTo(this.$post);
        this.$panel3 = $('<li style="width: 15%;"><p>EXP: 8/30/12</p></li>').appendTo(this.$post);
        $('<div class="postAction">View Members</div>').appendTo(this.$panel0).on('click', dashboard.pooty);
        $('<div class="postAction">View Shares</div>').appendTo(this.$panel2).on('click', dashboard.pooty);
        $('<div class="postAction">More Time+</div>').appendTo(this.$panel3).on('click', dashboard.pooty);

        return this.$post;
    }
    // http://dev.api.dahliawolf.com/1-0/sharing.json?sharing_user_id=658&network=facebook&posting_owner_user_id=660&function=add_share&use_hmac_check=0
    dashboard.pooty = function() {
        holla.log('bruuump');
    }

    $(function() {
       dashboard.getPosts();
    });

</script>