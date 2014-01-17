<?
    $pageTitle = "Sponsor";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

    if(!empty($_GET['username'])) {
        $user_params = array(
            'username' => $_GET['username']
        );
        $data = api_call('user', 'get_user', $user_params, true);
        $user = $data['data'];
    }
    include $_SERVER['DOCUMENT_ROOT'] . "/blocks/shopFilter.php";
?>

<style>
    #emptyShop li{margin: 15px 1px; float: left;}
    #emptyShop li:hover{opacity: .7;}
    #shopOwnerHeader{width: 1000px;margin: 0px auto;position: relative;margin-top: 10px;overflow: hidden;}
    #shopOwnerHeader img{width: 100%;}
    .shopOwnerTitle{position: absolute;margin-top: 90px;left: 71px;font-size: 30px; text-transform: uppercase; font-weight: bolder !important; width: 528px;text-align: center;overflow: hidden;text-overflow: ellipsis;}
    .shopEmpty{font-size: 20px; text-align: center; margin-top: 15px;}
    body{text-align: center;}

    .sponsorShop{width: 900px;}
    .sponsorShop .sponsorItem:first-child{margin-top: 40px;}
    .sponsorItem{display: inline-block; width: 100%; margin-top: 100px;}
    .sponsorItem .imgFrame{width: 50%; float: left; min-height: 300px;}
    .sponsorItem .imgFrame img{width: 80%;}
    .sponsorItem .sponsorDetails{width: 50%;float: left;font-size: 23px; text-align: left;}
    .sponsorItem .sponsorDetails li{margin-left: 10%; width: 90%;}
    .sponsorItem .lrgText{font-size: 65px;}
    .sponsorItem .greenbutton{color: #fff;
        background-color: #76bd22;
        padding: 20px 25px;
        display: inline-block;
        margin-top: 25px;
        width: initial !important;
    }
    .sponsorItem .sponsorBottom{width: 100%; float: left;border-top: #c2c2c2 thin solid; border-bottom: #c2c2c2 thin solid; padding-bottom: 40px; margin-top: 40px;}
    .sponsorBottom .bLeft{width: 50%;float: left;position: relative;}
    .sponsorItem .bLeft li:first-child{height: 100px;
        line-height: 100px;
        font-size: 21px;
    }
    .sponsorItem .bRight li:first-child{height: 100px;
        line-height: 100px;
        font-size: 21px;
    }
    .inspBy{
        color: #b1b1b1;
        font-size: 15px;
    }
    .sponsorItem .bLeft .avatar{
        width: 20%;
        height: 125px;
        background-size: auto 100%;
        background-position: 50%;
        float: left;
        background-repeat: no-repeat;
    }
    .sponsorItem .bLeft .about{
        font-size: 12px;
        line-height: 18px;
        height: 125px;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: left;
        float: left;
        width: 70%;
        margin-left: 7%;
    }
    .sponsorItem .rtLine{position: absolute; height: 80%; border-right: #c2c2c2 thin solid; margin-top: -12%; right: 0px;}
    #viewFilters{display: none;}
</style>

<? if( !empty($user['username']) ): ?>
    <div id="shopOwnerHeader">
        <div class="shopOwnerTitle"><a href="/<?= $user['username'] ?>"><?= $user['username'] ?>'s</a> boutique </div>
        <img src="/images/emptyShopBanner.jpg">
    </div>
<? endif ?>

<div id="dahliawolfShop" class="sponsorShop" style="width: 900px;"></div>

<?
    //include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
$(function() {
   new shop();
});


function shop(user) {
    var that = this;
    this.$shop = $('#dahliawolfShop');
    this.products = [];
    this.shopOwner = (user ? user : {});
    this.sort = null;
    this.priceSort = null;
    this.offset = 0;
    this.limit = 9;
    this.isShopBusy = false;

    $('#sortBar li:not(:first-child)').on('click', this.filterShop);

    this.loadProducts();
    this.bindFilters();
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
            that.loadProducts();
        }
    });
}

shop.prototype = {
    get getUrl() {
        var str = '/api/commerce/product.json?';
        str += 'function='+(this.sort ? 'get_category_products&id_category='+this.sort : 'get_products');
        str += (dahliawolf.isLoggedIn ? '&viewer_user_id='+dahliawolf.userId : '');
        str += (this.hasShopOwner ? '&user_id='+this.shopOwner.user_id : '');
        str += '&use_hmac_check=0&id_shop=3&id_lang=1';
        str += (this.priceSort ? '&sort=price-'+this.priceSort : '');
        str += '&limit='+this.limit;
        str += '&offset='+this.offset;
        str += '&filter_status=pre order';
        return str;
    },

    get hasShopOwner() {return (this.shopOwner.user_id ? true : false);}
}

