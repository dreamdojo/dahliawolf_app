<?
$pageTitle = "My Settings";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

if (empty($_SESSION['user']) || empty($_SESSION['user']['user_id'])) {
    default_redirect();
}

$params = array(
    'user_id' => $_SESSION['user']['user_id']
);
$data = api_call('user', 'get_user', $params, true);
$_data['user'] = $data['data'];

?>
<style>
    .SettingsCol{width: 1000px;margin: 0px auto;}
    #syncSocial{display: none;}
    .syncSection li:first-child{background-image: url("/public_html/images/postDeetsIcons.png"); background-size: auto 100%; background-repeat: no-repeat; width: 75px; height: 75px; float: left;}
    .syncSection li:last-child{font-size: 25px;height: 80px;line-height: 80px; cursor: pointer;}
    .syncFacebook li:first-child{background-position: -191px;}
    .syncTwitter li:first-child{background-position: -583px;}
    .syncTumblr li:first-child{background-position: -451px;}
    .socialTitle{font-size: 20px;width: 100%;text-align: center;height: 100px;line-height: 100px;}
</style>
    <div id="sort-bar">
        <div class="filter-wrap">
            Settings:
            <span class="">
                <a id="showProfile" class="sort-option filter-select" href="/vote?sort=new">Profile</a>
            </span> /
            <span class="">
                <a id="showSocial" class="sort-option" href="/vote?sort=hot"> Sharing</a>
            </span>
        </div>
    </div>

<div class="SettingsCol">
    <form id="profileEdit" class="Form StaticForm" action="/public_html/action/settings.php" method="POST" style="padding-top:20px;" enctype="multipart/form-data">
    <label for="id_img">Username: </label> <h1><?= $_data['user']['username'] ?></h1>
    <ul>
        <li>
            <label for="id_img">Current Avatar</label>
            <div class="Right">

                <div class="current_avatar_wrapper">
                    <img src="<?= $_data['user']['avatar'] ?>" class="current_avatar floatLeft" />
                </div>
            </div>
        </li>

        <li>
            <label for="id_img">Change Avatar</label>
            <div class="Right">
                <p><input id="gphoto" name="avatar" type="file" size="6" onchange="this.form.submit();" /></p>
            </div>
            <span class="help_text">Accepted Formats: jpeg, jpg, gif and png</span>
        </li>

        <li>
                <label for="id_link">Email</label>
                <div class="Right">
                	<input type="text" name="email" value="<?= $_data['user']['email_address'] ?>" id="email" />
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

            <!--<li>
                <label for="id_link">Username</label>
                <div class="Right">
                	<input type="text" name="username" value="<?= $_data['user']['username'] ?>" id="username" />
                    <span class="help_text">Only letters A-Z and numbers 0-9 allowed.</span>
                </div>
            </li>-->

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
                    <span class="help_text">e.g. Los Angeles</span>

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
                <label>Password</label>
                <div class="Right">
                	<a href="/account/password.php" class="Button WhiteButton Button18"><strong>Change Password</strong><span></span></a>
                </div>
            </li>


             <li>
                <label for="instagram_user">Instagram Username</label>
                <div class="Right">
                	<input type="text" name="instagram_username" value="<?= $_data['user']['instagram_username'] ?>" id="instagram_user" />
                </div>
            </li>
             <li>
                <label for="pinterest_user">Pinterest Username</label>
                <div class="Right">
                	<input type="text" name="pinterest_username" value="<?= $_data['user']['pinterest_username'] ?>" id="pinterest_user" />
                </div>
            </li>
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
                <a href="#" class="dahliaButton" onclick="$('#profileEdit').submit(); return false">
                	<strong>Save Changes</strong>
                	<span></span>
                </a>
            </p>
        </div>
        <input type="hidden" name="esub" value="1" />
    </form>
    <div id="syncSocial">
        <div class="socialTitle">Sync Dahlia\Wolf with your social media accounts to share with your friends!</div>
        <ul class="syncSection syncFacebook">
            <li></li>
            <li class="toggleButton"><?= $_SESSION['facebook']['access_token'] ? '<span data-platform="facebook" data-synced="true" class="dahliaPink">ON</span>' : '<span data-platform="facebook" data-synced="false">OFF</span>' ?></li>
        </ul>
        <ul class="syncSection syncTwitter">
            <li></li>
            <li class="toggleButton"><?= $_SESSION['twitter']['access_token'] ? '<span data-platform="twitter" data-synced="true" class="dahliaPink">ON</span>' : '<span data-platform="twitter" data-synced="false">OFF</span>' ?></li>
        </ul>
        <ul class="syncSection syncTumblr">
            <li></li>
            <li class="toggleButton"><?= $_SESSION['tumblr']['access_token'] ? '<span data-platform="tumble" data-synced="true" class="dahliaPink">ON</span>' : '<span data-platform="tumble" data-synced="false">OFF</span>' ?></li>
        </ul>
    </div>
</div>

<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
    $(function() {
        $('#showProfile').on('click', function(e) {
            e.preventDefault();
            $('.filter-select').removeClass('filter-select');
            $(this).addClass('filter-select');
            $('#syncSocial').hide();
            $('#profileEdit').show();
        });
        $('#showSocial').on('click', function(e) {
            e.preventDefault();
            $('.filter-select').removeClass('filter-select');
            $(this).addClass('filter-select');
            $('#syncSocial').show();
            $('#profileEdit').hide();
        });
        <?if(isset($_GET['social']))://rooty poo bootleg hack ?>
            $('#showSocial').click();
        <? endif ?>
        $('.toggleButton span').on('click', function() {
            var $this = $(this);
            if($(this).data('synced')) {
                switch($this.data('platform')) {
                    case 'facebook' :
                        dahliawolf.social.unsetPlatform(3, function() {
                            $this.html('OFF').data('synced', false).removeClass('dahliaPink');
                        });
                        break;
                    case 'twitter' :
                        dahliawolf.social.unsetPlatform(6, function() {
                            $this.html('OFF').data('synced', false).removeClass('dahliaPink');
                        });
                        break;
                    case 'tumblr' :
                        dahliawolf.social.unsetPlatform(14, function() {
                            $this.html('OFF').data('synced', false).removeClass('dahliaPink');
                        });
                        break;
                }
            } else {
                switch($this.data('platform')) {
                    case 'facebook' :
                        dahliawolf.logIntoFacebook(function() {
                            $this.html('ON').data('synced', true).addClass('dahliaPink');
                        });
                        break;
                    case 'twitter' :
                        dahliawolf.logIntoTwitter(function() {
                            $this.html('ON').data('synced', true).addClass('dahliaPink');
                        });
                        break;
                    case 'tumblr' :
                        dahliawolf.logIntoTumblr(function() {
                            $this.html('ON').data('synced', true).addClass('dahliaPink');
                        });
                        break;
                }
            }
        });
    });
</script>