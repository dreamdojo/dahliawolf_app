<?
$pageTitle = "My Posts";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>
<div class="ColumnContainer" style="margin-top: 80px;">
    <div class="title-section">
		<div class='section-title'>MY POSTS</div>
	</div>
	
	<?
	//require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/classes/Spine.php';
	$Spine = new Spine();
	//$Spine->output($_data['posts']);
	$Spine->output($_data['posts'], 'spine', '/spine-chunk.php?username=' . $_SESSION['user']['username']);
	?>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>