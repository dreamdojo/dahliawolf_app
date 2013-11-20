<?php if(!IS_LOGGED_IN): ?>
    <?php include "login_pop.php"; ?>
<?php endif ?>
<?php include "themes/header_template.php" ?>

<form action="action/post_image.php" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">


<div id="post-me">
	<div id="u-clsr" onclick="imgUpload.closeMe()">X</div>
    <div class="uploader-frame">
    	<img id="user-uploaded-img" />
    </div>

        <input type="hidden" name="subpin" value="1">
        <div style="text-align: center;"><textarea name="description" id="comment">#dahliawolf</textarea></div>
        <div style="text-align: center;padding-bottom: 25px; margin-top: 10px;"><input name="submit" type="image" src="/images/postitbtn2.png" onclick="$(this).hide()" id="image-sub"></div>
</div>
</form>

<?
if (!empty($_SESSION['errors'])): ?>
    <script>
        _gaq.push(['_trackEvent','Errors' , '<?= $_SESSION['errors'][0] ?>']);
    </script>
	<div class="user-message user-error ui-state-error ui-corner-all">
        <div class='user-message-close'>X</div>
        <?php if (count($_SESSION['errors']) == 1 && trim($_SESSION['errors'][0]) != '' ): ?>
			<?php if (!empty($_SESSION['errors'][0])): ?>
				<p><?= $_SESSION['errors'][0] ?></p>
                <script>_gaq.push(['_trackEvent','Errors' , '<?= $_SESSION['errors'][0] ?>']);</script>
		    <?php endif ?>
		<?php else: ?>
			<ul>
				<?php foreach ($_SESSION['errors'] as $error): ?>
                    <script>_gaq.push(['_trackEvent','Errors' , '<?= $error ?>']);</script>
					<li><?= $error ?></li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
	</div>
	<?php unset($_SESSION['errors']); ?>
<?php endif ?>

<?php if( !empty($_SESSION['success']) ): ?>
    <script>
        _gaq.push(['_trackEvent','Success' , '<?= $_SESSION['success'] ?>']);
    </script>
    <div class="user-message user-success ui-state-highlight ui-corner-all">
        <div class='user-message-close'>X</div>
        <p><?= $_SESSION['success'] ?></p>
    </div>
    <?php unset($_SESSION['success']) ?>
<?php endif ?>
