<?php session_start() ?>
<div id="userMenu">
    <div id="userAvatar" class="avatarFrame theUsersAvatar">
        <a id="" href="/<?= $_SESSION['user']['username'] ?>">
            <img src="<?= $_SESSION['user']['avatar'] ?>&width=100">
        </a>
    </div>
    <div id="userName" class="userName">
        <a href="/<?= $_SESSION['user']['username'] ?>" style="color: #fff !important;">
            <?= $_SESSION['user']['username'] ?>
        </a>
    </div>
    <ul id="theDropdown" class="dahliaBGColor">
        <a href="/<?= $_SESSION['user']['username'] ?>"><li style="border-top: none;">Profile</li></a>
        <a href="/<?= $_SESSION['user']['username'] ?>?dashboard=true"><li>Dashboard</li></a>
        <a href="/activity"><li id="menuActivity">Activity</li></a>
        <a href="/invite"><li id="menuClique">Grow My Clique</li></a>
        <a href="/account/settings"><li>Settings</li></a>
        <a href="/shop/my-orders"><li>Orders</li></a>
        <a href="/action/logout"><li>Logout</li></a>
    </ul>
</div>
