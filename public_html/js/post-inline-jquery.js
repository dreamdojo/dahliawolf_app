window.fbAsyncInit = function() {
    
    FB.init({
	  appId: '552515884776900',
	  status: false,
          cookie: true,
          oauth  : true,    
          channelUrl : 'http://www.dahliawolf.com/channel.php',
	  xfbml: true
	  });

    FB.Event.subscribe('auth.login', function(response) {
           
    });	
    FB.Event.subscribe('edge.create',
        function(response) {
            $.ajax({
                type: 'POST',
                url:'http://www.dahliawolf.com/facebookshare.php',
                data: ""

            });
      });      

};

  // Load the SDK's source Asynchronously
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, /*debug*/ false));

$(document).ready(function()
{
    $("#ScrollToTop").click(function()
    {
        $('html, body').animate({
			scrollTop: 0
		}, 500);

        return false;
    });
    function scrollToTopCheck() {
        if ($(window).scrollTop() > 500) $("#ScrollToTop").show();
        else $("#ScrollToTop").hide();
    }
    $(window).scroll(scrollToTopCheck);
    scrollToTopCheck();
    // Fancy Form
    $(".FancyForm input[type=text], .FancyForm input[type=password], .FancyForm textarea").each(function() {
        if ($(this).val()) $(this).addClass("NotEmpty");
    }).change(function() {
        if ($(this).val()) $(this).addClass("NotEmpty");
        else  $(this).removeClass("NotEmpty");
    });
})