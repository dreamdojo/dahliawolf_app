function shop(user) {
    this.$shop = $('#dahliawolfShop');
    this.products = [];
    this.shopOwner = (user ? user : {});

    $('#sortBar li:not(:first-child)').on('click', this.filterShop);

    this.loadProducts();
    this.centerShop();
    $(window).resize($.proxy(this.centerShop, this));
}

shop.prototype.centerShop = function() {
    if(window.innerWidth > 330*3) {
        this.$shop.width(330*3).css('margin', 0+'px auto');
    }else {
        this.$shop.css('margin-left', (window.innerWidth % 330)/2).css('width', 'auto');
    }
}

shop.prototype.loadProducts = function() {
    var _this = this

    var URL = '/api/commerce/product.json?function=get_products'+(theUser.id ? '&viewer_user_id='+theUser.id : '')+'&use_hmac_check=0&id_shop=3&id_lang=1';
    if(this.shopOwner.user_id) {
        URL += '&user_id='+this.shopOwner.user_id
    }

    dahliawolf.loader.show();
    $.getJSON(URL, function(data) {
        dahliawolf.loader.hide();
        if(data.data.get_products.data.length) {
            _this.data = data.data.get_products.data;
            _this.fillShop();
        } else if(_this.shopOwner.username && _this.shopOwner.username != '') {
            _this.fillEmptyShop();
        } else {
            _this.$shop.html('<h2>Our shop is temporarily out of service</h2>');
        }
    });
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
    var _this = this;

    $.each(this.data, function(i, item) {
        if(Number(item.active) && !_this.products[item.id_product]) {
            _this.products[item.id_product] = new _this.product(item, _this.$shop)
        }
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
    holla.log(this);
    this.$view = $('<div class="shop-item" id="item-'+this.data.id_product+'" rel="'+this.data.status+'"></div>').appendTo(this.$shop);
    this.$hover = $('<div class="hoverData"></div>').appendTo(this.$view);
    //this.$hover./*append( this.getWishlistButton() ).append( this.getBuyButton() ).append('<div class="itemOverlay"></div>')*/.append( this.getInspirationButton() );
    this.$hover.append( this.getInspirationButton() );
    this.$image_view = $('<div class="product-details"></div>').appendTo(this.$view);
    this.$inspiration = $('<div class="inspirationImage"><img src="'+this.data.inspiration_image_url+'"></div>');
    if(this.data.product_images.length > 1) {
        this.$photoTwo = $('<div class="takeTwo">'+(this.data.status === 'Pre Order' ? '<div class="daysEnd"><span class="dahliaPink">'+getDaysLeft(this.data.commission_from_date)+' Days</span> <span style="font-style: italic; color: #000;"> left to pre-order at 30% OFF</span></div>' : '')+'<img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_images[1].product_file_id+'&width=400"></div>').appendTo(this.$image_view);
    }
    this.$inspiration.appendTo(this.$image_view);
    this.$inspiration_view = $('<div class="product-inspiration"></div>').appendTo(this.$view);
    this.$image_view.append( this.getPrice()).append( this.getImage()).wrap( $('<a href="/shop/'+this.data.id_product+'"></a>') );
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
    return '<div class="image-frame"><a href="/shop/'+this.data.id_product+'"><img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_file_id+'&width=400"></a></div>';
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
            holla.log(data);
        });
    } else {
        var URL =  '/api/commerce/wishlist.json?function=add_wishlist&user_id='+theUser.id+'&id_product='+this.data.id_product+'&id_shop=3&use_hmac_check=0';
        $count.html( Number($count.html()) - 1 );
        this.$wishlistButton.addClass('inWishlist').html('Added To Wishlist');
        $.getJSON(URL, function(data) {
            if(data.data.add_wishlist.data) {
                _this.data.wishlist_id = data.data.add_wishlist.data;
            }
            holla.log(data);
        });
    }
}