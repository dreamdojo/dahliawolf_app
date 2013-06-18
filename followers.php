<?
$pageTitle = "Followers";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<div class="ColumnContainer" style="margin-top: 80px;">
        
        <div class="BoardTitle">
		<div class="follow-bar"><h1>FOLLOWERS</h1></div>
        <h2><a style="text-transform: uppercase;" href="/profile.php?username=<?= $_data['user']['username'] ?>"><?= $_data['user']['username'] ?></a></h2>
		<div class="desc"></div>
	</div>
    <div class="cl"></div>

    <div class="FixedContainer">
        <div class="WhiteContainer clearfix">
            <div id="sysFollowList" class="PeopleList">
            	<?
            	list_users($_data['followers']);
				?>
            </div>
        </div>
        <div class="cl"></div>
        <div id="sysScrollContainerBottom"></div>
    </div>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>