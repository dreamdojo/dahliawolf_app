<?
    $pageTitle = "Shop";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

    require DR . '/includes/php/classes/Product_Listing.php';
    $Product_Listing = new Product_Listing()
?>
<style>
#dahliawolfShop{ width: 1050px;margin: 0 auto;position: relative; margin-top: 10px;}
#dahliawolfShop .shop-item{width: 250px;overflow: hidden;height: 500px;float: left;position: relative;border: #c2c2c2 thin solid;margin-left: 5px;margin-right: 5px;margin-bottom: 50px;}
#dahliawolfShop .product-details{width: 100%;height: 420px;overflow: hidden;position: relative;}
#dahliawolfShop .image-frame{width: 100%;height: 100%;position: relative;}
#dahliawolfShop .image-frame img{ width: 100%;}
#dahliawolfShop .item-status{position: absolute;right: 0px;font-size: 18px; z-index: 1}
#dahliawolfShop .priceLine{position: absolute;width: 100%;bottom: 10px; z-index: 1}
#dahliawolfShop .product-name{float: left;font-size: 17px;text-indent: 10px;width: 170px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;text-transform: uppercase;font-size: 11px;line-height: 21px;}
#dahliawolfShop .product-inspiration{border-top: #c2c2c2 thin solid;}
#dahliawolfShop .product-price{float: right;font-size: 18px;margin-right: 10px;}
#dahliawolfShop .avatarFrame{float: left;width: 50px;overflow: hidden;border-radius: 50px;height: 50px;margin: 15px 8px;}
#dahliawolfShop .avatarFrame img{width: 100%;}
#dahliawolfShop .inspire{font-size: 13px;overflow: hidden;text-overflow: ellipsis;padding-top: 20px;}
#dahliawolfShop .sold-out{background-color: #000;position: absolute;right: -29px;top: 19px;z-index: 1;color: #fff;font-size: 18px;padding: 3px 30px; overflow:hidden; -webkit-transform: rotate(45deg); -moz-transform: rotate(45deg);-ms-transform: rotate(45deg); -o-transform: rotate(45deg);}
#dahliawolfShop .coming_soon{position: absolute;top: 7px;right: 7px;z-index: 1;text-align: center;background-color: #dddddd; color: #595959; width: 100px;height: 60px;}
#dahliawolfShop h1{margin: 0;font-weight: 100;font-size: 20px;}
#dahliawolfShop .pre-order{background-color: #eb1d5d;position: absolute;right: 7px;z-index: 1;top: 7px;height: 75px;width: 75px;border-radius: 50px;line-height: 75px;text-align: center;color: #fff;font-size: 14px;}
#dahliawolfShop .shop-item:hover .hoverData{display: block;}
#dahliawolfShop .hoverData{position: absolute;width: 100%;height: 100%;z-index: 3;top: 0px;left: 0px; display:none;}
#dahliawolfShop .itemOverlay{position: absolute;z-index: 1;background-color: #fff;width: 100%;height: 100%;top: 0;left: 0;opacity: .7;}
#dahliawolfShop .overlayButton{position: absolute;z-index: 2; padding: 8px 10px; font-size: 18px; left: 50%;margin-left: -84px;width: 150px; text-align: center;cursor: pointer;}
#dahliawolfShop .overlayButton:hover{opacity: .7;}
#dahliawolfShop .wishlistButton{background-color: #5e5e5e; color: #fff;margin-top: 110px;}
#dahliawolfShop .buyButton{background-color: #5e5e5e; color: #fff;margin-top: 150px;}
#dahliawolfShop .inspirationButton{background-color: #5e5e5e; color: #fff;bottom: 0px;position: absolute;bottom: 0px;left: 0px;height: 79px;font-size: 18px;line-height: 70px;width: 100%;text-align: center;z-index: 3; cursor: pointer;}
#dahliawolfShop .inspirationButton:hover{color: #c86362; }
#dahliawolfShop .inspirationImage{ position: absolute;width: 100%;z-index: 33;left: 100%; transition: left .2s; -webkit-transition: left .2s;}
#dahliawolfShop .inWishlist{background-color: #f4a5b4 !important;white-space: nowrap; text-indent: -8px;}

#sortBar{width: 1038px;background-color: #c2c2c2;height: 20px;margin: 0px auto;text-indent: 10px;}
#sortBar li:not(:first-child){ cursor: pointer;}
#sortBar li{float: left;font-size: 13px;}
</style>
    <ul id="sortBar">
        <li>sort products by: </li>
        <li data-sort="Newest">newest / </li>
        <li data-sort="Coming Soon">samples / </li>
        <li data-sort="Live">available / </li>
        <li data-sort="Pre Order" class="dahliaPink">pre-order 50% off</li>
    </ul>
