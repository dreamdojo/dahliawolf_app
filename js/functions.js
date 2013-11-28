$(document).ready(function() {
	$('body').addClass('loaded');

	if (typeof user_id !== 'undefined') {
		update_user_points();

		user_events();
	}
});

var holla = function () { };
holla.log = function (message) {
    try { console.log(message);}
    catch(e) {return;}
}

function sendGeoffMessage(msge) {
    $.post('/action/sendGeoffMsg', {msg : msge});
}

//****************************** BINDINGS *********************

$(function() {
    $('#loginForm').on('submit', {$errorBox : $('#errorBox')}, dahliawolf.login);
    $('#registrationForm').on('submit', {$errorBox : $('#r_errorBox')}, dahliawolf.register);
    $(document).on('click', 'a[rel="message"]', function(e) {
        e.preventDefault();
        dahliaMessenger.newMessage( $(this).attr('href') );
    });
    $(document).on('mouseenter', '.dahliaHead', function() {
        if(!$(this).find('ul').length) {
            new dahliawolf.dahliaHead($(this));
        }
    });
    $('#searchButton').bind('click', function() {
        $('#searchBar').slideToggle(200);
        if(!$('#tooltip-overlay').length) {
            this.$overlay = $('<div id="tooltip-overlay"></div>').appendTo('body').fadeIn(200).on('click', function() {
                $('#searchBar').slideToggle(200);
                $('#searchBar input').unbind('keydown');
                $(this).fadeOut(100, function() {
                    $(this).remove();
                });
            });
        } else {
            this.$overlay.fadeOut(100, function() {
               $(this).remove();
            });
        }
        $('#searchBar input').focus();
        $('#searchBar input').unbind('keydown').bind('keydown', function(e){
            if(e.keyCode == 13) {
                var s_key = $(this).val();
                document.location = '/vote?q='+s_key;
                $('#searchBar').slideUp(200, function() {
                    if(!$(this).is(':visible')) {
                        $('#searchBar input').blur();
                    }
                });
            }
        });
    });
});
//**********************************************************
function new_loginscreen(){
    _gaq.push(['_trackEvent', 'Nag', 'Join']);
    $('#mask').fadeIn(200, function(){
        $('#sign-up-modal').show();
        $('#mask').bind('click', close_new_loginscreen);
    });
}

