<?
$pageTitle = "My Settings";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>
<div class="FixedContainer settings-wrap">
    <div class="title-section">
		<div class='section-title'>ACCOUNT SETTINGS</div>
	</div>
    <form id="profileEdit" class="Form StaticForm" action="/action/settings.php" method="POST" style="padding-top:20px;" enctype="multipart/form-data">

        <ul>

            <li>
                <label for="id_link">Email</label>
                <div class="Right">
                	<input type="text" name="email" value="<?= $_data['user']['email_address'] ?>" id="email" />
                    <span class="help_text">Not shown publicly</span>
                </div>
            </li>

            <li>
                <label for="id_link">First Name</label>
                <div class="Right">
                	<input type="text" name="first_name" value="<?= $_data['user']['first_name'] ?>" id="fname" />
                </div>
            </li>

            <li>
                <label for="id_link">Last Name</label>
                <div class="Right">
                	<input type="text" name="last_name" value="<?= $_data['user']['last_name'] ?>" id="lname" />
                </div>
            </li>

            <li>
                <label for="id_link">Username</label>
                <div class="Right">
                	<input type="text" name="username" value="<?= $_data['user']['username'] ?>" id="username" />
                    <span class="help_text">Only letters A-Z and numbers 0-9 allowed.</span>
                </div>
            </li>

            <li>
                <label for="dob">Date of Birth</label>
                <div class="Right">
                	<input type="text" name="date_of_birth" value="<?= !empty($_data['user']['date_of_birth']) ? date('m/d/Y', strtotime($_data['user']['date_of_birth'])) : '' ?>" id="dob" />
                    <span class="help_text">MM/DD/YYYY</span>
                </div>
            </li>

            <li>
                <label for="id_gender_0">Gender</label>
                <div class="Right" id="genderOptions">
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
							<li><label for="id_gender_<?= $i ?>"><input  type="radio" id="id_gender_<?= $i ?>" value="<?= $value ?>" name="gender" <?= $_data['user']['gender'] == $value ? ' checked="checked"' : '' ?> /> <?= $name ?></label></li>
							<?
							$i++;
						}
                    	?>
                    </ul>

                </div>
            </li>

            <li>
                <label for="id_about">About</label>
                <div class="Right">
                    <textarea id="id_about" rows="3" cols="54" name="about"><?= $_data['user']['about'] ?></textarea>
                    <div class="CharacterCount" id="aboutCount"></div>

                </div>
            </li>

            <li>
                <label for="id_location">Location</label>
                <div class="Right">
                    <input type="text" name="location" id="id_location" value="<?= $_data['user']['location'] ?>" />
                    <span class="help_text">e.g. Las Vegas</span>

                </div>
            </li>

            <li>
                <label for="id_website">Website</label>
                <div class="Right">
                    <input type="text" name="website" id="id_website" value="<?= $_data['user']['website'] ?>" />
                    <span class="help_text">e.g. www.example.com</span>
                </div>
            </li>

            <li>
                <label for="id_img">Current Image</label>
                <div class="Right">

                    <div class="current_avatar_wrapper">
                      <img src="<?= $_data['user']['avatar'] ?>" class="current_avatar floatLeft" />
                    </div>
                </div>
            </li>

            <li>
                <label for="id_img">Change Image</label>
                <div class="Right">
                    <p><input id="gphoto" type="file" size="6" onchange="this.form.submit();" /></p>
                </div>
                <span class="help_text">Accepted Formats: jpeg, jpg, gif and png</span>
            </li>

            <li>
                <label>Password</label>
                <div class="Right">
                	<a href="/account/password.php" class="Button WhiteButton Button18"><strong>Change Password</strong><span></span></a>
                </div>
            </li>

                        <li>
                <label for="post_fb">Post to facebook</label>
                <div class="Right">
                    <p>
                    	<?
                    	$facebook_post = !empty($_data['user']['facebook_post']);
                    	?>
                    	<select name="facebook_post" id="post_fb">
                        	<option value="0" <?= !$facebook_post ? 'selected="selected"' : '' ?>>No</option>
                            <option value="1" <?= $facebook_post ? 'selected="selected"' : '' ?>>Yes</option>
                        </select>
                    </p>
                </div>
                <span class="help_text">Posts your activity to facebook when you are logged in via facebook</span>
            </li>

                        <li>
                <label for="post_fb">Import images from Instagram</label>
                <div class="Right">
                    <p>
                    	<?
                    	$instagram_import = !empty($_data['user']['instagram_import']);
                    	?>
                    	<select name="instagram_import" id="instagram_pt">
                        	<option value="0" <?= !$instagram_import ? 'selected="selected"' : '' ?>>No</option>
                            <option value="1" <?= $instagram_import ? 'selected="selected"' : '' ?>>Yes</option>
                        </select>
                    </p>
                </div>
                <span class="help_text">Imports images with hashtag
                <br />
                                </span>
            </li>
                        <li>
                <label for="instagram_user">Instagram Username</label>
                <div class="Right">
                	<input type="text" name="instagram_username" value="<?= $_data['user']['instagram_username'] ?>" id="instagram_user" />
                    <span class="help_text" style="max-width: 400px;">This will enable us to import your Instragram pictures<br />(Please note: it may take a minute to scrape your pictures)
                    <span></span>
                	</a>

                    </span>
                </div>
            </li>
                        <li>
                <label for="pinterest_user">Pinterest Username</label>
                <div class="Right">
                	<input type="text" name="pinterest_username" value="<?= $_data['user']['pinterest_username'] ?>" id="pinterest_user" />
                    <span class="help_text" style="max-width: 400px;">This will enable us to import your Pinterest pictures<br />(Please note: it may take a minute to scrape your pictures)
                    <span></span>
                	</a>

                    </span>
                </div>
            </li>
            <?
            /*
            <li>
                <label for="mail_like">Comment notifications</label>
                <div class="Right">
                    <p>
                    	<?
                    	$comment_notifications = !empty($_data['user']['comment_notifications']);
                    	?>
                    	<select name="comment_notifications" id="mail_like">
                        	<option value="0" <?= !$comment_notifications ? 'selected="selected"' : '' ?>>No</option>
                            <option value="1" <?= $comment_notifications ? 'selected="selected"' : '' ?>>Yes</option>
                        </select>
                    </p>
                </div>
                <span class="help_text">Receive an e-mail when someone comments on your pins.</span>
            </li>

            <li>
                <label for="mail_com">Like Notifications</label>
                <div class="Right">
                    <p>
                    	<?
                    	$like_notifications = !empty($_data['user']['like_notifications']);
                    	?>
                    	<select name="like_notifications" id="mail_com">
                        	<option value="0" <?= !$like_notifications ? 'selected="selected"' : '' ?>>No</option>
                            <option value="1" <?= $like_notifications ? 'selected="selected"' : '' ?>>Yes</option>
                        </select>
                    </p>
                </div>
                <span class="help_text">Receive an e-mail when someone likes your pins.</span>
            </li>
			*/
			?>
            <li>
                <label for="mail_like">Email Notifications</label>
                <div class="Right">
                    <p>
                    	<?
                    	$notification_interval = $_data['user']['notification_interval'];
                    	?>
                    	<select name="notification_interval" id="mail_like">
                    		<option value="">None</option>
                    		<?
                    		$notification_intervals = array(
                    			'Daily'
                    			, 'Weekly'
                    			, 'Monthly'
							);
							foreach ($notification_intervals as $interval) {
								?>
								<option value="<?= $interval ?>"<?= $interval == $notification_interval ? ' selected="selected"' : '' ?>><?= $interval ?></option>
								<?
							}
                    		?>
                        </select>
                    </p>
                </div>
                <span class="help_text" style="max-width: 400px;">Receive email updates of your current standings and activity.</span>
            </li>
        </ul>

        <div class="Submit">
            <p>
                <a href="#" class="Button OrangeButton Button24" onclick="$('#profileEdit').submit(); return false">
                	<strong>Submit</strong>
                	<span></span>
                </a>
            </p>
        </div>
        <input type="hidden" name="esub" value="1" />
    </form>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>