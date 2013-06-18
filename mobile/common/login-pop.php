<?
$login_urls = array(
	'facebook' => '/social-login.php?social_network=facebook'
	, 'instagram' => '/social-login.php?social_network=instagram'
	, 'twitter' => '/social-login.php?social_network=twitter'
);
?>
<script type="text/javascript">
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
    </script>
    
    <div id="mask"></div>
    <div id="UnauthCallout" style="display:none; height:550px;width:650px;">
        <div class="Nag">
            <div class="Sheet1 Sheet">
                <div class="login-frame">
                    <div style="float:right;"><a href="#" id="closebtn"><img src="/skin/img/closewhite.png" height="32" width="32" /></a></div>
                    <div style="clear:both"></div>
                   <div id="signinbox" style="display:none;">
                       <div style="width:315px; margin:0 auto; margin-top: 25px;">
                            <div style="margin-bottom:9px; margin-top: 2px; ">
                        	<img src="/skin/img/signup_title.png" width="288" height="48" />
                            </div>
                            <div style="margin-bottom:20px; margin-top: 35px;"><a href="<?= $login_urls['facebook'] ?>"><img src="/skin/img/signinfacebook.png" width="304" height="66" /></a>
                            </div>
                            <div style="margin-bottom:20px;"><a href="<?= $login_urls['instagram'] ?>"><img src="/skin/img/signininstagram.png" width="304" height="66" /></a></div>
                            <div style="clear:both;"></div>
                            <div style="margin-bottom:20px;"><a href="<?= $login_urls['twitter'] ?>"><img src="/skin/img/signintwitter.png" width="304" height="66" /></a></div>
                            <div style="clear:both;"></div>
                            <div><a href="/mobile/signup.php"><img src="/skin/img/signinemail.png" width="304" height="66" /></a></div>
                            <div style="clear:both;"></div>
                            <div style="margin-top: 20px">
                            	<div style="float:left; padding-top:3px; padding-left:75px;">
                            	<img src="/skin/img/alreadycreative.png" width="106" height="12" />
                                </div>
                                <div style="float:right; padding-right:70px;">
                                <a href="#" onclick="openlogin();"><img src="/skin/img/logintxt.png" width="55" height="14" /></a>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                    </div>
                    <div id="loginbox" style="display:none;" >
                       <div style="width:315px; margin:0 auto; margin-top: 25px;">
                           <div style="padding-left: 7px;">
                                <div style="margin-bottom:9px; margin-top: 2px; margin-left: -100px;">
                                    <img src="/skin/img/welcomeback.png" width="489" height="48" />
                                </div>
                     
                           </div>
                           <div style="margin-top: 35px;">
                               <div style="margin-bottom: 20px;"><a href="<?= $login_urls['facebook'] ?>"><img src="/skin/img/signinfacebook2.png" width="304" height="66" /></a></div>
                               <div style="clear:both;"></div>
                               <div style="margin-bottom: 20px;"><a href="<?= $login_urls['instagram'] ?>"><img src="/skin/img/signininstagram2.png" width="304" height="66"/></a></div>
                               <div style="clear:both;"></div>
                               <div style="margin-bottom: 20px;"><a href="<?= $login_urls['twitter'] ?>"><img src="/skin/img/signintwitter2.png" width="304" height="66" /></a></div>
                               <div style="clear:both;"></div>
                               <div><a href="/mobile/login.php"><img src="/skin/img/signinemail2.png" width="304" height="66" /></a></div>
                           
                           </div>
                           
                        </div>
                    </div>        
                            
                </div>

            </div>

        </div>
        <div class="cl"></div>	
        
    </div>