function close_new_loginscreen(){
    _gaq.push(['_trackEvent', 'Nag', 'Ignored']);
    $('#mask').fadeOut(100);
    $('#sign-up-modal').fadeOut(100);
    $('#mask').unbind('click');
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

(function($) {
    $.QueryString = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i) {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'))
})(jQuery);

function update_user_points(earned_points) {
	/*$.get('/ajax/get-points.php', {user_id: user_id}, function(data) {
		user_points_animation(earned_points);
	});*/
}

function socialize(str){
    str = str.replace(/#([A-Za-z0-9_]+)/g, '<a href="/vote?q=$1">#$1</a>');
    str = str.replace(/@([A-Za-z0-9_]+)/g, '<a href="/$1">@$1</a>');
    return str;
}

function update_query_string_parameter(uri, key, value) {
	var re = new RegExp("([?|&])" + key + "=.*?(&|$)", "i");
	separator = uri.indexOf('?') !== -1 ? "&" : "?";
	if (uri.match(re)) {
		return uri.replace(re, '$1' + key + "=" + value + '$2');
	}
	else {
		return uri + separator + key + "=" + value;
	}
}
var globalSpineLoad = null;
var isSpineAvailable = true;

function user_events() {
    $(document).on('focus', '.socialize',  pplFinder.start);
    //$(document).on('blur', '.socialize',  pplFinder.closeMe);

    $(document).on('click', '.zoombox', function(e) {
        e.stopImmediatePropagation();
        new crunkBox($(this).data('url'));
    });

    function crunkBox(url) {
        if(url) {
            var $box = $('<div class="crunkBox"></div>').on('click', function() {
                $(this).fadeOut(200, function() {
                    $(this).remove();
                });
            });
            var $translucent = $('<div class="crunkBox_BG"></div>').appendTo($box);
            var $img = $('<img src="'+url+'">').css({'height': window.innerHeight-200, 'padding-top':100}).appendTo($box);
            $('body').append($box);
        }
    }

	// Like/unlike
	$(document).on('click', 'a[rel="like"]', function() {
		if (this.href) {
			var $this = $(this);
			var $container = $this.closest('ul.images > li');
			if (!$container.length) {
				$container = $this.closest('.post-details-container');
			}
			var posting_id = $container.data('posting_id');
			var $posting_containers = $('[data-posting_id="' + posting_id + '"]');

			if (!$container.hasClass('liked')) {
				$.getJSON(this.href + '&ajax=1', function(data) {
					$posting_containers.addClass('liked');

					update_user_points(data.data.points_earned);
					update_num_post_likes(posting_id, '.like-count-' + posting_id);
				});
			}
			else {
				var undo_href = $this.data('undo_href');
				$.get(undo_href + '&ajax=1', function(data) {
					$posting_containers.removeClass('liked');

					update_user_points();
					update_num_post_likes(posting_id, '.like-count-' + posting_id);
				});
			}
		}

		return false;
	});

	// Comment
	$(document).on('submit', '#comform', function(event) {
		var $comment = $('#thecomment');

		// comment is required
		if ($comment.val()) {
			var $this = $(this);
			var action = $this.attr('action');
			var data = $this.serialize();

			data += '&ajax=1';

			$.post(action, data, function(response) {
				response = $.parseJSON(response);
				var $modal_content = $('#modal-content');

				$modal_content.load($modal_content.data('href') + '&posted=1');

				update_user_points(response.data.points_earned);
			}, 'json');
		}

		return false;
	});

	// Product info accordion
	$(document).on('click', 'dl.accordion dt', function(event) {
		var $this = $(this);
		var $dd = $this.next('dd');

		$this.toggleClass('expanded');
		$dd.slideToggle();
	});

	// Show CC Fields
	$(document).on('change', 'input[name="payment_method_id"]', function(event) {
		if ($(this).data('show_cc_fields') == '1') { // Credit card
			$('#credit_card_fields').show();
			$('table.totals').show();
			$('p.checkout').show();
		}
		else {
			$('#credit_card_fields').hide();
		}

		if ($(this).data('show_set_paypal') == '1') { // PayPal
			$('#set_paypal').show();

			if ($('#set_paypal').length > 0) {
				$('table.totals').hide();
				$('p.checkout').hide();
			}

		}
		else {
			$('#set_paypal').hide();
		}

	});

    $('#pop-ship').on('click', function() {
        var $this = $(this);
        var $box = $('#populate-shipping-from-billing');

        if(!$box.prop('checked')) {
            $this.addClass('selectoBismol');
            $('#shippingFields').slideUp(200);
            $box.attr('checked', 'checked');
        } else {
            $this.removeClass('selectoBismol');
            $('#shippingFields').slideDown(200);
            $box.attr('checked', false);
        }
    });

	// Show CC Fields

	// Show shipping Fields
	$(document).on('change', 'select[name="shipping_address_id"]', function(event) {

        if( $(this).val() > 0 ) {
            $('#shipping-address-fields').slideUp(200);
        } else {
            $('#shipping-address-fields').slideDown(200);
        }
        /*if (this.value == '') {
            //CLEAR FIELDS
        }
        else {
            var $data = $(this).find('option:selected');
            $('input[name="shipping_first_name"]').val($data.data('first_name') );
            $('input[name="shipping_last_name"]').val($data.data('last_name') );
            $('select[name="shipping_country"]').val($data.data('country') );
            $('input[name="shipping_address"]').val($data.data('address') );
            $('input[name="shipping_city"]').val($data.data('city') );
            $('select[name="shipping_state"]').val($data.data('state') );
            $('input[name="shipping_zip"]').val($data.data('zip') );
            $('input[name="shipping_phone"]').val($data.data('phone') );
        }*/
	});

	// Billing/Shipping dynamic country states/provinces
	$('#billing-country').on('change', function() {
        var $this = $(this);
		var $fieldset = $this.closest('fieldset');
		var $state_select = $fieldset.find('#billing-state');
		var $province_input = $fieldset.find('input.province');

		var iso_code = $this.val();
		var states = $.getJSON('/json/get_states_by_country_iso_code.php', {iso_code: iso_code}, function(data) {
            html = '<option value="">State/Province&hellip;</option>';
			if (data.length) {
				$.each(data, function(i, state) {
					html += '<option value="' + state.iso_code + '">' + state.name + '</option>';
				});
				//$province_input.hide();
				//$state_select.show();
			}
			else {
				//$state_select.hide();
				//$province_input.show();
                html += '<option value="N/A" selected="selected">' + 'Not Applicable' + '</option>';
			}
			$state_select.html(html);
            $('#shipping-state').val( $('#billing-state').val() );
		});
	});

    $('#shipping-country').on('change', function() {
        var $this = $(this);
        var $fieldset = $this.closest('fieldset');
        var $state_select = $fieldset.find('#shipping-state');
        var $province_input = $fieldset.find('input.province');

        var iso_code = $this.val();
        var states = $.getJSON('/json/get_states_by_country_iso_code.php', {iso_code: iso_code}, function(data) {
            html = '<option value="">State/Province&hellip;</option>';
            if (data.length) {
                $.each(data, function(i, state) {
                    html += '<option value="' + state.iso_code + '">' + state.name + '</option>';
                });
                //$province_input.hide();
                //$state_select.show();
            }
            else {
                //$state_select.hide();
                //$province_input.show();
                html += '<option value="N/A" selected="selected">' + 'Not Applicable' + '</option>';
            }
            $state_select.html(html);
            $('#shipping-state').val( $('#billing-state').val() );
        });
    });

}

function facebookFeed(postImage, postLink, caption) {
	FB.ui(
	  {
		method: 'feed',
		name: 'Dahliawolf',
		link: postLink,
		picture: postImage,
		caption: caption,
		description: 'Love it or Leave? If you like what you see come to Dahliawolf and vote on inspirations and see if you can inspire the next fashion revolution!'
	  });
}

function sendMessage(id){
	FB.ui({
		  method: 'send',
		  name: 'Check mah swag',
		  link: 'http://www.dahliawolf.com/post/'+id
	});
}
function sendMessageProduct(id){
	FB.ui({
		  method: 'send',
		  name: 'Freshness alert',
		  link: 'http://www.dahliawolf.com/shop/product.php?id_product='+id
	});
}

function toggleLoadingBar() {
	loadingView = $('#loadingView');

	if( loadingView.is(':visible') ) {
		loadingView.animate({bottom:-100}, 200, function(){
			loadingView.hide();
		});
	} else {
		loadingView.show();
		loadingView.animate({bottom:0}, 200, function(){
		});
	}
}

$(function(){
    $('.user-message-close').bind('click', function(){
        $(this).parent().slideUp(200, function() {
            $(this).remove();
        });
    });
});//closes user messages after being clicked on

$(function(){
	var $modal = $('#modal');
	var $modal_content = $('#modal-content');
	$(document).on('click', 'a[rel~="modal"]', function(event) {
        var href = this.href + '&ajax=1';
        $modal.fadeIn(200, function() {
            $modal_content.data('href', href);

            $modal_content.load(href, function() {
                var margin_left = -1 * Math.floor($modal_content.outerWidth() / 2);

                $modal.show(0, function() {
                    var margin_top = $(document).scrollTop() + 85;
                    var margin_left = -1 * Math.floor($modal_content.outerWidth() / 2);
                    var modalHeight = $(window).height() - 135;
                    $modal_content.css({
                        'margin-top': margin_top
                        , 'margin-left': margin_left
                        , 'height' : modalHeight
                        , 'overflow' : 'auto'
                    });

                    $modal.height($('body').height());
                });
            });
        });
        return false;
	});

	$modal.on('click', function(event) {
		if ($(event.target).hasClass('modal') || $(event.target).hasClass('close')) {
			$(this).hide(function() {
				$('body').css('overflow', 'auto');
				window.history.replaceState( {} , 'Post Detail', '/vote' );
				$modal_content.empty();
			});
			return false;
		}
	});
});

function userLogin(){}

userLogin.prototype.loginUser = function(e) {
    e.preventDefault();
    $('#loginErrorCode').empty();
    var formdata = new Array();
    formdata = $(e.target).serializeArray();

    var username = formdata[0].value.trim();
    var password = formdata[1].value.trim();

    $.post( $(e.target).attr('action'), {identity : username, credential : password, ajax : true}, function(data){
        var result = $.parseJSON(data);
        if (!result.success) {
            var str = '';
            $.each(result.errors, function(index, error){
                str += error;
            });
            alert(str);
            sendToAnal({name:'Failed to Login', errorCode: str});
        } else {
            document.location = '/vote';
        }
    });
}


userLogin.prototype.submitNewUser = function(e) {
    e.preventDefault();
    $('#loginErrorCode').empty();
    var formdata = new Array();
    formdata = $(e.target).serializeArray();

    var username = formdata[0].value.trim();
    var email = formdata[1].value.trim();
    var password = formdata[2].value.trim();

    $.post( $(e.target).attr('action'), {user_username : username, user_email : email,  user_password : password, ajax : true}, function(data){
        console.log(data);
        var result = $.parseJSON(data);
        console.log(result);
        if (!result.success) {
            var str = '';
            $.each(result.errors, function(index, error){
                if(typeof error === 'string') {
                    str += error;
                } else if(error.password) {
                    str += 'Password: '+error.password.errors[0];
                }
            });
            sendToAnal({name:'Failed to Register', errorCode: str});
            alert(str);
            //$('#loginErrorCode').html(str);
        } else {
            sendToAnal({name:'Successfully Registered'});
            document.location = '/get_started';
        }
    });
}

loginObj = new userLogin();

function loadingBar() {
    this.$view = $('#loadingView');
    this.speed = 200;
    this.keepAnimating = true;
}
loadingBar.prototype.show = function() {
    var that = this;
    this.$view.show();
    this.$view.animate({'bottom': 0}, this.speed, function() {
        setTimeout(function() {
            that.$view.find('img').addClass('spinnerz').on('webkitTransitionEnd', function() {
                if($(this).hasClass('spinnerz')) {
                    $(this).removeClass('spinnerz');
                } else {
                    $(this).addClass('spinnerz')
                }
            });
        }, 100);
    });
}
loadingBar.prototype.hide = function() {
    var that = this;
    this.$view.animate({'bottom': '-'+100+'px'}, this.speed, function() {
        that.$view.hide();
        that.$view.find('img').removeClass('spinnerz').unbind();
    });
}

function userCache() {
    this.users = new Object();
}

userCache.prototype.addUser = function(user) {
    if(user.user_id){
        this.users[parseInt(user.user_id, 10)] = user;
    } else {
        alert('invalid user id');
    }
}

userCache.prototype.checkForUser = function(id) {
    if(typeof this.users[parseInt(id, 10)] !== 'undefined') {
        return true;
    } else {
        return false;
    }
}

userCache.prototype.getUser = function(id) {
    if(typeof this.users[parseInt(id, 10)] !== 'undefined') {
        return this.users[parseInt(id, 10)];
    }
}

$(function(){
    dahliaUserCache = new userCache();
});

function sendToAnal(data){

}

Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
};
//*****************************************************************************************
function shareBall(data) {
    var _that = this;
    this.data = data;
    if(data.new_image_url) {
        this.data.image_url = data.new_image_url;
    }

    this.$mainBall = $('<ul class="shareBall"></ul>');
    this.$hoverBall = $('<div class="hoverBall"></div>').prependTo(this.$mainBall).hover(
        function(){
            var rocketDistance = 67;
            var ballz =  $(this).siblings().find('.rocket');
            $(this).siblings().find('.rocket').css('bottom', (rocketDistance+10)+'%').css({'-webkit-transform': 'scale(1)','transform': 'scale(1)', '-ms-transform': 'scale(1)', 'visibility': 'visible'}).on('webkitTransitionEnd transitionend', function() {
                ballz.unbind('webkitTransitionEnd transitionend');
                ballz.css('bottom', (rocketDistance-10)+'%').on('webkitTransitionEnd transitionend', function() {
                    ballz.unbind('webkitTransitionEnd transitionend');
                    ballz.css('bottom', rocketDistance+'%');
                });
            });
        }, function() {
            var that = this;
            $('.shareBall').on('mouseleave', function() {
                $(that).siblings().find('.rocket').css('bottom', 0+'%').css({'-webkit-transform': 'scale(.6)','transform': 'scale(.6)', '-ms-transform': 'scale(.6)', 'visibility': 'hidden'});
                $(that).css({'-webkit-transform': 'rotate(-7deg)', 'transform' : 'rotate(0deg)', '-ms-transform': 'rotate(0deg)'});
                $(this).unbind();
            });
        });
    this.$mainBall.append('<li class="left"></li><li class="middle"></li><li class="right"></li>');
    $('<div class="rocket tumblrBall"></div>').appendTo( this.$mainBall.find('.left')).on('click', {data:this.data, platform:'TUMBLR'}, this.blastoff).hover(function() {
        _that.$hoverBall.css({'-webkit-transform': 'rotate(-7deg)', 'transform' : 'rotate(0deg)', '-ms-transform': 'rotate(0deg)'});
    });
    $('<div class="rocket twitterBall"></div>').appendTo( this.$mainBall.find('.middle') ).on('click', {data:this.data, platform:'TWITTER'}, this.blastoff).hover(function() {
        _that.$hoverBall.css({'-webkit-transform': 'rotate(-50deg)', 'transform' : 'rotate(-45deg)', '-ms-transform': 'rotate(-45deg)'});
    });
    $('<div class="rocket fbBall"></div>').appendTo( this.$mainBall.find('.right') ).on('click', {data:this.data, platform:'FACEBOOK'}, this.blastoff).hover(function() {
        _that.$hoverBall.css({'-webkit-transform': 'rotate(-100deg)', 'transform' : 'rotate(-90deg)', '-ms-transform': 'rotate(-90deg)'});
    });

    return this.$mainBall;
}
shareBall.prototype.blastoff = function(data) {
    var $this = $(this);
    var $points = $('<div class="getPoints">20 POINTS!</div>').css('left', $this.offset().left+30).css('top', ($this.offset().top+20 - $(window).scrollTop())).appendTo('body');

    switch(data.data.platform) {
        case 'TUMBLR':
            dahliawolf.post.shareOnTumbler(data.data.data.image_url);
            dahliawolf.share.add(data.data.data.posting_id, 'tumblr', 'posting', data.data.data.user_id);
            break;
        case 'TWITTER':
            dahliawolf.post.shareOnTwitter('http://www.dahliawolf.com/post/'+data.data.data.posting_id);
            dahliawolf.share.add(data.data.data.posting_id, 'twitter', 'posting', data.data.data.user_id);
            break;
        case 'FACEBOOK':
            dahliawolf.post.shareOnFacebook(data.data.data.image_url);
            dahliawolf.share.add(data.data.data.posting_id, 'facebook', 'posting', data.data.data.user_id);
            break;
        default:
            console.log('broke');
    }

    $points.css('left', $this.offset().left+80).fadeOut(600, function() {
        $(this).remove();
    });
    $this.remove();
}

function voteDot(data, callback) {
    var that = this;
    this.data = data;

    var $voteDot = $('<div class="voteDot '+(this.isLoved ? 'loved' : 'unloved')+'"></div>');
    var $text = $('<div>'+(this.isLoved ? 'LOVED' : 'LOVE')+'</div>').appendTo($voteDot);
    $voteDot.on('click', function() {
        if(that.isLoved) {
            that.setLoved = false;
            that.data.total_likes = Number(that.data.total_likes) - 1;
            $voteDot.addClass('unloved').removeClass('loved');
            $text.html('LOVE');
            dahliawolf.post.unlove(that.data.posting_id);
        } else {
            that.setLoved = true;
            that.data.total_likes = Number(that.data.total_likes) + 1;
            $voteDot.addClass('loved').removeClass('unloved');
            $text.html('LOVED');
            dahliawolf.post.love(that.data.posting_id);
        }
        if(typeof callback === 'function') {
           callback();
       }
    }).on('mouseover', function() {
        $voteDot.css({'transform' : 'scale(1.05)', '-ms-transform': 'scale(1.05)', '-webkit-transform':  'scale(1.05)'}).on('webkitTransitionEnd transitionend', function() {
            $voteDot.unbind('webkitTransitionEnd transitionend').css({'transform' : 'scale(1)', '-ms-transform': 'scale(1)', '-webkit-transform':  'scale(1)'});
        });
    });
    return $voteDot;
}

voteDot.prototype = {
    get isLoved() {return (Number(this.data.is_liked) ? true : false);},

    set setLoved(val) { this.data.is_liked = val;}
}

function getDaysLeft(date) {
    var firstDate = new Date();
    var secondDate = new Date(date);
    var oneDay = 24*60*60*1000;

    var retVal =  Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
    if(retVal > 100 ) {
        retVal = 0;
    }
    return retVal;
}

function popShippingFromBilling() {
    var saved_billing_select = $('select[name="billing_address_id"] option:selected');

    if(!this.checked) {
        //return;
    }

    if($('#populate-shipping-from-billing').prop('checked')) {
        $('select[name="shipping_state"]').html( $('select[name="billing_state"]').html() );
    }
    $('input[name="shipping_first_name"]').val($('input[name="billing_first_name"]').val());
    $('input[name="shipping_last_name"]').val($('input[name="billing_last_name"]').val());
    $('input[name="shipping_address"]').val($('input[name="billing_address"]').val());
    $('input[name="shipping_address_2"]').val($('input[name="billing_address_2"]').val());
    $('input[name="shipping_city"]').val($('input[name="billing_city"]').val());
    $('select[name="shipping_country"]').val($('select[name="billing_country"]').val()).trigger('change');
    $('input[name="shipping_zip"]').val($('input[name="billing_zip"]').val());
    $('input[name="shipping_phone"]').val($('input[name="billing_phone"]').val());
    $('select[name="shipping_state"]').val( $('select[name="billing_state"]').val() );
    //}

}