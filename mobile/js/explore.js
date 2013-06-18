// safari = 8
//android = 50
offzet = -50;
if($(window).height() < 360){offzet = 8;}
$('.product-box').height(window.innerHeight + offzet);
overlay = $('#blackOut');

var explore = new Object();
explore.product = new Array();
explore.screenWidth = $(window).innerWidth();
explore.blackedOut = false;
explore.glorifyfadeSpeed = 200;


explore.Glorify = function(src){
	if(!explore.blackedOut){
		str = '<img src="'+src+'" id="theGlory" class="theAppended">';
		overlay.append(str);
		overlay.fadeIn(explore.glorifyfadeSpeed, function(){
			explore.blackedOut = true;
		});
	}else{
		explore.unGlorify();
	}
}

explore.unGlorify = function(){
	overlay.fadeOut(explore.glorifyfadeSpeed, function(){
		overlay.empty();
		explore.blackedOut = false;
	})
}

explore.setActive = function(id){
	this.activeProduct = id;
}

explore.navVert = function(dir){
	if(dir == 'up'){
		next = $('#product-box-' + explore.activeProduct).prev();	
	}else if(dir == 'down'){
		next = $('#product-box-' + explore.activeProduct).next();
	}else if(dir == 'center'){
		next = $('#product-box-' + explore.activeProduct);
	}
	$('html, body').animate({scrollTop: next.offset().top }, 200);
}

explore.init = function(x){
	$('html, body').scrollTop( $('#product-box-'+x).offset().top );
	$('.prod-img-frame').on('movestart', function(e){
		explore.setActive(parseInt( $(this).data('id') ) );
	}).bind('moveend', function(e) {
		if(!explore.product[explore.activeProduct].isActive){
			if ((e.distX > e.distY && e.distX < -e.distY) || (e.distX < e.distY && e.distX > -e.distY)) {
				explore.navVert( (e.distY > 0 ? 'up' : 'down') );
			}else if(!explore.product[explore.activeProduct].isActive){
				if(e.distX > 0 && explore.product[explore.activeProduct].showingProduct){
					explore.product[explore.activeProduct].toggleImage();
				}else if(e.distX < 0 && !explore.product[explore.activeProduct].showingProduct){
					explore.product[explore.activeProduct].toggleImage();
				}
			}
		}
	});
	$('.product-box').each(function(index, element) {
        id = parseInt( $(this).data('id') );
		explore.product[id] = new explore.products(id);
    });
	$('#blackOut').bind('click', explore.unGlorify);
	$('.prod-inner-frame img').on('mousedown', function(){
		explore.Glorify(this.src);
	});
}

explore.products = function(id){// product pho javascript class declaration
	this.id = id;
	this.speed = 200;
	this.showingProduct = true;
	this.outlet = $('#product-box-'+id);
	this.productImage = $('#product-image-'+id);
	this.inspirationImage = $('#inspiration-image-'+id);
	this.isActive = false
}

explore.products.prototype.showInspiration = function(){
	this.toggleShowing();
}

explore.products.prototype.showProduct = function(){
	this.toggleShowing();
}

explore.products.prototype.toggleShowing = function(){
	if(this.showingProduct){
		this.showingProduct = false;
	}else{
		this.showingProduct = true;
	}
}

explore.products.prototype.chillOut = function(el){
	el.addClass('chillen');
}

explore.products.prototype.toggleImage = function(){
	explore.navVert('center');
	if(this.showingProduct){// transition to inspiration
		this.inspirationImage.css('left', '-'+explore.screenWidth+'px').removeClass('chillen').animate({left: 0}, this.speed);
		this.productImage.animate({left: explore.screenWidth}, this.speed );
	}else{//transition back to product
		this.productImage.removeClass('chillen').animate({left: 0}, this.speed);
		this.inspirationImage.animate({left: '-'+explore.screenWidth}, this.speed );
	}
	this.toggleShowing()
}
