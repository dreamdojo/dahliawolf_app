<?
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
?>
<style>
html{height:100%; background-color:#000;}
#UnauthCallout{height: 550px; width: 100%; left: -5px;}
.action-banner{color:rgb(102, 102, 102); height: 50px;font-size: 1.5em;}
.face-wrap{margin-bottom: 10px;width: 100%;}
.face-wrap img{width: 100%;height: auto;border-radius: .4em;}
.log-frame{width: 100%; margin:0 auto;}
#signinbox{text-align: center;padding-top: 8%;}
#login-wrapper{height:100%;width: 80%; margin:0px auto;min-height: 100%;}
#login-wrapper li{margin: 0;padding: 1% 0;color: #8c7e7e;text-shadow: 0 1px rgba(255,255,255,0.9); border:none; width: 100%;}
#login-wrapper input{min-width:0px;width: 100%;background-color: #fff;border-radius: .4em;font-size: 1em;-webkit-appearance:none;} 
#login-wrapper input-webkit-autofill{color: #2a2a2a !important;}
.non_inputs{margin-top:0px !important}
.fields{margin:0px !important;}
.error_block{border: 1px solid #cd0a0a;background: #fbe7e7;color: #cd0a0a;height: 33px;border-radius: .4em;padding-top: 10px;margin-top: 15px;padding-top: 10px;width: 100%;margin: 0px auto; margin-bottom:10px;}
.StaticForm{margin:0px !important;width: 100%; padding:0px !important;}
</style>
                   
<div id="login-wrapper">   
   <div id="signinbox" style="display: none;">                         
        <div class="action-banner">
            SIGN UP OR <span class="j-link" onclick="switcharoo();">LOGIN HERE</span>
        </div>                            
        
        <?php if( !empty($_SESSION['errors']) ): ?>
            <div class="error_block"><?= $_SESSION['errors'][0] ?> </div>
        <?php endif ?>
        
        <div class="face-wrap">
        	<a href="/social-login.php?social_network=facebook">
            	<img src="/skin/img/signinfacebook.png">
            </a><p style="font-size: 17px;color: rgb(100, 100, 100);margin-top: 20px;">or sign up with email:<p />
        </div>
            
        <form id="sysForm" method="POST" class="Form FancyForm AuthForm StaticForm" action="action/signup.php" style="margin-top:8px;">
            <ul>
               <li>
                    <input class="input_text" type="text" name="user_username" id="sysForm_user_username" value="" placeholder="USERNAME" />
               </li>
               <li>
                    <input class="input_text" type="text" name="user_email" id="sysForm_user_email" value="" placeholder="EMAIL" />
                </li>
                <li>
                    <input class="input_text" type="password" name="user_password" id="sysForm_user_password" value="" placeholder="PASSWORD" />
                </li>
                <li>
                	<input type="image" src="images/s-up.jpg" id="sysForm_submit"/>
                    
                </li>  
            </ul>
             <input type="hidden" name="r" value="" />
             <input type="hidden" name="jsub" value="1" />
             <? if (!empty($_GET['session_type'])): ?>
                <input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
             <? endif ?>
        </form>
   </div>
                    
   <div id="loginbox" style="display: block;">                           
       <div class="action-banner">
            LOGIN OR <span class="j-link" onclick="switcharoo();">SIGN UP HERE</span>
       </div>
               
       <?php if( !empty($_SESSION['errors']) ): ?>
            <div class="error_block"><?= $_SESSION['errors'][0] ?> </div>
        <?php endif ?>
        
        <div class="face-wrap">
        	<a href="/social-login.php?social_network=facebook">
            	<img src="http://www.dahliawolf.com/images/signinfacebook2.png">
            </a><p style="font-size: 17px;color: rgb(100, 100, 100);margin-top: 20px;">or login with email:<p />
        </div>
               
       <form id="sysForm" method="POST" class="Form StaticForm login-form" action="action/login.php">
        <fieldset>
            <ul class="fields">
                <li>
                    <input class="input_text" type="text" name="identity" id="sysForm_identity" value="" placeholder="EMAIL" />
                </li>
                <li>
                    <input class="input_text" type="password" name="credential" id="sysForm_credential" value="" placeholder="PASSWORD" />
                </li>
            </ul>
        </fieldset>
        <div class="non_inputs"></div>
            <input type="image" src="images/login-butt.jpg" id="sysForm_submit">
        <div class="non_inputs">
            <!--<a href="/mobile/signup.php?session_type=<?//= $_GET['session_type'] ?>" id="urlGetInvite" class="colorless">Sign up now!</a>-->
            <!--<a href="/mobile/reset-password.php?session_type=<?// $_GET['session_type'] ?>" id="resetPassword" class="colorless">Forgot your password?</a>-->
        </div>
        <input type="hidden" id="l_remember_me" name="l_remember_me" type="checkbox" value="1">
        <input type="hidden" name="r" value="" />
        <input type="hidden" name="sublog" value="1" />
        <? if (!empty($_GET['session_type'])) { ?>
            <input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
        <? } ?>
    </form>                    
	</div>                                 
</div>

<? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>

<script>
function switcharoo(){
	if($('#loginbox').is(':visible')){
		$('#loginbox').hide();
		$('#signinbox').show();
	}else{
		$('#signinbox').hide();
		$('#loginbox').show();
	}
}
</script>