<?
$pageTitle = "Grid";
include "head.php";
include "header.php";
?>

<?php include "blocks/filter.php"; ?>

<?
if(isset($_GET['q']) && count($_data['users'])):?>
    <div class="user-results">
        <div class="results-title">USERS:</div>
        <?php list_users($_data['users']) ?>
    </div>
<? endif ?>

<div id="theGrid">
</div>

<?php include "footer.php" ?>
<script>

    $(function(){
        theGrid.init(<?= ( !empty($_GET['sort']) ? '"'.$_GET['sort'].'"' : 'null' ) ?>, <?= ( !empty($_GET['q']) ? '"'.$_GET['q'].'"' : 'null' ) ?>);
    });
</script>