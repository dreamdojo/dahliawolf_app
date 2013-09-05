<style>
    #dashboardHeader{width: 100%; height: 200px; background-color: #f3f3f3;}
    #dashboardHeader .leftCol{float: left; width: 150px;}
    #dashboardHeader .dashboardInner{margin: 0px auto; width: 1000px; padding-top: 25px;}
    #dashboardHeader .avatarFrame{width: 100px;overflow: hidden; border-radius: 50px;margin-left: 25px;}
    #dashboardHeader .avatarFrame img{width: 100%;}
    #dashboardHeader .mLevel{font-size: 15px; color: #fff; font-weight: bolder; background-color: #ff0066; width: 175px; text-indent: 5px !important;}
    #dashboardHeader .stats{width: 400px;float: left;margin-left: 10px;margin-top: 15px;}
    #dashboardHeader .cashOut{float: right; width: 300px; text-align: center;margin-top: 25px; font-size: 18px;}
    #dashboardHeader .cashOut li{padding-bottom: 5px;}
    #dashboardHeader .dbButton{background-color: #fff; border: #000 thin solid; color: #000; padding: 2px 10px; margin: 0px auto; cursor: pointer;}
    #dashboardHeader .vpp{margin-top: 20px; padding: 5px 0px; text-align: center;}
    #dashboardHeader .uname{font-size: 18px; text-indent: 0px !important;}
    #dashboardHeader .stats li{text-indent: 10px; padding: 3px 2px;}

    #dataCol{background-color: #f3f3f3; margin: 0px auto; width: 1000px; margin-top: 15px;}
    #dataCol .menuToggle{width: 200px; margin: 0px auto; height: 60px;}
    #dataCol .menuToggle li{width: 75px; margin-top: 13px; float: left; background-color: #fff; padding: 9px; font-size: 13px; text-align: center;}
    #dataCol #filters{ width: 96%; margin-left: 2%; float: left; background-color: #fff; height: 25px; line-height: 25px;}
    #dataCol #filters li{float: left; text-align: center;width: 33%; font-size: 11px; color: #666666;}
    #dataCol #postSelector{ width: 98%;}

    #postBin{width: 96%; margin-left: 2%;}
    #postBin .dbPost{height: 300px; width: 100%; background-color: #fff; float: left; margin-top: 10px;overflow: hidden;}
    #postBin .dbPost li{ float: left; height: 180px; padding-top: 60px; margin-top: 25px; text-align: center; font-size: 15px; position: relative; border: #c2c2c2 5px solid; margin-left: -5px;}
    #postBin .dbPost li:first-child{height: 70%;margin-top: 15px;margin-left: 15px; background-size: 100%;background-repeat: no-repeat; border: none}
    .postAction{ position: absolute;width: 100%; text-align: center;bottom: 10px; cursor: pointer;}
    .sSteez{font-size: 12px;color: #666666;font-size: 15px;font-weight: 100;}

</style>
<div id="dashboardHeader">
    <div class="dashboardInner">
        <div class="leftCol">
            <div class="avatarFrame">
                <img src="<?= $_data['user']['avatar'] ?>&width=152">
            </div>
            <a href="/<?= $_data['user']['username'] ?>?showPublic=true"><div class="dbButton vpp">VIEW PUBLIC PROFILE</div></a>
        </div>
        <ul class="stats">
            <li class="uname">@<?= $_data['user']['username'] ?></li>
            <li class="mLevel">MEMBERSHIP LEVEL</li>
            <li class="sSteez"><a href="/<?= $_data['user']['username'] ?>/followers"><?= $_data['user']['followers'] ?> FOLLOWERS</a> | <a href="/<?= $_data['user']['username'] ?>/following"><?= $_data['user']['following'] ?> FOLLOWING</a></li>
            <li class="sSteez"><?= $_data['user']['points'] ?> POINTS | </li>
        </ul>
        <ul class="cashOut">
            <li style="font-weight: 100;">ACCOUNT BALANCE</li>
            <li style="font-size: 32px;">$729</li>
            <li class="dbButton" style="width: 100px;">CASH OUT</li>
        </ul>
    </div>
</div>
<div id="dataCol">
    <ul class="menuToggle">
        <li class="dbButton">POSTS</li>
        <li style="margin-left: 14px;">PRODUCTS</li>
    </ul>
    <ul id="filters">
        <li style="width: 32%;">
            <ul id="postSelector">
                <li>ACTIVE(12)</li>
                <li>EXPIRED(5655)</li>
                <li>WINNERS(34)</li>
            </ul>
        </li>
        <li style="width: 20%;">VOTES</li>
        <li style="width: 16%;">VIEWS</li>
        <li style="width: 15.5%;">SHARES</li>
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
    dashboard.isAvailable = true;

    dashboard.init = function() {
        dashboard.bindScroll();
        dashboard.getPosts();
    }

    dashboard.bindScroll = function() {
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
                dashboard.getPosts();
            }
        });
    }

    dashboard.getPosts = function() {
        var that = this;

        if(dashboard.isAvailable) {
            dashboard.isAvailable = false;
            $.post('/action/getPostsByUser', {post_user_id : dahliawolf.userId, feed : this.feed, offset : this.offset, limit: this.limit}).done(function(data) {
                holla.log(data);
                dashboard.isAvailable = true;
                $.each(data.data, function(index, post) {
                    that.$bin.append(new dashboardPost(post));
                });
                that.offset += data.data.length;
            });
        }
    }

    function dashboardPost(data) {
        this.data = data;
        this.$post = $('<ul class="dbPost"></ul>');
        $('<li style="width: 30%; background-image: url(\''+this.data.image_url+'\')"></li>').appendTo(this.$post);
        this.$panel0 = $('<li style="width: 19%; margin-left: 10px;"><p>'+this.data.total_likes+' TOTAL LOVES</p><p><span class="dahliaPink">'+(LOVE_REQUIRED - this.data.total_likes)+'</span> NEEDED TO WIN</p></li>').appendTo(this.$post);
        this.$panel1 = $('<li style="width: 15%;"><p>2012 VIEWS</p></li>').appendTo(this.$post);
        this.$panel2 = $('<li style="width: 15%;"><p>12 SHARES</p></li>').appendTo(this.$post);
        this.$panel3 = $('<li style="width: 15%;"><p>EXP: 8/30/12</p></li>').appendTo(this.$post);
        $('<div class="postAction">View Members</div>').appendTo(this.$panel0).on('click', $.proxy(dashboard.pooty, this));
        $('<div class="postAction">View Shares</div>').appendTo(this.$panel2).on('click', $.proxy(dashboard.pooty, this));
        $('<div class="postAction">More Time+</div>').appendTo(this.$panel3).on('click', $.proxy(dashboard.pooty, this));

        return this.$post;
    }
    // http://dev.api.dahliawolf.com/1-0/sharing.json?sharing_user_id=658&network=facebook&posting_owner_user_id=660&function=add_share&use_hmac_check=0
    dashboard.pooty = function() {
        holla.log('bruuump'+this.data.username);
    }

    $(function() {
       dashboard.init();
    });

</script>