shop.prototype.resetShop = function() {
    this.offset = 0;
    this.$shop.empty();
}

shop.prototype.bindFilters = function() {
    var that = this;
    $('#sortFilters a').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        $('.filter-select').removeClass('filter-select');
        $this.addClass('filter-select');
        that.sort = $this.data('sort');
        that.resetShop();
        that.loadProducts();
    });

    $('#viewFilters a').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        $('.view-select').removeClass('view-select');
        $this.addClass('view-select');

        that.$shop.removeClass('showLive showPreorder');

        switch($this.data('view')) {
            case 'available' :
                that.$shop.addClass('showLive');
                break;
            case 'preorder' :
                that.$shop.addClass('showPreorder');
                break;
            case 'asc' :
                that.priceSort = $this.data('view');
                that.resetShop();
                that.loadProducts();
                break;
            case 'desc' :
                that.priceSort = $this.data('view');
                that.shop.resetShop();
                that.loadProducts();
                break;
        }

    });
}

shop.prototype.loadProducts = function() {
    var that = this;

    if(!this.isShopBusy) {
        this.isShopBusy = true;
        dahliawolf.loader.show();
        $.getJSON(this.getUrl, function(data) {
            that.isShopBusy = false;
            dahliawolf.loader.hide();
            if(data.data.get_products && data.data.get_products.data.length) {
                that.offset += data.data.get_products.data.length;
                that.data = data.data.get_products.data;
                that.fillShop();
            } else if(data.data.get_category_products && data.data.get_category_products.data.length){
                that.offset += data.data.get_category_products.data.length;
                that.data = data.data.get_category_products.data;
                that.fillShop();
            } else if(that.shopOwner.username && _this.shopOwner.username != '') {
                that.fillEmptyShop();
            } else {
                $(window).unbind('scroll');
                //that.$shop.html('<h2>Our shop is temporarily out of service</h2>');
            }
        });
    }
}

shop.prototype.fillEmptyShop = function() {
    this.$shop.append('<div class="shopEmpty">'+(this.shopOwner.username === theUser.username ? 'Your shop is empty:( Start posting fashion images and getting votes right away!' : this.shopOwner.username + '\'s shop is empty')+'</div>');
    var str = '<ul id="emptyShop">';
    for(var x = 0; x < 8; x++) {
        str += '<li><img src="/images/shopExample.png"></li>';
    }
    str += '</ul>';
    this.$shop.append(str);
}

shop.prototype.fillShop = function() {
    var that = this;

    $.each(this.data, function(i, item) {
        that.$shop.append(new dahliawolf.$sponsor(item));
    });
}

shop.prototype.filterShop = function() {
    var filter = $(this).data('sort');

    $(this).siblings().removeClass('dahliaPink');
    $(this).addClass('dahliaPink');
    if(filter === 'Newest') {
        $('.shop-item').removeClass('hidden');
    } else {
        $('.shop-item[rel="'+filter+'"]').removeClass('hidden');
        $('.shop-item[rel!="'+filter+'"]').addClass('hidden');
    }
}

//************* product ************************
shop.prototype.product = function(item, $shop) {
    this.data = item;
    this.$shop = $shop;
    this.bgColors = {'Pre Order' : 'e195a7', 'Coming Soon' : 'C2C2C2', 'Sold Out' : '000', 'Live' : '000' };
    if(item.hasOwnProperty('posts')) {
        this.inspirationImage = item.inspiration_image_url+'&width=400';
    }

    this.addToShop();
}

