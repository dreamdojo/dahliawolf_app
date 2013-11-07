<?
$redirect_url = 'http://' . $_SERVER['SERVER_NAME'] . '/social-login.php';
$login_urls = array(
	//'facebook' => 'https://www.facebook.com/dialog/permissions.request?app_id=615125678513357&display=page&next=' . $redirect_url . urlencode('?social_network=facebook') . '&response_type=code&fbconnect=1&perms=email,offline_access,publish_stream'
	'facebook' => '/social-login.php?social_network=facebook'
	//, 'instagram' => 'http://www.dahliawolf.com/instagram_connect.php'
	, 'instagram' => '/social-login.php?social_network=instagram'
	//, 'twitter' => 'http://www.dahliawolf.com/oauth/redirect.php'
	, 'twitter' => '/social-login.php?social_network=twitter'
);
?>
<script type="text/javascript" src="/js/post-inline-js.js"></script>

<style>
#UnauthCallout{
	display:none; height:550px;width:650px;
}
.nag-frame{
	width:550px; height:550px; border:0px ; background-color:black;
}
.nf-doom{
	width:315px; margin:0 auto; margin-top: 25px;
}
#signinbox .fb-butt{
	margin-bottom:20px; margin-top: 1px;
}
.creative{
	float:left; padding-top:3px; padding-left:75px;
}
#signinbox .email{
	float:right; padding-right:70px;
}
.loginbox .framer{
	width:315px; margin:0 auto; margin-top: 25px;
}
.framer{
	color:white;
}
.framer-in{
	padding-left: 7px;
}
.framer-in-in{
	margin-bottom:9px; margin-top: 30px; margin-left: -24px;
}
.texting{
	font-size:13px; margin-top: 10px; margin-bottom: 10px; color: gray;
}
.rememberme{
	margin-left:-138px;
}
.loginbutton{
margin-left: 150px;
margin-top: -29px;
}
.tos-statement{color: #fff; text-align: left; font-size: 10px;}
.tos-statement a{color: #fff;}
.tos-statement a:hover{color: red;}
.aac{margin-top: 2px;position: absolute;bottom: 10px;}


</style>
<div id="mask"></div>
<div id="UnauthCallout">
        <div class="Nag">
            <div class="Sheet1 Sheet">
                <div class="nag-frame">
                    <div style="float:right;"><a href="#" id="closebtn"><img src="/skin/img/closewhite.png" height="32" width="32" /></a></div>
                    <div style="clear:both"></div>
                    
                    <div id="signinbox" style="display:none;">
                       <div class="nf-doom">
                            <div style="margin-bottom:48px; margin-top: 2px; ">
                        	<img src="/skin/img/signup_title.png" width="288" height="48" />
                            </div>
                            
                            <div class="fb-butt"><a href="<?= $login_urls['facebook'] ?>"><img src="/skin/img/signinfacebook.png" width="244" height="49" /></a>
                            </div>
                            
                            
                            <div id="login-three">
                 <div class="texting">or sign up with email:</div>
                           
                    <div class="form-box">
                    	<form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/signup.php">
                            <ul style="margin-bottom: -3px;">
                            	<li>
                                    <input class="input_text" type="text" name="user_username" id="user_username" value="" max="30" placeholder="Username" />
                                    <span class="fff"></span>
                                </li>
                               
                                <li>
                                    <input class="input_text" type="text" name="user_email" id="user_email" value="" placeholder="Email" />
                                    <span class="fff"></span>
                                </li>
                                <li>
                                    <input class="input_text" type="password" name="user_password" id="user_password" value="" placeholder="Password" />
                                    <span class="fff"></span>
                                </li>    
                            </ul>
                            <div class="non_inputs">
                                <div class="tos-statement">By creating an account, I accept Dahlia Wolf's <a href="/tos">Terms of Service</a> and <a href="/tos">Privacy Policy</a></div>
                                <input type="image" src="http://www.dahliawolf.com/images/reg.png" id="sysForm_submit" style="float: right;padding-right: 13px;padding-top: 5px;height: 30px;">
                            </div>
                                <input type="hidden" name="r" value="" />
     							<input type="hidden" name="jsub" value="1" />
                        </form>
                    </div>
                    <div>
                        <iframe src="//www.facebook.com/plugins/facepile.php?href=http%3A%2F%2Fwww.facebook.com%2FNASTYGAL&amp;action&amp;size=small&amp;max_rows=1&amp;show_count=false&amp;width=300&amp;colorscheme=dark&amp;appId=133259003395199" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:330px; height: 75px; margin-top: 27px;margin-left: 0px;" allowTransparency="true"></iframe>
                    </div>

                </div>
                            <div style="clear:both;"></div>
                            <div class="aac" style="margin-top: 2px">
                            	<div class="creative">
                            		<img src="/skin/img/alreadycreative.png" width="106" height="12" />
                                </div>
                                <div class="email">
                                	<a href="#" onclick="openlogin();"><img style="margin-left: 10px;" src="/skin/img/logintxt.png" width="55" height="14" /></a>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div id="loginbox" style="display:none;" >
                       <div class="framer">
                           <div class="framer-in">
                                <div class="framer-in-in">
                                    <img src="/skin/img/welcomeback.png" width="" height="" />
                                </div>
                      
                           </div>
                           <div style="margin-top: 88px;">
                               <div style="margin-bottom: 20px;"><a href="<?= $login_urls['facebook'] ?>"><img src="/skin/img/signinfacebook2.png" width="244" height="49" /></a></div>
                               <div style="clear:both;"></div>                        
                           </div>
                           <div class="texting">or login with email/username:</div>
                           <div>
                               <form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/login.php">
                                <ul>
                                    <li>
                                        <input class="input_text" type="text" name="identity" id="sysForm_identity" value="">
                                        <label for="sysForm_identity">E-Mail or Username</label><span class="fff"></span>
                                    </li>
                                    <li>
                                        <input class="input_text" type="password" name="credential" id="sysForm_credential" value="">
                                        <label for="sysForm_credential">Password</label>
                                        <span class="fff"></span>
                                    </li>
                                    <li style="text-align: left;">
                                        <a style="color: #888;font-size: 12px;" href="/reset-password-link.php">Forgot password?</a>
                                    </li>
                                    <li><span class="rememberme">
                                        <input class="checkbox" id="l_remember_me" name="l_remember_me" type="checkbox" value="1">
                                        <span class="texting"> Remember me</span></span>
                                    </li>   
                                </ul>
                                <div class="non_inputs">
                                    <input type="image" src="http://www.dahliawolf.com/images/login.png" class="loginbutton" value="Log in" id="sysForm_submit">
                                </div>
                                 <input type="hidden" name="r" value="">
                                 <input type="hidden" name="sublog" value="1">
                            </form>
                          </div> 
                          
                        </div>
                    </div>        
                            
                </div>

            </div>

        </div>
        <div class="cl"></div>	
    </div>
    <script>
		$("#tooltip-overlay").fadeIn(100);
    </script>