<?
if($_GET['session_type'] == "web") {
	$pageTitle = "My Settings - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>
<style>
#profileEdit label{display:none;}
.menu-container{ width:80%;margin: 0px auto;}
.menu-container input{width:100% !important;position: relative;}
.menu-container select{margin-bottom: 10px;width: 100%;height: 30px; margin-left:0px;}
.menu-container textarea{width:100%;}
.logout-button{padding: 1em;background-color:#a53247;text-align: center;width: 60%;border-radius: 1em;border: #000 thin solid;box-shadow: inset .0em .1em 1em .1em #000000;font-size: 1em;font-weight: bold;font-family: arial;margin: 0px auto;color: #fff;text-shadow: .14em .14em #000;margin-top: 12%;}
</style>

<div class="menu-container">
    <? 
	if(!empty($_SESSION['errors'])) {
		foreach($_SESSION['errors'] as $error){
			echo '<div class="error_block">'.$error.'</div>';
		}
	}
	?>
    <form id="profileEdit" class="Form" action="/action/settings.php" method="POST" style="padding-top:20px;" enctype="multipart/form-data">
     	<?
     	if (!empty($_GET['session_type'])) {
     		?>
     		<input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
     		<?
		}
     	?>
        <ul>
            
            <li>
               	<input type="text" name="email" value="<?= $_data['user']['email_address'] ?>" id="email" placeholder="EMAIL" />
                <span class="help_text">Not shown publicly</span>
            </li>
            
            <li>
               	<input type="text" name="first_name" value="<?= $_data['user']['first_name'] ?>" id="fname" placeholder="First Name" />
            </li>
            
            <li>
                <input type="text" name="last_name" value="<?= $_data['user']['last_name'] ?>" id="lname" placeholder="Last Name" />
            </li>
            
            <li>
                <input type="text" name="username" value="<?= $_data['user']['username'] ?>" id="username" placeholder="Username" />
                <span class="help_text">Only letters A-Z and numbers 0-9 allowed.</span>
            </li>
            
            <li>
                	<input type="text" name="date_of_birth" value="<?= !empty($_data['user']['date_of_birth']) ? date('m/d/Y', strtotime($_data['user']['date_of_birth'])) : '' ?>" id="dob" placeholder="Enter Your Birthdate" />
                    <span class="help_text">MM/DD/YYYY</span>
            </li>
            
            <li>
                <label for="id_gender_0">Gender</label>
                <div id="genderOptions">
                    <ul class="radios">
                    	<?
                    	$genders = array(
                    		'Male' => 'Male'
                    		, 'Female' => 'Female'
                    		, 'Unspecified' => ''
						);
						$i = 0;
						foreach ($genders as $name => $value) {
							?>
							<li>
                            	<input  type="radio" id="id_gender_<?= $i ?>" value="<?= $value ?>" name="gender" <?= $_data['user']['gender'] == $value ? ' checked="checked"' : '' ?> /> <?= $name ?></label></li>
							<?
							$i++;
						}
                    	?>
                    </ul>
                    
                </div>
            </li>

            <li>
                <textarea id="id_about" rows="3" name="about" placeholder="About"><?= $_data['user']['about'] ?></textarea>
                <div class="CharacterCount" id="aboutCount"></div>
            </li>

            <li>
                <input type="text" name="location" id="id_location" value="<?= $_data['user']['location'] ?>" placeholder="Location" />
                <span class="help_text">e.g. Las Vegas</span>
            </li>

            <li>
                  <input type="text" name="website" id="id_website" value="<?= $_data['user']['website'] ?>" placeholder="Website" />
            </li>

            <li>
                <div class="current_avatar_wrapper">
                  	<img src="<?= $_data['user']['avatar'] ?>" class="current_avatar floatLeft" />
                </div>
            </li>
            
            <li>

                    <p><input id="gphoto" type="file" name="avatar" size="6" /></p>                        
                <span class="help_text">Accepted Formats: jpeg, jpg, gif and png</span>
            </li>
            
            <li>
                	<a href="/mobile/account/password.php?session_type=<?= $_GET['session_type'] ?>" class="Button WhiteButton Button18 cp-butt"><strong>Change Password</strong><span></span></a>
            </li>
            
                        <li>
                <label for="post_fb">Post to facebook</label>
                    <p>
                    	<?
                    	$facebook_post = !empty($_data['user']['facebook_post']);
                    	?>
                    	<select name="facebook_post" id="post_fb">
                        	<option value="0" <?= !$facebook_post ? 'selected="selected"' : '' ?>>No</option>
                            <option value="1" <?= $facebook_post ? 'selected="selected"' : '' ?>>Yes</option>
                        </select>
                    </p>                        
                <span class="help_text">Posts your activity to facebook when you are logged in via facebook</span>
            </li>
                        
                        <li>
                <label for="post_fb">Import images from Instagram</label>
                    <p>
                    	<?
                    	$instagram_import = !empty($_data['user']['instagram_import']);
                    	?>
                    	<select name="instagram_import" id="instagram_pt">
                        	<option value="0" <?= !$instagram_import ? 'selected="selected"' : '' ?>>No</option>
                            <option value="1" <?= $instagram_import ? 'selected="selected"' : '' ?>>Yes</option>
                        </select>
                    </p>                        
                <span class="help_text">Imports images with hashtag 
                <br />
                                </span>
            </li>
                        <li>
                <label for="instagram_user">Instagram Username</label>
                	<input type="text" name="instagram_username" value="<?= $_data['user']['instagram_username'] ?>" id="instagram_user" placeholder="Instagram Username" />
                    <span class="help_text">This will enable us to import your Instragram pictures
                    <span></span>
                	</a>
                                        
                    </span>
            </li>
            <li>
                <input type="text" name="pinterest_username" value="<?= $_data['user']['pinterest_username'] ?>" id="pinterest_user" placeholder="Pinterest Username" />
                <span class="help_text">This will enable us to import your Pinterest pictures<span></span></span>
            </li>
            
            <li>
                <label for="mail_like">Comment notifications</label>
                    <p>
                    	<?
                    	$comment_notifications = !empty($_data['user']['comment_notifications']);
                    	?>
                    	<select name="comment_notifications" id="mail_like">
                        	<option value="0" <?= !$comment_notifications ? 'selected="selected"' : '' ?>>No</option>
                            <option value="1" <?= $comment_notifications ? 'selected="selected"' : '' ?>>Yes</option>
                        </select>
                    </p>                        
                <span class="help_text">Receive an e-mail when someone comments on your pins.</span>
            </li>
            
            <li>
                <p>
                    <?
                    $like_notifications = !empty($_data['user']['like_notifications']);
                    ?>
                    <select name="like_notifications" id="mail_com">
                        <option value="0" <?= !$like_notifications ? 'selected="selected"' : '' ?>>No</option>
                        <option value="1" <?= $like_notifications ? 'selected="selected"' : '' ?>>Yes</option>
                    </select>
                </p>                        
                <span class="help_text">Receive an e-mail when someone likes your pins.</span>
            </li>
        </ul>
        
        <div class="Submit">
            <p>
                <a href="#" class="Button OrangeButton Button24" onclick="$('#profileEdit').submit(); return false">
                	<strong style="font-size: 25px;" class="cp-butt">Submit</strong>
                	<span></span>
                </a>
            </p>
        </div>
        <div onclick="goHere('/action/logout.php', true)" class="logout-button">LOGOUT</div>
        <input type="hidden" name="esub" value="1" />
    </form>
</div>

<? 
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>