$(document).ready(function() {
	$('body').addClass('loaded');
	events();

	if (typeof user_id !== 'undefined') {
		update_user_points();

		user_events();
	}
});

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
	$.get('/ajax/get-points.php', {user_id: user_id}, function(data) {
		user_points_animation(earned_points);
	});
}
function user_points_animation(earned_points) {
	if (earned_points) {
		$point_board = $('#point-board');
		$point_board.addClass('updating');
		setTimeout(function() {
			$point_board.removeClass('updating');
		}, 5000);
	}
}

function update_num_post_likes(posting_id, selector) {
	$.get('/ajax/get-num-post-likes.php', {posting_id: posting_id}, function(data) {
		if (!data) {
			data = '0';
		}
		$(selector).html(data);
	});
}
function update_num_post_votes(posting_id, vote_period_id, selector) {
	$.get('/ajax/get-num-post-votes.php', {posting_id: posting_id, vote_period_id: vote_period_id}, function(data) {
		if (!data) {
			data = '0';
		}
		$(selector).html(data);
	});
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
function events() {
	$(document).on('click', 'a[rel="scroll"]', function(event) {
		var offset = $(this).data('offset') || 0;
		var hash = '#' + this.href.substring(this.href.indexOf('#') + 1);
		$('html, body').animate({
			scrollTop: $(hash).offset().top - offset
		}, 500);
		return false;
	});

    $(document).on('click', 'a[rel="addWishlist"]', function(event) {
        event.preventDefault();
        api.addItemToWishlist({call : this.href, obj : this});
    });

	// Spine load
	var $spine = $('.spine');
	if ($spine.length) {
		var $window = $(window);
		var $document = $(document);

		//var url = $spine.data('url') + window.location.search + (window.location.search? '&' : '?') + 'ajax=1';
		var url = $spine.data('url');

		url += (window.location.search.length ? (url.indexOf('?') == -1 ? '?' : '&') : '') + window.location.search.substring(1);
		url += (url.indexOf('?') == -1 ? '?' : '&') + 'ajax=1';

		if ($('body').hasClass('mobile')) {
			url += '&bare=1';
		}

		$window.scroll(function() {
			if ($window.scrollTop() == $document.height() - $window.height() && isSpineAvailable) {
				isSpineAvailable = false;
				var offset = $('.spine .images > li').length;
				url = update_query_string_parameter(url, 'offset', offset);
				$('.spine').append('<div id="theGridLoader"><img src="/images/loading-feed.gif"></div>');
				globalSpineLoad = $.get(url, function(data) {
					globalSpineLoad = null;
					if (data) {
						isSpineAvailable = true;
						$('#theGridLoader').remove();
						$('.spine .images:last').after(data);
					} else {
                        $('#theGridLoader').remove();
                    }
				});
			}
		});
	}

	// Posting scroll events
	var $scroll_src = $('#scroll-src');
	if ($scroll_src.length) {
		// Dynamic loading
		$scroll_src.scroll(function() {
			if ($scroll_src.scrollLeft() == $scroll_src[0].scrollWidth - $scroll_src.width()) {
				refillImages(current_domain_keyword, current_user_id);
			}
		});

		// Hover scroll
		function hover_scroll_right() {
			$scroll_src.stop().animate({scrollLeft: '+=250'}, 1000, 'linear', hover_scroll_right);
		}
		function hover_scroll_left() {
			$scroll_src.stop().animate({scrollLeft: '-=250'}, 1000, 'linear', hover_scroll_left);
		}
		function hover_scroll_stop() {
			$scroll_src.stop();
		}

		$("#scroll-control .left-arrow").hover(function () {
			hover_scroll_left();
		},function () {
			hover_scroll_stop();
		});

		$("#scroll-control .right-arrow").hover(function () {
			hover_scroll_right();
		},function () {
			hover_scroll_stop();
		});
	}

	// Shop image hover
	$('.product .thumbnails a').on('mouseover', function(event) {
		$(this).trigger('click');
	});
}

function user_events() {
    //delete post
    $('a[rel="delete"]').on('click', function(e) {
        e.preventDefault();
        id = parseInt($(this).data('id'));
        api.deletePost(id, function(){
            $('#post-'+id).css('opacity', .4);
        });
    });

	// Follow
	$('a[rel="follow"]').on('click', function() {
		var $this = $(this);

		$.get(this.href, function(data) {
			// Toggle button state
			var $button = $this.closest('.sysBoardFollowAllButton');
			$button.hide();
			$button.next('.sysBoardUnFollowAllButton').show();

			//update_user_points();
		});

		return false;
	});

	// Unfollow
	$('a[rel="unfollow"]').on('click', function() {
		var $this = $(this);

		$.get(this.href, function(data) {
			// Toggle button state
			var $button = $this.closest('.sysBoardUnFollowAllButton');
			$button.hide();
			$button.prev('.sysBoardFollowAllButton').show();

			//update_user_points();
		});

		return false;
	});

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

	// Vote/unvote
	$(document).on('click', 'a[rel="vote"]', function() {
		if (this.href) {
			var $this = $(this);
			var $container = $this.closest('.vote-prod, ul.posts > li');
			var posting_id = $container.data('posting_id');
			var vote_period_id = $container.data('vote_period_id');

			var index = $container.index();

			if (!$container.hasClass('voted')) {
				$.getJSON(this.href + '&ajax=1', function(data) {
					$container.addClass('voted');

					update_user_points(data.data.points_earned);
					update_num_post_votes(posting_id, vote_period_id, '#vote-count-' + posting_id);

					products[index].isliked = true;
					$('#wild4').attr('src', '/skin/img/wild_like.png');
				});
			}
			else {
				var undo_href = $this.data('undo_href');
				$.get(undo_href + '&ajax=1', function(data) {
					$container.removeClass('voted');

					update_user_points();
					update_num_post_votes(posting_id, vote_period_id, '#vote-count-' + posting_id);

					products[index].isliked = false;
					$('#wild4').attr('src', '/skin/img/like.png');
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

	// Show CC Fields
	$(document).on('click', 'input[name="populate-shipping-from-billing"]', function(event) {
		var saved_billing_select = $('select[name="billing_address_id"] option:selected');

		if(!this.checked) {
			return;
		}

		if (saved_billing_select.length > 0 && saved_billing_select.val() != '') {
			$('input[name="shipping_first_name"]').val(saved_billing_select.data('first_name'));
			$('input[name="shipping_last_name"]').val(saved_billing_select.data('last_name'));
			$('input[name="shipping_address"]').val(saved_billing_select.data('street'));
			$('input[name="shipping_address_2"]').val(saved_billing_select.data('address_2'));
			$('input[name="shipping_city"]').val(saved_billing_select.data('city'));
			$('select[name="shipping_state"]').val(saved_billing_select.data('state'));
			//$('input[name="shipping_province"]').val(saved_billing_select.data('state'));
			$('select[name="shipping_country"]').val(saved_billing_select.data('country')).trigger('change');
			$('input[name="shipping_zip"]').val(saved_billing_select.data('zip'));
		}
		else {
			$('input[name="shipping_first_name"]').val($('input[name="billing_first_name"]').val());
			$('input[name="shipping_last_name"]').val($('input[name="billing_last_name"]').val());
			$('input[name="shipping_address"]').val($('input[name="billing_address"]').val());
			$('input[name="shipping_address_2"]').val($('input[name="billing_address_2"]').val());
			$('input[name="shipping_city"]').val($('input[name="billing_city"]').val());
			$('select[name="shipping_state"]').val($('select[name="billing_state"]').val());
			//$('input[name="shipping_province"]').val($('input[name="billing_province"]').val());
			$('select[name="shipping_country"]').val($('select[name="billing_country"]').val()).trigger('change');
			$('input[name="shipping_zip"]').val($('input[name="billing_zip"]').val());

			/*if ($('select[name="billing_state"]').is(':visible')) {
				$('input[name="shipping_province"]').hide();
				$('select[name="shipping_state"]').show();
			}
			else {
				$('select[name="shipping_state"]').hide();
				$('input[name="shipping_province"]').show();
			}*/
		}

	});

	// Show Billing Fields
	$(document).on('change', 'select[name="billing_address_id"]', function(event) {
		if (this.value == '') {
			$('#billing-address-fields').show();
		}
		else {
			$('#billing-address-fields').hide();
		}

	});

	// Show shipping Fields
	$(document).on('change', 'select[name="shipping_address_id"]', function(event) {
		if (this.value == '') {
			$('#shipping-address-fields').show();
		}
		else {
			$('#shipping-address-fields').hide();
		}

	});

	// Billing/Shipping dynamic country states/provinces
	$('form.billing select.country').on('change', function() {
		var $this = $(this);
		var $fieldset = $this.closest('fieldset');
		var $state_select = $fieldset.find('select.state');
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
                html += '<option value="N/A" selected="selected">' + 'not applicable' + '</option>';
			}
			$state_select.html(html);
		});
	});

}

function ATF(id,nhide,nshow) {
	$('#'+nhide).addClass('hidden');
	$.post("http://www.dahliawolf.com/fav.php",{"id":id},function(html) {
		$('#'+nshow).removeClass('hidden');
	});
}
function RFF(id,nhide,nshow) {
	$('#'+nhide).addClass('hidden');
	$.post("http://www.dahliawolf.com/fav2.php",{"id":id},function(html) {
		$('#'+nshow).removeClass('hidden');
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
		if (!$('body').hasClass('mobile')) {
			if(globalSpineLoad){
				$('#theGridLoader').remove();
				globalSpineLoad.abort();
				globalSpineLoad = null;
				isSpineAvailable = true;
			}
			var href = this.href + '&ajax=1';
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

			return false;
		}
	});
	$modal.on('click', function(event) {
		if ($(event.target).hasClass('modal') || $(event.target).hasClass('close')) {
			$(this).hide(function() {
				$('body').css('overflow', 'auto');
				window.history.replaceState( {} , 'Post Detail', '/spine' );
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
        console.log(data);
        var result = $.parseJSON(data);
        if (!result.success) {
            var str = '';
            $.each(result.errors, function(index, error){
                str += error;
            });
            alert(str);
            sendToAnal({name:'Failed to Login', errorCode: str});
        } else {
            document.location = '/spine';
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

function dahliaHeads() {
    $this = this;

    this.view = $('#dahliaHead');
    this.avatar = $('#dahliaHeadAvatarSrc');
    this.followButton = $('#dahliaHeadFollowToggle');
    this.left = 0;
    this.top = 0;
    this.timer = null;

    this.followButton.bind('click', $.proxy(this.toggleFollow, this) );

    $(document).on('mouseenter', '.dahliaHead', function(){
        $this.clearDahliaTimer();
        $this.left = $(this).offset().left - ($this.view.width()/2);
        $this.top = $(this).offset().top - $this.view.height();
        var id = Number( $(this).data('id') );

        if( id != theUser.id){
            if( dahliaUserCache.checkForUser(id) ) {
                $this.showHead({ data : dahliaUserCache.getUser(id) });
            } else {
                api.getUserDetails( id, $.proxy($this.showHead, $this) );
            }
        }
    }).on('mouseleave', '.dahliaHead', $.proxy($this.setDahliaTimer, $this) );

    this.view.on('mouseenter', $.proxy($this.clearDahliaTimer, $this) ).on('mouseleave', $.proxy($this.setDahliaTimer, $this) );
}

dahliaHeads.prototype.setDahliaTimer = function() {
    var $this = this;
    this.timer = setTimeout(function(){
        if( $this.view.is(':visible')) {
            $this.view.fadeOut(200);
        }
    }, 300);
}

dahliaHeads.prototype.clearDahliaTimer = function() {
    if(this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
    }
}

dahliaHeads.prototype.toggleFollow = function() {
    var is_cached = false;

    if( dahliaUserCache.checkForUser(this.data.user_id) ) {
        is_cached = true;
    }

    if(this.data.is_followed) {
        this.data.is_followed = false;
        this.followButton.html('Follow').addClass('dahliaHeadFollow').removeClass('dahliaHeadUnFollow');
        api.unfollowUser(this.data.user_id);
        if(is_cached) {
            dahliaUserCache.users[this.data.user_id].is_followed = false;
            console.log(dahliaUserCache.users[this.data.user_id].is_followed)
        }
    } else {
        this.data.is_followed = true;
        this.followButton.html('Unfollow').removeClass('dahliaHeadFollow').addClass('dahliaHeadUnFollow');
        api.followUser(this.data.user_id);
        if(is_cached) {
            dahliaUserCache.users[this.data.user_id].is_followed = true;
            console.log(dahliaUserCache.users[this.data.user_id].is_followed);
        }
    }
}

dahliaHeads.prototype.showHead = function(data) {
    this.data = data.data;
    this.data.is_followed = Number(this.data.is_followed);
    dahliaUserCache.addUser(this.data);

    this.avatar.attr({'src' : data.data.avatar+'&width=75', 'onclick' : 'document.location="/'+data.data.username+'";'});
    this.followButton.html( Number(data.data.is_followed) ? 'Unfollow' : 'Follow');
    if( this.data.is_followed ){
       this.followButton.addClass('dahliaHeadUnFollow').removeClass('dahliaHeadFollow');
    }else {
        this.followButton.addClass('dahliaHeadFollow').removeClass('dahliaHeadUnFollow');
    }
    this.view.css({'left' : this.left, 'top' : this.top}).show();
}

$(function(){
    dahliaHead = new dahliaHeads();
    dahliaUserCache = new userCache();
});

function sendToAnal(data){
    if(data) {
        woopraTracker.pushEvent(data);
    }
}