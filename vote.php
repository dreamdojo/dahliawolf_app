<?
    $pageTitle = "Vote";
    include "head.php";
    include "header.php";
?>
<?php include "blocks/filter.php"; ?>

<div id="voteBucket"></div>
<?php include "/footer.php" ?>
<style>
    #memberResults{display: inline-block;}
    .userSearchRes{width: 150px;height: 150px;float: left; padding-top: 20px;border: #c2c2c2 thin solid;border-radius: 10px; margin-right: 15px;margin-bottom: 15px;}
    .userSearchRes .username{float: left;width: 100%;line-height: 50px;font-size: 15px;text-align: center;margin-top: 10px;width: 90%;margin-left: 5%;overflow: hidden;text-overflow: ellipsis;}
    .userSearchRes ul{margin-left: 35px;}
</style>
<script>
 $(function() {
     dahliawolfFeed = new voteFeed({mode:'grid' <?= !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <?= !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
 });
</script>
