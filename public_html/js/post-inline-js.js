theuserPoints = parseInt('0');

function openfeedback(){
	if($('#postitdiv').is(':visible')){
		hidepostitdiv();
	}
	if($('#feedback-tab').is(':visible')){
		hidefeedback();
	}
	if(!$('#showFeedBack').is(':visible')){
    	$('#tooltip-overlay').fadeIn(200);
		$("#showFeedBack").slideDown(200);
		$('#tooltip-overlay').bind('click', function(){
			hidefeedback();
		});
	}
	else{
		hidefeedback();
	}
}
function hidefeedback(){
	$('#tooltip-overlay').fadeOut(200);
    $("#showFeedBack").slideUp(200);
	$('#feedback-tab').show();
	$('#tooltip-overlay').unbind();
} 
function doLoad(text){
	$('#img-upload-loader').slideDown(200);
	$('#loading-text').empty();
	$('#loading-text').append(text);
}
function stopLoad(){
	$('#img-upload-loader').fadeOut(200);
}

function showpostitdiv(){
  var show = "show";
  
  if(show == "show"){ 
	  if($('#showFeedBack').is(':visible')){
		hidefeedback();
	  }
	  if($("#postitdiv").is(':visible')){
			hidepostitdiv()
		}
		else{
			$("#tabber").animate({ width: window.innerWidth }, 400, function(){
				$('#tabber').animate({ height: $('#postitdiv').height() }, 100, function(){
					$('#tooltip-overlay').fadeIn(200);
					$("#postitdiv").fadeIn(200);
					$("#insideposit").show();
					$('#tooltip-overlay').bind('click', function(){
						$('#filter-cover').show();
						hidepostitdiv();
						$('#tooltip-overlay').unbind();
					});
				});
			});
		}
  }
  else{
	  window.location = "http://www.dahliawolf.com";
  }
}

function hidepostitdiv(){
  $('.left-arrow').hide();
  $('.right-arrow').hide();
  $('#postitdiv').fadeOut(100, function(){	  
  		$("#tabber").animate({ width: 140 }, 200, function(){
			$('#tabber').animate({ height: 165 }, 100, function(){
				$('#tooltip-overlay').hide();
				$('#scroll-src').empty().width(0);
				$('#filter-cover').show();
			});
		});
  });
}

function closetooltip(){
	$('#tooltip-overlay').hide(100);
    $("#tooltip").hide(100);
}
function openviewall(){
    $("#includeall").load("readfeedviewall.php");

    $("#viewalldiv").show(600);
    filter("all");
}
function closeviewall(){
    $("#viewalldiv").hide(600);
    filter("all");
}
function postit(theimage,id){
    $("#tooltip").hide(500);
	$('#tooltip-overlay').unbind().off();
	$('#tooltip-overlay').bind('click', function(){
		$('#upoload-img-box').hide();
		$('#tooltip-overlay').bind('click', hidepostitdiv);
	});  
    $("#upload-box").load("upload_popup.php?theurl="+theimage+"&id="+id);
    $("#upload-box").show(200);
}

function completepostit(){
    
    
    $("#postitdiv").load("");
    $("#postitdiv").hide(200);
}

function filter(what){
    if(what=="instagram"){
        $('#inst-butt').attr('src', "/skin/img/btn/instagram-on1.png");
		$('#pint-butt').attr('src', "/skin/img/btn/pinterest-off.png");
		$(".instagram").show();
        $(".pinterest").hide();
		$(".right-arrow").show();
    }else if(what=="pinterest"){
		$('#inst-butt').attr('src', "/skin/img/btn/instagram-off.png");
		$('#pint-butt').attr('src', "/skin/img/btn/pinterest-on1.png");
        $(".pinterest").show();
        $(".instagram").hide();
		$(".right-arrow").show();
    }else{
        $(".pinterest").show();
        $(".instagram").show();
    }
}

function userPoints(pnts){
	theuserPoints = theuserPoints + pnts;
	$('#points-user').empty();
	$('#points-user').html('YOU EARNED '+pnts+' POINTS');
	$('#point-dmnd').attr('src', '/skin/img/dmnd_on.gif');
	$('#points-user').fadeIn(200);
	var pntTimer = setTimeout(function(){
			$('#points-user').fadeOut(600);
			$('#point-dmnd').attr('src', '/skin/img/dmnd.png');
			$('#points-user').empty();
			pntTimer = null;
	},6000);
}

function show_user_points(){
		$('#points-user-obt').html('YOU HAVE '+theuserPoints+' POINTS');
		$('#points-user-obt').show();
	}
function hide_user_points(){
	$('#points-user-obt').empty();
	$('#points-user-obt').hide();
}

function loginscreen(what){
        $('#mask').fadeIn(500);        
        $('#mask').fadeTo("slow",0.8);
        var winH = $(window).height();
        var winW = $(window).width();
	$("#UnauthCallout").css('top',  winH/2-$("#UnauthCallout").height()/2);
        $("#UnauthCallout").css('left', winW/2-$("#UnauthCallout").width()/2);
		if(what=="login"){
			$("#signinbox").css("display","none")
			$("#loginbox").css("display","block")
		}else if(what=="signup"){
			$("#loginbox").css("display","none")
			$("#signinbox").css("display","block")
		}else{
			$("#loginbox").css("display","none")
			$("#signinbox").css("display","block")
		}
        $("#UnauthCallout").fadeIn(1000); 
	}

         $(document).ready(function(){
		$('#mask').click(function (e) {
			e.preventDefault();
			$('#mask').hide();
			$('#UnauthCallout').hide();
		}); 
		$('#closebtn').click(function (e) {
			e.preventDefault();
			$('#mask').hide();
			$('#UnauthCallout').hide();
		});
		
		 
	
	
    });
	function openlogin(){
		$("#loginbox").css("display","block");
		$("#signinbox").css("display","none");
		}