var $j = jQuery.noConflict();
var maxNr = 500;
$j(document).ready(function() {
							
<!-- Add border 0 to the last li -->					
$j('.box ul').each(function(i, el) { $j(el).find('li:last').addClass("no-border"); });
$j('.wrap').each(function(i, el) { $j(el).find('.post_entry:last, .portfolio_gallery_holder:last').addClass("no-border"); });
$j('ul.menu').each(function(i, el) { $j(el).find('li:last').addClass("no-back"); });
$j('ul.menu').each(function(i, el) { $j(el).find('li:first').addClass("no-padding"); });

$j(".portfolio_box img, .portfolio_box_slide img, .related_posts_box img, .sidebar img, .post_entry.blog img").hover(function()
{ $j(this).animate({opacity: .7,left: '0px'}, "300"); }, function(){ $j(this).animate({opacity: 1,left: '0px'}, "300"); });


//Hide (Collapse) the toggle containers on load
$j(".toggle_container").hide(); 

//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
$j("h2.trigger").click(function(){
	$j(this).toggleClass("active").next().slideToggle("slow");
});


$j('a[href*=#]').click(function() {
 if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
 && location.hostname == this.hostname) {
   var $jtarget = $j(this.hash);
   $jtarget = $jtarget.length && $jtarget
   || $j('[name=' + this.hash.slice(1) +']');
   if ($jtarget.length) {
  var targetOffset = $jtarget.offset().top;
  $j('html,body')
  .animate({scrollTop: targetOffset}, 900);
    return false;
   }
  }
});



<!-- Add margin 0 to the fourth box -->
$j('.footer').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 4 == 0) { $j(el).find('div.box:eq('+j+')').addClass("no_margin"); }
	}
});

<!-- Add margin 0 to the third li -->
$j('.sidebar .widget_flickr, .footer .widget_flickr').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 4 == 0) { $j(el).find('li:eq('+j+')').addClass("no_margin"); }
	}
});

<!-- Add margin 0 to the fourth li -->
$j('.sidebar .social, .footer .social').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 5 == 0) { $j(el).find('li:eq('+j+')').addClass("no_margin"); }
	}
});

<!-- Add margin 0 to the third box -->
$j('.wrap').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 3 == 0) { $j(el).find('div.portfolio_box:eq('+j+')').addClass("no_margin"); }
	}
});

<!-- Add margin 0 to the fourth box -->
$j('.wrap').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 4 == 0) { $j(el).find('#nav li .team-holder:eq('+j+')').addClass("no_margin"); }
	}
});

<!-- Add margin 0 to the second box -->
$j('.wrap .second-row').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 2 == 0) { $j(el).find('div.box:eq('+j+')').addClass("no_margin"); }
	}
});

<!-- Add margin 0 to the second box -->
$j('.left-content').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 2 == 0) { $j(el).find('div.services-box:eq('+j+')').addClass("no_margin"); }
	}
});

<!-- Add margin 0 to the third box -->
$j('.main').each(function(i, el) {
	for(var j = 0; j <= maxNr; j++)
	{
		if((j + 1) % 3 == 0) { $j(el).find('.box:eq('+j+')').addClass("no_margin"); }
	}
});


<!-- Div clear after first row of boxes -->
for(var j = 0; j <= maxNr; j++)
{
	if((j + 1) % 3 == 0) { $j("div.main .box").eq(j).after($j('<div class="clear"></div>')); }
	
	if((j + 1) % 3 == 0) { $j("div.home_widgets .box").eq(j).after($j('<div class="clear"></div>')); }
	
	if((j + 1) % 4 == 0) { $j("div.wrap .footer .box").eq(j).after($j('<div class="clear"></div>')); }
	
	if((j + 1) % 2 == 0) { $j("div.second-row .box").eq(j).after($j('<div class="clear"></div>')); }
	
	if((j + 1) % 2 == 0) { $j(".left-content .services-box").eq(j).after($j('<div class="clear"></div>')); }
}

<!--prettyPhoto -->
$j("a[rel^='prettyPhoto']").prettyPhoto({theme:'facebook'});

<!--Menu -->
$j(document).ready(function() {	$j("ul.menu").superfish(); }); 
			
});

// Cufon font
Cufon.replace('h1, h2, h3, h4, h5, h6', {hover: true});

