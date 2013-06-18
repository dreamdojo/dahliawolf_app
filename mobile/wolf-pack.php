<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Wolfpack - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  

} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>
    <div class="activity-bar">WOLFPACK</div>
    <div class="feed-wrap">
		<? if (!empty($_data['users'])): ?>
    		<? foreach ($_data['users'] as $i => $user): ?>
    			<? $profile_url = '/mobile/profile.php?username=' . $user['username']."&session_type=".$_GET['session_type'] ?>
                <div class='prof-frame'>
                	<div class="rank-box"><p><?= $user['rank'] ?></p></div>
                    <a href='<?= $profile_url ?>'><img class='wolfpack-user-image' src='<?= $user['avatar'] ?>&amp;width=190'></a>
                </div>
            <? endforeach ?>
		<? endif ?>
    </div>
<? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"  ?>