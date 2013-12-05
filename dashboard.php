<?php
if(!IS_LOGGED_IN) {
    die();
}
    $url = 'http://dev.commerce.offlinela.com/1-0/store_credit.json?function=get_user_credits_total&user_id='.$_SESSION['user']['user_id'].'&use_hmac_check=0';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
    $credits = round(floatval($result->data->get_user_credits_total->data->total_credits), 2);

    $url = 'http://dev.dahliawolf.com/api/1-0/user.json?function=get_sales&use_hmac_check=0&id_shop=3&id_lang=1&user_id='.$_SESSION['user']['user_id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
    $commision = round(floatval($result->data->get_sales->sales_total), 2);

    $url = 'http://dev.dahliawolf.com/api/1-0/posting.json?function=get_user_faves&use_hmac_check=0&user_id='.$_SESSION['user']['user_id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
    $faves = $result->data->get_user_faves;
?>

<style xmlns="http://www.w3.org/1999/html">
    #dashboardHeader{width: 100%; height: 150px;}
    #dashboardHeader .leftCol{float: left; width: 150px; position: relative;}
    #dashboardHeader .leftCol input{opacity: 0; width: 30px; float: right;}
    #dashboardHeader .leftCol .avatarChangeButton{ position: absolute; right: 14px; top: -6px;font-size: 32px; width: 30px; text-align: center; cursor: pointer;background-color: #666666; color: #f3f3f3;opacity: .7;height: 35px; line-height: 29px;}
    #dashboardHeader .dashboardInner{margin: 0px auto; width: 900px; padding-top: 25px;}
    #dashboardHeader .avatarFrame{width: 100px; height: 100px; overflow: hidden; border-radius: 50px;margin-left: 25px; background-position: 50%; background-repeat: no-repeat; background-size: 100%;}
    #dashboardHeader .avatarFrame img{width: 100%;}
    #dashboardHeader .mLevel{font-size: 15px; text-transform: capitalize; color: #fff; font-weight: bolder; background-color: #ff0066; width: 175px; text-indent: 5px !important;}
    #dashboardHeader .stats{width: 400px;float: left;margin-left: 10px;margin-top: 7px;}
    #dashboardHeader .cashOut{float: right; text-align: center;margin-top: 25px; font-size: 18px;}
    #dashboardHeader .cashOut div:first-child{border-right: #c2c2c2 thin solid;}
    #dashboardHeader .cashOut div{float: left; width: 125px;}
    #dashboardHeader .cashOut li{padding-bottom: 5px;}
    #dashboardHeader .dbButton{background-color: #fff; border: #000 thin solid; color: #000; padding: 2px 10px; margin: 0px auto; cursor: pointer; display: none;}
    #dashboardHeader .vpp{margin-top: 20px; padding: 5px 0px; text-align: center;}
    #dashboardHeader .uname{font-size: 18px; text-indent: 0px !important;}
    #dashboardHeader .stats li{padding: 3px 2px;}
    .choosed{border: #000 thin solid;}

    #dataCol{margin: 0px auto; width: 900px; margin-top: 30px; position: relative;}
    #dataCol .menuToggle{width: 202px; margin: 0px auto; height: 60px;}
    #dataCol .menuToggle li{width: 75px; margin-top: 13px; float: left; background-color: #fff; padding: 9px; font-size: 13px; text-align: center; cursor: pointer;}
    #dataCol #filters{ width: 100%; background-color: #fff; height: 25px; line-height: 25px; position: absolute; z-index: 1; height: 30px;line-height: 28px;}
    #dataCol #filters ul{float: left; text-align: center; border: #c2c2c2 thin solid; max-height: 30px;overflow: hidden; background-color: #fff; cursor: pointer;
        -moz-transition:height .25s, -moz-transform .25s;
        -webkit-transition:height .25s;
        -o-transition:height .25s, -o-transform .25s;
        transition:height .25s, transform .25s;}
    #filters .dbposts .onlyPosts{display: block;}
    #filters .dbposts .onlyProducts{display: none;}
    #filters .dbproducts .onlyProducts{display: block;}
    #filters .dbproducts .onlyPosts{display: none;}

    #dataCol #filters ul:hover{max-height:550px;}
    #dataCol #filters li{float: left; text-align: center; width: 33%; font-size: 11px; color: #666666; width: 100%;background-color: #fff;}
    #dataCol #filters li:hover{background-color: #c2c2c2;}
    #dataCol #postSelector{ width: 98%;}
    .menuTitle{border: #c2c2c2 thin solid; background-image: url("/images/dropDownArrow.png"); background-size: auto 47%; background-position: 98%; background-repeat: no-repeat;}

    #postBin{width: 100%; padding-bottom: 120px; padding-top: 60px;}
    .dbPost{height: 400px; width: 32%; background-color: #fff; float: left; margin-top: 10px; overflow: hidden; border: #c2c2c2 thin solid; margin-left: 1%; position: relative;}
    .dbPost:hover a{color: #666;}
    .dbPost li{ width: 90%; margin:0px auto;text-align: left;font-size: 12px;position: relative;height: 22px;line-height: 22px;}
    .dbPost .image{height: 70%; width: 90%;margin: 15px auto; background-size: 100% auto; background-color: #F5F5F5; background-position: 50%;background-repeat: no-repeat; border: none; position: relative;}
    .dbPost:hover .feature{display: block;}
    .dbPost .feature{height: 75px;width: 75px;border-radius: 75px;line-height: 75px;text-align: center;position: absolute;top: 50%;left: 50%; margin-left: -32.5px;margin-top: -56.5px;font-size: 11px;display: none; cursor: pointer;background-color: #E2E2E2;}
    .dbPost .feature:hover{opacity: .7;}
    .dbPost li p{padding: 0px; margin: 0px; width: 60%; float: left;}
    .dbPost li p:last-child{text-align: right; width: 40%;}
    .dbPost .needs{position: absolute;bottom: 0px;width: 100%;text-align: center;background-color: #e7e7e7;height: 25px;line-height: 25px;opacity: .8;font-size: 13px;margin: 0px;}
    .fave{background-image: url("/images/favesBG.jpg"); background-size: 100%; background-position: 50%;}
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
    .ranking{width: 40px;height: 40px;background-color: #000;text-align: center;color: #fff;line-height: 40px;font-size: 13px;}
    .ribbon{width: 50px;}

    #avatarUploadSystem{position: fixed; display: none;width: 150px; height: 205px; background-color: #fff; border: #c2c2c2 thin solid; text-align: center;}
    #avatarUploadSystem .avatarFrame{ width: 100px; height: 100px; margin: 10px auto; overflow: hidden; border-radius: 80px; background-size: 100%; background-repeat: no-repeat; background-position: 50%;}
    #avatarUploadSystem .swapButton{height: 25px; line-height: 25px; font-size: 14px; cursor: pointer;}
    #avatarUploadSystem .swapButton:hover{ color: #ff0066;}
    #avatarUploadSystem #percUpload{position: absolute; top: 0px; right: 0px; font-size: 12px;}

    #postLoversBin{position: fixed; width: 800px; top: 69px; background-color: #fff; left: 50%; margin-left: -400px;z-index: 111111;overflow: auto;}
    #postLoversBin .lover{width: 50%; float: left;height: 150px;}
    #postLoversBin .lover .avatarFrame{height: 100px; width: 100px; background-repeat: no-repeat; background-position: 50%; background-size: auto 100%; overflow: hidden; border-radius: 50px; margin-top: 25px; margin-left: 20px; float: left;margin-right: 15px; }
    #postLoversBin .lover .username{font-size: 16px; margin-top: 30px;}
    #postLoversBin .lover .followButt{float: left; font-size: 15px; padding: 2px 5px; cursor: pointer;}
    #postLoversBin .lover .FOLLOW{color: #F03E63; border: #F03E63 thin solid;}
    #postLoversBin .lover .FOLLOWING{color: #c2c2c2; border: #c2c2c2 thin solid;}

    #postFaves{position: relative;display: inline-block;width: 900px;left: 50%;margin-left: -450px;}
    #postBin .noProducts{width: 100%;text-align: center;font-size: 15px;margin-top: 25px;}
    .dbPost #pieStatus{position: absolute;width: 80px; height: 79px;bottom: 9px;right: 10px;}

</style>

<div id="dashboardHeader">
    <div class="dashboardInner">
        <div class="leftCol">
            <div class="avatarFrame theUsersAvatar avatarShadow" style="background-image: url('<?= $_data['user']['avatar'] ?>&width=152')">
            </div>
            <a href="/<?= $_data['user']['username'] ?>"><div class="dbButton vpp">VIEW PUBLIC PROFILE</div></a>
        </div>
        <ul class="stats">
            <li class="uname">@<?= $_data['user']['username'] ?></li>
            <!--<li class="mLevel">Member Level: <?= $_data['user']['membership_level']['total_commissions'] ?></li>-->
            <li class="sSteez"><a href="/<?= $_data['user']['username'] ?>/followers"><?= $_data['user']['followers'] ?> FOLLOWERS</a> | <a href="/<?= $_data['user']['username'] ?>/following"><?= $_data['user']['following'] ?> FOLLOWING</a></li>
            <li class="sSteez"><?= $_data['user']['points'] ?> POINTS | $<?= $commision ?> SALES</li>
        </ul>
        <ul class="cashOut">
            <div>
                <li class="dahliaPink">$<?= $credits ?></li>
                <li>Store Credit</li>
            </div>
            <div>
                <li class="dahliaPink">$<?= $_data['user']['status'] == 'vip' ? $commision*.1 : $commision*.05 ?></li>
                <li>Commission</li>
                <li class="dbButton" style="width: 100px;" onClick="alert('coming soon');">CASH OUT</li>
            </div>
        </ul>
    </div>
</div>

<div id="postFaves">
</div>

<div id="dataCol">
    <div id="filters">
        <ul id="typeSelector" style="width: 20%; margin-left: 1%;">
            <div class="menuTitle">Posts</div>
            <li data-filter="posts">Posts</li>
            <li data-filter="products">Products</li>
        </ul>
        <ul id="postSelector" class="dbposts" style="width: 38%; margin-left: 1%;">
            <div class="menuTitle">Active(<?= $_data['user']['posts_active'] ?>)</div>
            <li class="onlyPosts" data-filter="is_active">Active(<?= $_data['user']['posts_active'] ?>)</li>
            <li class="onlyPosts" data-filter="is_expired">Expired(<?= $_data['user']['posts_expired'] ?>)</li>
            <li class="onlyPosts" data-filter="is_winner">Winners(<?= $_data['user']['winner_posts'] ?>)</li>
            <li class="onlyProducts" data-filter="Live">Live</li>
            <li class="onlyProducts" data-filter="Pre Order">Pre Order</li>
        </ul>
        <ul id="viewSelector" class="dbposts" style="width: 38%;margin-left: 1%;">
            <div class="menuTitle">Loves</div>
            <li class="onlyPosts" data-filter="total_likes">Loves</li>
            <li class="onlyPosts" data-filter="total_views">Views</li>
            <li class="onlyPosts" data-filter="total_shares">Shares</li>
            <li class="onlyProducts" data-filter="views">Views</li>
            <li class="onlyProducts" data-filter="loves">Loves</li>
            <li >Time Left</li>
        </ul>
    </div>
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
    dashboard.defaultPostFilter = ['Active', 'is_active'];
    dashboard.defaultPostSorter = ['Loves', 'total_likes'];
    dashboard.defaultProductFilter = 'Live';
    dashboard.defaultProductSorter = 'Sales';
    dashboard.mode = 'post';
    dashboard.filter = 'is_active';
    dashboard.sorter = 'total_likes';
    dashboard.progressEnum = {'Submitted':1, 'Designed':2, 'Sample Made':3, 'Sample Shipped':4};

    dashboard.init = function() {
        dashboard.bindScroll();
        dashboard.bindFilter();
        dashboard.getPosts();
        dashboard.fillFaves(<?= json_encode($faves) ?>);
        $('.toggleDisplay').on('click', $.proxy(this.toggleBin, this));
        $('.sorter').on('click', this.loadWithSorter);
        $('.filter').on('click', this.loadWithFilter);
    }

    dashboard.fillFaves = function(faves) {
        var lefties = 0
        $.each(faves, function(x, fave) {
            $('#postFaves').append(new dashboardPost(fave.posting_data, true));
            lefties++;
        });
        while(lefties < 3) {
            $('#postFaves').append( new dashboard.getPlaceHolder() );
            lefties++;
        }
    }

    dashboard.getPlaceHolder = function() {
        return $('<div class="dbPost fave"></div>');
    }

    dashboard.bindFilter = function() {
        $('#typeSelector li').on('click', function() {
            var _this = dashboard;
            var filter = $(this).data('filter');
            var $menus = $('#filters ul').removeClass().addClass('db'+filter);
            _this.feed = filter;
            $(this).siblings('.menuTitle').html($(this).html());
            _this.resetBin();
            if(_this.feed === 'posts') {
                _this.filter = _this.defaultPostFilter[1];
                $('#postSelector .menuTitle').html(_this.defaultPostFilter[0]);
                _this.sorter = _this.defaultPostSorter[1];
                $('#viewSelector .menuTitle').html(_this.defaultPostSorter[0]);
                _this.getPosts();
            } else {
                $('#postSelector .menuTitle').html(_this.defaultProductFilter);
                $('#viewSelector .menuTitle').html(_this.defaultProductSorter);
                _this.getProducts();
            }
        });

        $('#postSelector li').on('click', function() {
            dashboard.filter = $(this).data('filter');
            $(this).siblings('.menuTitle').html($(this).html());
            dashboard.resetBin();
            if(dashboard.feed === 'posts') {
                dashboard.getPosts();
            } else {
                dashboard.getProducts();
            }
        });

        $('#viewSelector li').on('click', function() {
            dashboard.sorter = $(this).data('filter');
            $(this).siblings('.menuTitle').html($(this).html());
            dashboard.resetBin();
            if(dashboard.feed === 'posts') {
                dashboard.getPosts();
            } else {
                dashboard.getProducts();
            }
        });
    }

    dashboard.bindScroll = function() {
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
                if(dashboard.feed == 'posts') {
                    dashboard.getPosts();
                } else {
                    dashboard.getProducts();
                }
            }
        });
    }

    dashboard.unbindScroll = function() {
        $(window).unbind('scroll');
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
                dashboard.isAvailable = true;
                dahliawolf.loader.hide();
                if(data.data.get_by_user.posts && data.data.get_by_user.posts.length) {
                    $.each(data.data.get_by_user.posts, function(index, post) {
                        that.$bin.append(new dashboardPost(post));
                    });
                    that.$bin.append('<div style="clear:left"></div>');
                    that.offset += data.data.get_by_user.posts.length;
                } else {
                    that.unbindScroll();
                }
            });
        }
    }

    dashboard.getProducts = function() {
        var that = this;
        var URL = '/api/commerce/product.json?function=get_products&user_id='+dahliawolf.userId+'&viewer_user_id='+dahliawolf.userId+'&use_hmac_check=0&id_shop=3&id_lang=1&filter_status=0&filter_active=0';

        if(dashboard.isAvailable) {
            dashboard.isAvailable = false;
            $.getJSON(URL, function(data) {
                dashboard.isAvailable = true;
                if(data.data.get_products.data && data.data.get_products.data.length) {
                    $.each(data.data.get_products.data, function(index, product) {
                        that.$bin.append(new dashboardProduct(product, false, index));
                    });
                } else {
                    that.$bin.append('<div class="noProducts">Unfortunately you have not had any products made yet. Keep posting images and share them to get products made.</div>');
                }

                dashboard.unbindScroll();
            });
        }
    }

    function dashboardPost(data, is_fave) {
        var postData = data;
        this.data = data;
        this.$post = $('<ul class="dbPost"></ul>');
        var $img = $('<div class="image" style="background-image: url(\''+this.data.image_url+'&width=300\')"><p class="needs">'+(1000 - this.data.total_likes)+' Needed to Win</p></div>');
        if(!is_fave) {
            var $rank = $('<div class="ranking">'+($('#postBin .dbPost').length+1)+'</div>').appendTo( $img );
            var $feature = $('<div class="feature">FEATURE</div>').appendTo($img).on('click', function(e) {
                var that = this;
                dahliawolf.post.addToFaves(data.posting_id, function(data) {
                    if(data.data.fave.posting_fave_id) {
                        var $first = $('#postFaves .fave').first();
                        $('#postFaves').append(new dashboardPost(postData, true) );
                        $first.remove();
                        $(that).remove();
                        $rank.remove();
                        $img.append('<img class="ribbon" src="/images/featuredRibbon.png">');
                    } else if(data.data.fave.errors) {
                        alert(data.data.fave.errors[0]);
                    }
                });
            });
        } else {
            $img.append('<img class="ribbon" src="/images/featuredRibbon.png">');
            var $feature = $('<div class="feature">UNFEATURE</div>').appendTo($img).on('click', function() {
                $(this).closest('.dbPost').remove();
                $('#postFaves').append( new dashboard.getPlaceHolder() );
                dahliawolf.post.delFromFaves(data.posting_id, function(data) {
                    //
                });
            });
        }
        $img.appendTo(this.$post);
        $('<li><p>Views..... '+this.data.total_views+'</p><p></p></li>').appendTo(this.$post);
        if(Number(this.data.total_likes)) {
            $('<li><p>Loves...... '+this.data.total_likes+'</p><p>VIEW</p></li>').appendTo(this.$post).on('click', $.proxy(this.getLovers, this));
        } else {
            $('<li><p>Loves...... '+this.data.total_likes+'</p><p></p></li>').appendTo(this.$post);
        }
        if(Number(this.data.total_shares)) {
            $('<li><p>Shares.... '+this.data.total_shares+'</p><p>VIEW</p></li>').appendTo(this.$post).on('click', $.proxy(dashboard.showShares, this));
        } else {
            $('<li><p>Shares.... '+this.data.total_shares+'</p><p></p></li>').appendTo(this.$post);
        }
        $('<li><p>Expires... '+this.data.expiration_date+'</p><p></p></li>').appendTo(this.$post);

        return this.$post;
    }

    function dashboardProduct(data) {
        console.log(dashboard.progressEnum[data.status]/4);
        this.data = data;
        this.$product = $('<ul class="dbPost"></ul>');
        var $img = $('<div class="image" style="background-image: url(\'http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_file_id+'&width=300\')"><p class="needs">Status: '+data.status+'</p></div>').appendTo(this.$product);

        if(data.status === 'Pre Order' || data.status === 'Live') {
            $('<li><p>Views..... 0</p><p></p></li>').appendTo(this.$product);
            $('<li><p>Shares.... 0</p><p>VIEW</p></li>').appendTo(this.$product);
            $('<li><p>Sales..... 0</p><p>VIEW</p></li>').appendTo(this.$product);
        } else {
            $('<li><p class="'+(data.status === 'Submitted' ? 'dahliaPink' : '')+'">1. Submitted</p><p></p></li>').appendTo(this.$product);
            $('<li><p class="'+(data.status === 'Designed' ? 'dahliaPink' : '')+'">2. Designed</p><p></p></li>').appendTo(this.$product);
            $('<li><p class="'+(data.status === 'Sample Made' ? 'dahliaPink' : '')+'">3. Produced</p><p></p></li>').appendTo(this.$product);
            $('<li><p class="'+(data.status === 'Sample Shipped' ? 'dahliaPink' : '')+'">4. Shipped</p><p></p></li>').appendTo(this.$product);
            $('<div id="pieStatus"><img src="/images/prodStatus_'+dashboard.progressEnum[data.status]+'.png"></div>').appendTo(this.$product);
        }

        return this.$product;
    }

    dashboard.resetBin = function() {
        $('body').scrollTop(0);
        this.$bin.empty();
        this.offset = 0;
        this.bindScroll();
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
            if(data.data.get_lovers.lovers.length) {
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
            }
        });
    }

    $(function() {
       dashboard.init();
    });

</script>