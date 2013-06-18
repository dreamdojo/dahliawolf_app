<?
$pageTitle = "Post";
include "head.php";
include "header.php";
include "post_slideout.php";

//require 'includes/php/classes/Spine' . $_data['spine_version'] . '.php';
$Spine = new Spine();
?>
<div id="sort-bar">
	sort inspirations by: 	<span class=""><a class="sort-option <?= ($_GET['sort'] == 'new' || empty($_GET['sort']) ? 'bold' : '') ?>" href="/spine?sort=new">newest</a></span> /
    						<span class=""><a class="sort-option <?= ($_GET['sort'] == 'hot' ? 'bold' : '') ?>" href="/spine?sort=hot"> hottest</a></span> /
                            <span class=""><a class="sort-option <?= ($_GET['sort'] == 'top' ? 'bold' : '') ?>" href="/spine?sort=top"> most popular</a></span>
                            <span style="padding-left:595px;">view: <span class=""><a class="sort-option <?= ($self == '/spine.php' ? 'bold' : '') ?>" href="/spine">artistic</a></span> /
    						<span class=""><a class="sort-option <?= ($self == '/grid.php' ? 'bold' : '') ?>" href="/grid"> grid</a></span>      
</span>
</div>
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
