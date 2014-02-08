<?
    $pageTitle = "Discover New Fashion + HYPE";
    $pageDesc = 'Exploser some of our most popular posts on Dahlia Wolf';
    include "head.php";
    include "header.php";
?>
<?php include "blocks/filter.php"; ?>

<div id="voteBucket"></div>
<?php //include "footer.php" ?>
<style>
    #memberResults{display: inline-block;max-height: 185px; overflow: hidden;-moz-transition: 1s;-ms-transition: 1s;-o-transition: 1s;-webkit-transition: 1s;transition: 1s; width: 1030px;}
    .loadMore{width: 100%;height: 45px;line-height: 45px;text-align: center;font-size: 14px;border: #c2c2c2 thin solid;border-radius: 8px;width: 962px; cursor: pointer;}
    .loadMore:hover{background-color: #dadada;}
    .userSearchRes{width: 150px;height: 150px;float: left; padding-top: 20px;border: #c2c2c2 thin solid;border-radius: 10px; margin-right: 51px;margin-bottom: 15px;}
    .userSearchRes .username{float: left;width: 100%;line-height: 50px;font-size: 15px;text-align: center;margin-top: 10px;width: 90%;margin-left: 5%;overflow: hidden;text-overflow: ellipsis;}
    .userSearchRes ul{margin-left: 35px;}
</style>
<script>
 $(function() {
     dahliawolfFeed = new voteFeed({mode:'grid' <?= !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <?= !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
 });
</script>
