<ul class="checkout nav">
	<?
	$i = 0;
	$is_completed = true;
	foreach ($order_stages as $key => $name) {
		$is_current = $current_step == $key;
		if ($is_current) {
			$is_completed = false;
		}
		?>
		<li class="<?= $is_current ? 'current' : '' ?><?= $is_completed ? 'completed' : '' ?>">
			<a href="?step=<?= $key ?>">
				<?= $name ?>
			</a>
		</li>
		<?
		$i++;
	}
	?>
</ul>