<div id="dahliawolfShop"></div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
function shop(data) {
    this.$shop = $('#dahliawolfShop');
    this.products = [];

    $('#sortBar li:not(:first-child)').on('click', this.filterShop);

    this.loadProducts();

}

shop.prototype.loadProducts = function() {
    var _this = this

    var URL = '/api/commerce/product.json?function=get_products'+(theUser.id ? '&viewer_user_id='+theUser.id : '')+'&use_hmac_check=0&id_shop=3&id_lang=1';

    $.getJSON(URL, function(data) {
        if(data) {
            _this.data = data.data.get_products.data;
            _this.fillShop();
        } else {
            holla.log('wump');
        }
    });
}

shop.prototype.fillShop = function() {
    var _this = this;

    $.each(this.data, function(i, item) {
        _this.products[item.id_product] = new _this.product(item, _this.$shop)
    });
}

shop.prototype.filterShop = function() {
    var filter = $(this).data('sort');

    $(this).css('font-weight', 'bolder').siblings().css('font-weight',  'normal')
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
    this.$hover.append( this.getWishlistButton() ).append( this.getBuyButton() ).append('<div class="itemOverlay"></div>').append( this.getInspirationButton() );
    this.$image_view = $('<div class="product-details"></div>').appendTo(this.$view);
    this.$inspiration = $('<img class="inspirationImage" src="'+this.inspirationImage+'">').appendTo(this.$image_view);
    this.$inspiration_view = $('<div class="product-inspiration"></div>').appendTo(this.$view);
    this.$image_view.append( this.getStatus() ).append( this.getPrice()).append( this.getImage() );
    this.$inspiration_view.append( this.getInspiration() );
}

shop.prototype.product.prototype.getStatus = function() {
    switch (this.data.status) {
        case 'Coming Soon' :
            return '<div class="coming_soon"><h1>SAMPLE</h1> NEEDS <span class="wishlistCount dahliaPink">'+(1000 - Number(this.data.wishlist_count))+'</span> MORE WISHLIST ADDS</div>';
        case 'Sold Out' :
            return '<div class="sold-out">'+this.data.status+'</div>';
        case 'Pre Order' :
            return '<div class="pre-order">'+this.data.status+'</div>';
    }
}

shop.prototype.product.prototype.getPrice = function() {
    return '<div class="priceLine"><div class="product-name">'+this.data.product_name+'</div><div class="product-price">$'+Math.floor(this.data.price).toFixed(2)+'</div></div>';
}

shop.prototype.product.prototype.getImage = function() {
    return '<div class="image-frame"><img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_file_id+'&width=400"></div>';
}

shop.prototype.product.prototype.getInspiration = function() {
    try{
        var username = (this.data.username ? this.data.username : this.data.posts[0].username);
    } catch(err) {
        var username = '';
    }
    return '<ul><li class="avatarFrame avatarShadow"><img src="/avatar.php?user_id='+this.data.user_id+'"></li><li class="inspire"><span class="dahliaPink">Inspired By </span><a href="/'+username+'">'+username+'</a></li><li>'+this.data.location+'</li></ul>'
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

    if(this.data.status == 'Pre Order') {
        $(this.$buyButton).on('click', function() {
            document.location = '/shop/'+_this.data.id_product;
        });
    }
    return this.$buyButton;
}

shop.prototype.product.prototype.getInspirationButton = function() {
    var _this = this;

    this.$inspirationButton = $('<div class="inspirationButton">VIEW INSPIRATION</div>').hover(
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
        var URL =  '/api/commerce/wishlist.json?function=delete_from_wishlist&user_id='+theUser.id+','+this.data.fake_user_id+'&id_favorite_product='+this.data.wishlist_id+'&use_hmac_check=0';
        $count.html( Number($count.html()) + 1 );
        this.$wishlistButton.removeClass('inWishlist').html('Add To Wishlist');
        this.data.wishlist_id = null;
        $.getJSON(URL, function(data) {
            holla.log(data);
        });
    } else {
        var URL =  '/action/shop/add_item_to_wishlist.php?id_product='+this.data.id_product+'&ajax=true';
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
$(function() {
    dahliawolfShop = new shop(<?= json_encode( $_data['products'] ) ?>);
});
</script>