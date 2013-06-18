<?php if(!IS_LOGGED_IN): ?>
<?php include "login_pop.php"; ?>
<?php endif ?>
<? include "post_slideout.php" ?>
<?php include "themes/header_template.php" ?>
<?
// Errors
if (!empty($_SESSION['errors'])) {
	?>
	<div class="user-message user-error ui-state-error ui-corner-all">
		<?
		if (count($_SESSION['errors']) == 1) {
			if (!empty($_SESSION['errors'][0])) {
				?>
				<p><?= $_SESSION['errors'][0] ?></p>
				<?
			}
		}
		else {
			?>
			<ul>
				<?
				foreach ($_SESSION['errors'] as $error) {
					?>
					<li><?= $error ?></li>
					<?
				}
				?>
			</ul>
			<?
		}
		?>
	</div>
	<?
	unset($_SESSION['errors']);
}
// Success msg
if (!empty($_SESSION['success'])) {
	?>
	<div class="user-message user-success ui-state-highlight ui-corner-all">
		<p><?= $_SESSION['success'] ?></p>
	</div>
	<?
	unset($_SESSION['success']);
}
?>
