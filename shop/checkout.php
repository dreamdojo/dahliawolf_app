<?
$pageTitle = "Shop - Checkout";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<style>
    .customer-col{width: 500px;}
    .customer-col{width: 50%; float: left;}
    .cart-col{width: 50%; float: left;}
    #theCart{width: 400px;min-height: 400px;background-color: #ebebeb;margin-top: 69px;}
    .cartHeader{width: 100%;height: 100px;}
    .cartHeader .title{width: 170px;text-align: center;line-height: 70px;font-size: 15px;float: left;}
    .cartHeader .editButton{float: right;padding: 8px 25px;background-color: #666;color: #fff;margin: 18px;}
    .cartProducts{height: 80px;display: inline-table; width: 100%;}
    .cartProducts li{float: left; height: 80px; line-height: 80px;}
    .cartProducts .thumbnail{height: 100%;overflow: hidden;width: 30%;text-align: center;}
    .cartProducts .thumbnail img{height: 100%;}
    .cartProducts .prodTitle{width: 50%;}
    .cartProducts .prodPrice{width: 20%;}
    .cartProducts div{display: inline-block;width: 100%;height: 90px;margin-bottom: 10px;}
    .cartTotals{margin-top: 20px;display: inline-block;width: 100%;margin-bottom: 20px;}
    .cartTotals li{font-size: 16px;width: 100%;text-align: center;height: 25px;line-height: 25px; margin-bottom: 5px;}
    .cartTotals .lefty{width: 50%; float: left; text-align: right;color: #AFAFAF;}
    .cartTotals .righty{width: 50%; float: left; text-align: left; text-indent: 10px;}
    .shop select{background-image: url("/images/checkoutArrow.png");background-size: auto 50%;background-repeat: no-repeat;background-position: 96%;font-size: 13px; text-indent: 22px;font-family: futura;}
    .coTitle{width: 100%; text-align: center; font-size: 25px;}
    .shop input{font-size: 12px;height: 37px;text-indent: 10px;}
    .shop .StaticForm{margin: 20px 0;}
    #theCart .gTotes{height: 50px !important; line-height: 50px !important;}
    #theCart .alisMessageInABottle{font-size: 14px;width: 80%;margin: 20px auto;padding-bottom: 63px;text-align: center;}
    #carrierForm{position: relative;}
    #alisBeeper{position: absolute;margin-top: 1px;margin-left: 1px;width: 74%; display: none;}
    #alisBeeper img{width: 100%;}
    @-moz-document url-prefix() {
        .shop select{padding-top: 9px;text-indent: 10px;font-size: 15px;}
    }
</style>

<div class="shop body checkout">
    <div class="coTitle">SECURE CHECKOUT</div>
    <div class="customer-col">
        <div class="co-section">
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/common/checkout/billing.php"; ?>
        </div>
        <div class="co-section">
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/common/checkout/shipping.php"; ?>
        </div>
        <div class="co-section">
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/common/checkout/creditcard.php"; ?>
        </div>
    </div>
    <div class="cart-col">
        <div id="theCart"></div>
    </div>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
    function dahliaCheckout(cart) {
        this.data = cart;
        this.$cart = $('#theCart');

        $('#shippingForm').on('submit', this.checkAddress);
        $('#shippingForm input').on('blur',{noShow:true}, this.checkAddress);
        $('#shippingOptions').on('change', this.saveShippingOption);
        $('#billing_address_id').on('change', this.popFromSaved);
        $('.pMets').on('click', this.paymentOptionClicked);
        $(document).on('focus', '.fail', this.makeGoodFail);

        this.buildCart();
    }

    dahliaCheckout.prototype.makeGoodFail = function() {
        $(this).one('blur', function() {
            if( !$(this).val() == '' ) {
                $(this).removeClass('fail');
            }
        });
    }

    dahliaCheckout.prototype.paymentOptionClicked = function() {
        var $this = $(this);

        if(!$this.find('input').prop('checked')) {
            $('#place_order_form').find('input').attr('checked', false);
            $('#set_paypal').toggle();
            $('#credit_card_fields').toggle();
            $('.button').toggle();
            if( $this.hasClass('selectoBismol') ) {
                $('#place_order_form .selectoBismol').removeClass('selectoBismol');
                $this.find('input').attr('checked', false);
                $this.removeClass('selectoBismol');
            } else {
                $('#place_order_form .selectoBismol').removeClass('selectoBismol');
                $this.find('input').attr('checked', 'checked');
                $this.addClass('selectoBismol');
            }
        }
    }

    dahliaCheckout.prototype.showShipLoader = function() {
        $('#alisBeeper').show();
    }

    dahliaCheckout.prototype.hideShipLoader = function() {
        $('#alisBeeper').hide();
    }


    dahliaCheckout.prototype.clearAddressFields = function() {
        $.each($('#billing-address-fields input'), function(x, field) {
            $(field).val('');
        });
        $.each($('#billing-address-fields select'), function(x, field) {
            $(field).val('');
        });
    }

    dahliaCheckout.prototype.popFromSaved = function(event) {
        if (this.value == '') {
            dahliawolfCheckout.clearAddressFields();
        }
        else {
            var $data = $(this).find('option:selected');
            $('input[name="billing_first_name"]').val($data.data('first_name') );
            $('input[name="billing_last_name"]').val($data.data('last_name') );
            $('select[name="billing_country"]').val($data.data('country') );
            $('input[name="billing_address"]').val($data.data('street') );
            $('input[name="billing_city"]').val($data.data('city') );
            if( $data.data('state') ) {
                $('<option selected="selected" value="'+$data.data('state')+'">'+$data.data('state')+'</option>').appendTo($('select[name="billing_state"]'));
            }
            $('input[name="billing_zip"]').val($data.data('zip') );
            $('input[name="billing_phone"]').val($data.data('phone') );
            if( $('#populate-shipping-from-billing').prop('checked') ) {
                dahliawolfCheckout.checkAddress();
            }
        }
    }

    dahliaCheckout.prototype.saveShippingOption = function() {
        if( $(this).hasClass('fail') && $(this).val() != '' ) {
            $(this).removeClass('fail');
        }

        var data = $('#carrierForm').serialize();
        $('.cartTotals').empty().append('<div class="totalLoader"><img src="/images/loading-transparent.gif"></div>');
        $.post('/action/shop/select_checkout_carrier.php', data, function(data) {
            dahliawolfCheckout.loadCart(function(data) {
                dahliawolfCheckout.updateCart(data);
            });
        });
    }

    dahliaCheckout.prototype.checkAddress = function(e) {
        if(typeof e == 'undefined') {
            var e = {};
            e.data = {};
            e.data.noShow = false;
        }
        var fail = false;

        if( $('#populate-shipping-from-billing').prop('checked') ) {
            popShippingFromBilling();
        }


        $.each( $('.isRequired'), function(x, inp) {
            var $field = $(inp);
            if( !$field.val() || $field.val() === '' ) {
                if(!e.data.noShow) {
                    $field.addClass('fail');
                }
                fail = true;
            } else if($field.hasClass('fail') ) {
                if(!e.data.noShow) {
                    $field.removeClass('fail');
                    $field.addClass('good');
                }
            } else {
                if(!e.data.noShow) {
                    $field.addClass('good');
                }
            }
        });

        if( $('#shipping_address_id').val() > 0 ) {

        } else{
            $.each( $('.isAlsoRequired'), function(x, inp) {
                var $field = $(inp);
                if( !$field.val() || $field.val() === '' ) {
                    if(!e.data.noShow) {
                        $field.addClass('fail');
                    }
                    fail = true;
                } else if($field.hasClass('fail') ) {
                    if(!e.data.noShow) {
                        $field.removeClass('fail');
                        $field.addClass('good');
                    }
                } else {
                    if(!e.data.noShow) {
                        $field.addClass('good');
                    }
                }
            });
        }

        if(!fail) {
            console.log('Saving Address');
            dahliawolfCheckout.saveAddress();
            return false;
        } else {
            console.log('Check address and FAILED VALIDATION');
            return false;
        }
    }

    dahliaCheckout.prototype.loadCart = function(callback) {
        $.getJSON('/action/shop/loadCart.php', function(data) {
           if(typeof callback == 'function') {
               callback(data);
           }
        });
    }

    dahliaCheckout.prototype.saveAddress = function() {
        var data = $('#shippingForm').serialize();
        var that = this;

        that.showShipLoader();
        $.post('/action/shop/billing.php', data, function(data) {
            var data = $.parseJSON(data);
            if(!$('select[name=billing_address_id]').length) {
                $('#shippingForm').prepend('<input type="hidden" name="billing_address_id" value="'+data.billing+'">');
            }
            if(!$('select[name=shipping_address_id]').length) {
                $('#shippingForm').prepend('<input type="hidden" name="shipping_address_id" value="'+data.shipping+'">');
            }
            that.loadCart(function(data) {
                that.hideShipLoader();
                if(data.carrier_options.length)
                that.updateShippingOptions(data.carrier_options);
            });
        });
    }

    dahliaCheckout.prototype.updateShippingOptions = function(options) {
        var $options = $('#shippingOptions');
        $options.empty();
        $options.addClass('fail').append('<option slected="selected">PLEASE SELECT A SHIPPING METHOD</option>');
        $.each(options, function(x, option) {
            $options.append('<option id="id_delivery_'+option.id_delivery+'" value="'+option.id_delivery+'">'+option.carrier_name+' - '+option.delay+' $'+Math.round(option.price * 100) / 100+'</option>');
        });
    }

    dahliaCheckout.prototype.updateCart = function(cart) {
        var $section = $('.cartTotals');
        this.data = cart;
        this.$cart.empty();
        this.buildCart();
        $('#gTotes').val(cart.cart.totals.grand_total);
    }

    dahliaCheckout.prototype.buildCart = function() {
        var $cart = $('#theCart');
        $cart.append('<ul class="cartHeader"><li class="title">ORDER SUMMARY</li><a href="/shop/cart"><li class="editButton">EDIT</li></a></ul>');
        var $products = $('<ul class="cartProducts"></ul>');
        var subtotal = 0;

        $.each(this.data.products, function(x, product) {
            var price = (product.product_info.sale_price ? product.product_info.sale_price : product.product_info.price);
            price = Math.round(price * 100) / 100;
            subtotal += price;
            var $p = $('<div></div>');
            $p.append('<li class="thumbnail"><img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+product.product_info.product_file_id+'&width=80"></li>');
            $p.append('<li class="prodTitle">'+product.product_info.product_name+'</li>');
            $p.append('<li class="prodPrice">$'+price.toFixed(2)+'</li>');
            $p.appendTo($products);
        });
        $products.appendTo($cart);

        var $cartTotals = $('<ul class="cartTotals"></ul>');
        $cartTotals.append('<li><div class="lefty">Subtotal</div><div class="righty">$'+subtotal.toFixed(2)+'</div></li>');
        $cartTotals.append('<li><div class="lefty">Store Credit Used</div><div class="righty">($'+(this.data.cart_store_credit.amount ? this.data.cart_store_credit.amount : '0.00')+')</div></li>');
        $cartTotals.append('<li><div class="lefty">Tax</div><div class="righty">$'+this.data.cart.totals.product_tax.toFixed(2)+'</div></li>');
        $cartTotals.append('<li><div class="lefty">Shipping </div><div class="righty">$'+Number(this.data.cart.totals.shipping).toFixed(2)+'</div></li>');
        $cartTotals.append('<li class="gTotes"><div class="lefty">Total </div><div class="righty">$'+this.data.cart.totals.grand_total.toFixed(2)+'</div></li>');
        $cartTotals.appendTo($cart);

        $('<div class="alisMessageInABottle">Your account will be charged</br> this amount when you Place Order</div>').appendTo($cart);
    }

    $(function() {
        dahliawolfCheckout = new dahliaCheckout(<?= json_encode($_data['cart']) ?>);
        console.log(<?= json_encode($_SESSION) ?>);
    });
</script>