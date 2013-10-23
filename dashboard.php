<?php
if(!IS_LOGGED_IN) {
    die();
}
?>

<style xmlns="http://www.w3.org/1999/html">
    #dashboardHeader{width: 100%; height: 200px; background-color: #f3f3f3;}
    #dashboardHeader .leftCol{float: left; width: 150px; position: relative;}
    #dashboardHeader .leftCol input{opacity: 0; width: 30px; float: right;}
    #dashboardHeader .leftCol .avatarChangeButton{ position: absolute; right: 14px; top: -6px;font-size: 32px; width: 30px; text-align: center; cursor: pointer;background-color: #666666; color: #f3f3f3;opacity: .7;height: 35px; line-height: 29px;}
    #dashboardHeader .dashboardInner{margin: 0px auto; width: 1000px; padding-top: 25px;}
    #dashboardHeader .avatarFrame{width: 100px; height: 100px; overflow: hidden; border-radius: 50px;margin-left: 25px; background-position: 50%; background-repeat: no-repeat; background-size: 100%;}
    #dashboardHeader .avatarFrame img{width: 100%;}
    #dashboardHeader .mLevel{font-size: 15px; text-transform: capitalize; color: #fff; font-weight: bolder; background-color: #ff0066; width: 175px; text-indent: 5px !important;}
    #dashboardHeader .stats{width: 400px;float: left;margin-left: 10px;margin-top: 15px;}
    #dashboardHeader .cashOut{float: right; width: 300px; text-align: center;margin-top: 25px; font-size: 18px;}
    #dashboardHeader .cashOut li{padding-bottom: 5px;}
    #dashboardHeader .dbButton{background-color: #fff; border: #000 thin solid; color: #000; padding: 2px 10px; margin: 0px auto; cursor: pointer; display: none;}
    #dashboardHeader .vpp{margin-top: 20px; padding: 5px 0px; text-align: center;}
    #dashboardHeader .uname{font-size: 18px; text-indent: 0px !important;}
    #dashboardHeader .stats li{text-indent: 10px; padding: 3px 2px;}
    .choosed{border: #000 thin solid;}

    #dataCol{background-color: #f3f3f3; margin: 0px auto; width: 1000px; margin-top: 15px;}
    #dataCol .menuToggle{width: 202px; margin: 0px auto; height: 60px;}
    #dataCol .menuToggle li{width: 75px; margin-top: 13px; float: left; background-color: #fff; padding: 9px; font-size: 13px; text-align: center; cursor: pointer;}
    #dataCol #filters{ width: 96%; margin-left: 2%; float: left; background-color: #fff; height: 25px; line-height: 25px;}
    #dataCol #filters li{float: left; text-align: center;width: 33%; font-size: 11px; color: #666666;}
    #dataCol #postSelector{ width: 98%;}

    #postBin{width: 96%; margin-left: 2%;padding-bottom: 120px;}
    #postBin .dbPost{height: 300px; width: 100%; background-color: #fff; float: left; margin-top: 10px;overflow: hidden;}
    #postBin .dbPost li{ float: left; height: 180px; padding-top: 60px; margin-top: 25px; text-align: center; font-size: 15px; position: relative; border: #c2c2c2 5px solid; margin-left: -5px;}
    #postBin .dbPost li:first-child{height: 70%;margin-top: 15px;margin-left: 15px; background-size: auto 96%;background-color: #F5F5F5; background-position: 50%;background-repeat: no-repeat; border: none}
    .postAction{ position: absolute; width: 100%; text-align: center;bottom: 10px; cursor: pointer;}
    .sSteez{font-size: 12px;color: #666666;font-size: 15px;font-weight: 100;}

    #dbModal{ position: fixed; width: 700px; height: 300px; border: #c2c2c2 thin solid; background-color: #fff; display: none; left: 50%; top: 50%; margin-top: -150px; margin-left: -350px; z-index: 1000010;overflow: scroll;}
    #dbModal ul{width: 90%;background-color: #c2c2c2;height: 150px;margin: 0px auto;margin-top: 10px;}
    #dbModal li{float: left;}
    #dbModal .avatarFrame{height: 100px;width: 100px; border-radius: 50px;margin-top: 25px;margin-left: 15px; overflow: hidden; background-position: 50%; background-size: 100%; background-repeat: no-repeat;}
    #dbModal .social_icon{float: right; width: 150px; height: 150px; background-size: 100%; background-repeat: no-repeat; background-position: 0% 35%;}
    #dbModal .facebook{background-image: url("/mobile/images/shareFb.png");}
    #dbModal .pinterest{background-image: url("/mobile/images/sharePintrest.png");}
    #dbModal .gplus{background-image: url("/mobile/images/shareGplus.png");}
    #dbModal .instagram{background-image: url("/mobile/images/shareInstagram.png");}
    #dbModal .text{background-image: url("/mobile/images/shareText.png");}
    #dbModal .twitter{background-image: url("/mobile/images/shareTwitter.png");}
    #dbModal .tumblr{background-image: url("/mobile/images/shareTumbler.png");}
    #dbModal .shareDeets{margin-top: 50px;margin-left: 10px;}
    #dbModal .shareDeets p:first-child{font-size: 18px;}
    #dbModal .shareDeets p{line-height: 10px;}
    .tranny{transition: all .5s; -webkit-transition: all .5s;}
    .sorter{cursor: pointer;}
    .filter{cursor: pointer;}

    #avatarUploadSystem{position: fixed; display: none;width: 150px; height: 205px; background-color: #fff; border: #c2c2c2 thin solid; text-align: center;}
    #avatarUploadSystem .avatarFrame{ width: 100px; height: 100px; margin: 10px auto; overflow: hidden; border-radius: 80px; background-size: 100%; background-repeat: no-repeat; background-position: 50%;}
    #avatarUploadSystem .swapButton{height: 25px; line-height: 25px; font-size: 14px; cursor: pointer;}
    #avatarUploadSystem .swapButton:hover{ color: #ff0066;}
    #avatarUploadSystem #percUpload{position: absolute; top: 0px; right: 0px; font-size: 12px;}

    #postLoversBin{position: fixed; width: 800px; top: 69px; background-color: #fff; left: 50%; margin-left: -400px;z-index: 111111;overflow: auto;}
    #postLoversBin .lover{width: 50%; float: left;height: 150px;}
    #postLoversBin .lover .avatarFrame{height: 100px; width: 100px; background-repeat: no-repeat; background-position: 50%; background-size: 100%; overflow: hidden; border-radius: 50px; margin-top: 25px; margin-left: 20px; float: left;margin-right: 15px; }
    #postLoversBin .lover .username{font-size: 16px; margin-top: 30px;}
    #postLoversBin .lover .followButt{float: left; font-size: 15px; padding: 2px 5px; cursor: pointer;}
    #postLoversBin .lover .FOLLOW{color: #F03E63; border: #F03E63 thin solid;}
    #postLoversBin .lover .FOLLOWING{color: #c2c2c2; border: #c2c2c2 thin solid;}

</style>
<? $_data['cart'] = get_cart(); ?>
<div id="dashboardHeader">
    <div class="dashboardInner">
        <div class="leftCol">
            <div class="avatarChangeButton" onclick="$('#avataro').closest('input').click();">+</div>
            <form id="avatarForm" action="/action/settings.php" method="post" enctype="multipart/form-data">
                <input type="file" name="avatar" id="avataro" onchange="new dahliawolf.uploadAvatar(this, this.files[0]);">
                <input type="hidden" name="dashboardAvatar" value="takemehome">
            </form>
            <div class="avatarFrame theUsersAvatar avatarShadow" style="background-image: url('<?= $_data['user']['avatar'] ?>&width=152')">
            </div>
            <a href="/<?= $_data['user']['username'] ?>"><div class="dbButton vpp">VIEW PUBLIC PROFILE</div></a>
        </div>
        <ul class="stats">
            <li class="uname">@<?= $_data['user']['username'] ?></li>
            <!--<li class="mLevel">Member Level: <?= $_data['user']['membership_level']['total_commissions'] ?></li>-->
            <li class="sSteez"><a href="/<?= $_data['user']['username'] ?>/followers"><?= $_data['user']['followers'] ?> FOLLOWERS</a> | <a href="/<?= $_data['user']['username'] ?>/following"><?= $_data['user']['following'] ?> FOLLOWING</a></li>
            <li class="sSteez"><?= $_data['user']['points'] ?> POINTS | </li>
        </ul>
        <ul class="cashOut">
            <li style="font-weight: 100;">ACCOUNT BALANCE</li>
            <li style="font-size: 32px;">$<?= round( intval($_data['cart']['available_store_credits']['total_credits']) , 2) ?></li>
            <li class="dbButton" style="width: 100px;" onClick="alert('coming soon');">CASH OUT</li>
        </ul>
    </div>
</div>
<div id="dataCol">
    <ul class="menuToggle">
        <li class="dbButton toggleDisplay choosed">POSTS</li>
        <li style="margin-left: 14px;" class="toggleDisplay">PRODUCTS</li>
    </ul>
    <ul id="filters">
        <li style="width: 32%;">
            <ul id="postSelector">
                <li class="filter" data-filter="is_active">ACTIVE(<?= $_data['user']['posts_active'] ?>)</li>
                <li class="filter" data-filter="is_expired">EXPIRED(<?= $_data['user']['posts_expired'] ?>)</li>
                <li class="filter" data-filter="is_winner">WINNERS(<?= $_data['user']['winner_posts'] ?>)</li>
            </ul>
        </li>
        <li class="sorter" style="width: 20%;" data-sorter="total_likes">VOTES</li>
        <li class="sorter" style="width: 16%;" data-sorter="total_views">VIEWS</li>
        <li class="sorter" style="width: 15.5%;" data-sorter="total_shares">SHARES</li>
        <li style="width: 15%;">TIME LEFT</li>
    </ul>
    <div id="postBin"></div>
    <p style="clear: left;"></p>
</div>
<script>
    console.log(<?= json_encode($_data['user']) ?>);
    console.log(<?= json_encode($_data['cart']) ?>);

    var dashboard = new Object();
    dashboard.limit = 12;
    dashboard.offset = 0;
    dashboard.feed = "posts";
    dashboard.$bin = $('#postBin');
    dashboard.isAvailable = true;
    dashboard.mode = 'post';

    dashboard.init = function() {
        dashboard.bindScroll();
        dashboard.getPosts();
        $('.toggleDisplay').on('click', $.proxy(this.toggleBin, this));
        $('.sorter').on('click', this.loadWithSorter);
        $('.filter').on('click', this.loadWithFilter);
    }

    dashboard.bindScroll = function() {
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
                dashboard.getPosts();
            }
        });
    }

    dashboard.loadWithSorter = function() {
        var sorter = $(this).data('sorter');

        if(sorter) {
            $('.sorter').css('border', 'none');
            $(this).css('border', '#000 thin solid');
            dashboard.sorter = sorter;
            dashboard.resetBin();
            dashboard.getPosts();
        }
    }

    dashboard.loadWithFilter = function() {
        var filter = $(this).data('filter');

        if(filter) {
            $('.filter').css('font-weight', 200)
            $(this).css('font-weight', 800);
            dashboard.filter = filter;
            dashboard.resetBin();
            dashboard.getPosts();
        }
    }

    dashboard.getPosts = function() {
        var that = this;
        var data = {user_id:dahliawolf.userId, feed : this.feed, offset : this.offset, limit: this.limit};

        if(this.sorter) {
            data.order_by = this.sorter;
        }

        if(this.filter) {
            data.filter = this.filter;
        }

        if(dashboard.isAvailable) {
            dahliawolf.loader.show();
            dashboard.isAvailable = false;
            //$.post('/action/getPostsByUser', data).done(function(data) {
            dahliawolf.post.get_by_user(data, function(data) {
                holla.log(data);
                dashboard.isAvailable = true;
                dahliawolf.loader.hide();
                $.each(data.data.get_by_user.posts, function(index, post) {
                    that.$bin.append(new dashboardPost(post));
                });
                that.$bin.append('<div style="clear:left"></div>');
                that.offset += data.data.get_by_user.posts.length;
            });
        }
    }

    dashboard.getProducts = function() {
        var that = this;
        var URL = '/api/commerce/product.json?function=get_products&user_id='+dahliawolf.userId+'&viewer_user_id='+dahliawolf.userId+'&use_hmac_check=0&id_shop=3&id_lang=1';

        if(dashboard.isAvailable) {
            dashboard.isAvailable = false;
            holla.log(URL);
            $.getJSON(URL, function(data) {
                dashboard.isAvailable = true;
                $.each(data.data.get_products.data, function(index, product) {
                    that.$bin.append(new dashboardProduct(product));
                });
            });
        }
    }

    function dashboardPost(data) {
        this.data = data;
        this.$post = $('<ul class="dbPost"></ul>');
        $('<a href="/post-details?posting_id='+this.data.posting_id+'" rel="modal"><li style="width: 30%; background-image: url(\''+this.data.image_url+'&width=300\')"></li></a>').appendTo(this.$post);
        this.$panel0 = $('<li style="width: 19%; margin-left: 10px;"><p>'+this.data.total_likes+' LOVES</p><p><span class="dahliaPink">'+(LOVE_REQUIRED - this.data.total_likes)+'</span> NEEDED TO WIN</p></li>').appendTo(this.$post);
        this.$panel1 = $('<li style="width: 15%;"><p>'+this.data.total_views+' VIEWS</p></li>').appendTo(this.$post);
        this.$panel2 = $('<li style="width: 15%;"><p>'+this.data.total_shares+' SHARES</p></li>').appendTo(this.$post);
        this.$panel3 = $('<li style="width: 15%;"><p>EXP: '+this.data.expiration_date+'</p></li>').appendTo(this.$post);
        if(Number(this.data.total_likes)){
            $('<div class="postAction">View Members</div>').appendTo(this.$panel0).on('click', $.proxy(this.getLovers, this));
        }
        if(Number(this.data.total_shares)) {
            $('<div class="postAction">View Shares</div>').appendTo(this.$panel2).on('click', $.proxy(dashboard.showShares, this));
        }
        $('<div class="postAction">More Time+</div>').appendTo(this.$panel3).on('click', $.proxy(dashboard.promotePost, this));

        return this.$post;
    }

    function dashboardProduct(data) {
        this.data = data;
        this.$product = $('<ul class="dbPost"></ul>');
        $('<li style="width: 30%; background-image: url(\''+this.data.inspiration_image_url+'&width=300\')"></li>').appendTo(this.$product);

        return this.$product;
    }

    dashboard.resetBin = function() {
        this.$bin.empty();
        this.offset = 0;
    }

    dashboard.toggleBin = function() {
        this.resetBin();

        if(this.mode === 'post') {
            $('.choosed').removeClass('choosed').next().addClass('choosed');
            this.getProducts();
            this.mode = 'product';
        } else {
            $('.choosed').removeClass('choosed').prev().addClass('choosed');
            this.getPosts();
            this.mode = 'post';
        }
    }

    dashboard.showShares = function() {
        var that = this;
        var $modal = $('<div id="dbModal" class="tranny"></div>').appendTo('body').fadeIn(200);
        var $overlay = $('<div id="tooltip-overlay"></div>').appendTo('body').fadeIn(200).on('click', function() {
            $overlay.fadeOut(100, function() {$(this.remove())});
            $modal.fadeOut(100, function() {$(this.remove())});
        });

        dahliawolf.share.get(this.data.posting_id, 'posting', function(data) {
            var modalHt = (data.data.get_shares.data.sharings.length * 160) + 10;
            $modal.height(modalHt).css({'top': ((window.innerHeight - modalHt) / 2), 'margin-top': 0}  );

            setTimeout(function() {
                $.each(data.data.get_shares.data.sharings, function(index, shares) {
                    var $user = $('<ul></ul>');
                    $user.append('<li><div class="avatarFrame" style="background-image: url('+shares.avatar+')"></div></li>');
                    $user.append('<li class="shareDeets"><p><a href="/'+shares.username+'">@'+shares.username+'</a></p><p>'+shares.location+'</p><p>is following '+shares.is_followed+'</p></li>');
                    $user.append('<li class="social_icon '+shares.network+'"></li>');
                    $user.appendTo($modal);
                });
            }, 800);
        });
    }

    dashboardPost.prototype.getLovers= function() {
        var blop = new showPostLovers(this.data.posting_id);
        /*dahliawolf.post.getLovers(this.data.posting_id, 12, 0, function(data) {
           console.log(data);
       });*/
    }

    dashboard.promotePost = function() {
        dahliawolf.post.promote(this.data.posting_id, function(data) {
            console.log(data);
        });
    }

    function showPostLovers(id) {
        var id = id;
        this.limit = 12;
        this.offset = 0;
        this.lovers = new Array();

        this.getId = function(){return id;}

        this.buildView();
        this.getLovers();
    }

    showPostLovers.prototype.buildView = function() {
        var that = this;
        this.$modal = $('<div id="postLoversBin"></div>').height(window.innerHeight-50).appendTo('body');
        $('body').css('overflow', 'hidden');

        var $overlay = $('<div id="tooltip-overlay"></div>').appendTo('body').fadeIn(200).on('click', function() {
            $overlay.fadeOut(100, function() {$(this.remove())});
            that.$modal.fadeOut(100, function() {$(this.remove())});
            $('body').css('overflow', 'visible');
        });
    }

    showPostLovers.prototype.getLovers = function() {
        var that = this;

        dahliawolf.post.getLovers(this.getId, this.limit, this.offset, function(data) {
            $.each(data.data.get_lovers.lovers, function(index, user) {
                var $user = $('<ul class="lover"></ul>');

                $user.append('<li class="avatarFrame" style="background-image: url(\''+this.avatar+'&width=75\')"></li>');
                $user.append('<li class="username"><a href="/'+user.username+'">@'+user.username+'</li>'+(user.location ? '<li>'+user.location+'</li>' : '') );
                var $followButt = $('<li class="followButt '+(Number(user.is_followed) ? 'FOLLOWING' : 'FOLLOW')+'">'+(Number(user.is_followed) ? 'FOLLOWING' : 'FOLLOW')+'</li>').appendTo($user).on('click', function() {
                    if(Number(user.is_followed)) {
                        $(this).html('FOLLOW').removeClass('FOLLOWING').addClass('FOLLOW');
                        user.is_followed = false;
                        dahliawolf.member.unfollow(user.user_id, function(data){
                            console.log(data);
                        });
                    } else {
                        $(this).html('FOLLOWING').removeClass('FOLLOW').addClass('FOLLOWING');
                        user.is_followed = true;
                        dahliawolf.member.follow(user.user_id);
                    }
                });
                $user.appendTo(that.$modal);
            });
        });
    }

    $(function() {
       dashboard.init();
    });

</script>