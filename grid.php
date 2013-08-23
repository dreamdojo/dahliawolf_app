<?
$pageTitle = "Grid";
include "head.php";
include "header.php";
?>

<div id="sort-bar">
	sort inspirations by: 	<span class=""><a class="sort-option <?= ($_GET['sort'] == 'new' || empty($_GET['sort']) ? 'bold' : '') ?>" href="/grid?sort=new">newest</a></span> /
    						<span class=""><a class="sort-option <?= ($_GET['sort'] == 'hot' ? 'bold' : '') ?>" href="/grid?sort=hot"> hottest</a></span> /
                            <span class=""><a class="sort-option <?= ($_GET['sort'] == 'top' ? 'bold' : '') ?>" href="/grid?sort=top"> most popular</a></span>
                      
                     <span style="padding-left:560px;">view: <span class=""><a class="sort-option <?= ($self == '/spine.php' ? 'bold' : '') ?>" href="/spine">artistic</a></span> /
    						<span class=""><a class="sort-option <?= ($self == '/grid.php' ? 'bold' : '') ?>" href="/grid"> grid</a></span>      
</div>

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