shop.prototype.product.prototype.addToShop = function() {
    this.$view = $('<div class="shop-item" id="item-'+this.data.id_product+'" rel="'+this.data.status+'"></div>').appendTo(this.$shop);
    this.$hover = $('<div class="hoverData"></div>').appendTo(this.$view);
    //this.$hover./*append( this.getWishlistButton() ).append( this.getBuyButton() ).append('<div class="itemOverlay"></div>')*/.append( this.getInspirationButton() );
    this.$hover.append( this.getInspirationButton() );
    this.$image_view = $('<div class="product-details"></div>').appendTo(this.$view);
    this.$inspiration = $('<div class="inspirationImage"><img src="'+this.data.inspiration_image_url+'&width=400"></div>');
    if(this.data.product_images.length > 1) {
        this.$photoTwo = $('<div class="takeTwo">'+(this.data.status === 'Pre Order' ? '<div class="daysEnd"><span class="dahliaPink">'+getDaysLeft(this.data.commission_from_date)+' Days</span> <span style="font-style: italic; color: #000;"> left to pre-order at 30% OFF</span></div>' : '')+'<img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_images[1].product_file_id+'&width=400"></div>').appendTo(this.$image_view);
    }
    this.$inspiration.appendTo(this.$image_view);
    this.$inspiration_view = $('<div class="product-inspiration"></div>').appendTo(this.$view);
    this.$image_view.append( this.getPrice()).append( this.getImage()).wrap( $('<a href="/public_html/shop/'+this.data.id_product+'"></a>') );
    this.$inspiration_view.append( this.getInspiration() );
}

shop.prototype.product.prototype.getStatus = function() {
    switch (this.data.status) {
        case 'Coming Soon' :
            return '<div class="coming_soon"><h1>SAMPLE</h1><span class="wishlistCount dahliaPink">'+(1000 - Number(this.data.wishlist_count))+'</span> MORE WISHLIST ADDS</div>';
        case 'Sold Out' :
            return '<div class="sold-out">'+this.data.status+'</div>';
        case 'Pre Order' :
            return '<div class="pre-order">'+this.data.status+' 50% OFF</div>';
    }
}

shop.prototype.product.prototype.getPrice = function() {
    var str =  '<ul class="priceBox">' +
        '<li class="sale-price" style="'+(this.data.status === 'Pre Order' ? '' : 'visibility: hidden;')+'">$'+Math.floor(this.data.sale_price).toFixed(2)+' pre-order price</li>'+
        '<li style="'+(this.data.status === 'Pre Order' ? 'text-decoration: line-through;' : '')+'">$'+Math.floor(this.data.price).toFixed(2)+'</li>' +
        '</ul>';
    return '<div class="priceLine"><div class="product-name"></div>'+str+'</div>';
}

shop.prototype.product.prototype.getImage = function() {
    return '<div class="image-frame"><a href="/public_html/shop/'+this.data.id_product+'"><img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_file_id+'&width=400"></a></div>';
}

shop.prototype.product.prototype.getInspiration = function() {
    try{
        var username = (this.data.username ? this.data.username : this.data.posts[0].username);
    } catch(err) {
        var username = '';
    }
    return '<div class="prodTitle">'+this.data.product_name+'</div><ul><li class="avatarFrame avatarShadow" style="background-image: url(\''+this.data.avatar+'&width=100\');"></li><li>By <a href="/'+username+'">'+username+'</a></li></ul>'
}

shop.prototype.product.prototype.getWishlistButton = function() {
    if(this.data.wishlist_id && this.data.wishlist_id > 0) {
        this.$wishlistButton = $('<div class="wishlistButton overlayButton inWishlist">Already In Wishlist</div>').on('click', $.proxy(this.addToWishlist, this) );
    } else {
        this.$wishlistButton = $('<div class="wishlistButton overlayButton">Add To Wishlist</div>').on('click', $.proxy(this.addToWishlist, this) );
    }
    return this.$wishlistButton;
}

shop.prototype.product.prototype.getBuyButton = function() {
    var _this = this;
    this.$buyButton = $('<div class="buyButton overlayButton" style="background-color: #'+this.bgColors[this.data.status]+'">'+(this.data.status !== 'Live' ? this.data.status : 'BUY')+'</div>');

    if(this.data.status == 'Pre Order' || this.data.status == 'Live' || this.data.status == 'Coming Soon') {
        $(this.$buyButton).on('click', function() {
            document.location = '/shop/'+_this.data.id_product;
        });
    }
    return this.$buyButton;
}

shop.prototype.product.prototype.getInspirationButton = function() {
    var _this = this;

    this.$inspirationButton = $('<div class="inspirationButton"><a class="zoombox" data-url="'+this.data.inspiration_image_url+'"><span>VIEW INSPIRATION</span></a></div>').hover(
        function() {
            _this.$inspiration.css('left', 0);
        }, function() {
            _this.$inspiration.css('left', 100+'%');
        }
    );
    return this.$inspirationButton;
}

shop.prototype.product.prototype.addToWishlist = function() {
    var $count = this.$view.find('.wishlistCount');
    var _this = this;

    if(this.data.wishlist_id && this.data.wishlist_id > 0) {
        var URL =  '/api/commerce/wishlist.json?function=delete_from_wishlist&user_id='+theUser.id+'&id_favorite_product='+this.data.wishlist_id+'&use_hmac_check=0';
        $count.html( Number($count.html()) + 1 );
        this.$wishlistButton.removeClass('inWishlist').html('Add To Wishlist');
        this.data.wishlist_id = null;
        $.getJSON(URL, function(data) {
        });
    } else {
        var URL =  '/api/commerce/wishlist.json?function=add_wishlist&user_id='+theUser.id+'&id_product='+this.data.id_product+'&id_shop=3&use_hmac_check=0';
        $count.html( Number($count.html()) - 1 );
        this.$wishlistButton.addClass('inWishlist').html('Added To Wishlist');
        $.getJSON(URL, function(data) {
            if(data.data.add_wishlist.data) {
                _this.data.wishlist_id = data.data.add_wishlist.data;
            }
        });
    }
}
</script>