<?
    $pageTitle = "Spine";
    include "head.php";
    include "header.php";

    //require 'includes/php/classes/Spine' . $_data['spine_version'] . '.php';
    $Spine = new Spine();
?>

<?php include "blocks/filter.php"; ?>

<?
if(isset($_GET['q']) && count($_data['users'])):?>
<div class="user-results">
	<div class="results-title">USERS:</div>
	<?php list_users($_data['users']) ?>
</div>
<? endif ?>
<?php
$Spine->output($_data['posts']);
?>
<?php include "footer.php" ?>
