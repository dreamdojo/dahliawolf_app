<?
    $pageTitle = "Vote";
    include "head.php";
    include "header.php";
?>
<?php include "blocks/filter.php"; ?>

<div id="voteBucket"></div>
<?php include "footer.php" ?>

<script>
 $(function() {
     dahliawolfFeed = new voteFeed({mode:'spine' <? !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <? !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
 });
</script>
