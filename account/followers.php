<?
$pageTitle = "Following";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

$params = array(
    'username' => strtolower($_GET['username']),
    'limit' => 0
);

if (IS_LOGGED_IN) {
    $params['viewer_user_id'] = $_SESSION['user']['user_id'];
}
$data = api_call('user', 'get_user', $params, true);
$user = $data['data'];
?>

<div id="userListBanner">
    <div class="avatarFrame avatarShadow"><img src="<?= $user['avatar'] ?>&width=200"></div>
    <ul>
        <li style="font-size: 21px;"><a href="/<?= $user['username'] ?>"><?= $user['username'] ?></a></li>
        <li><?= $userConfig['location'] ?></li>
    </ul>
    <ul class="followLand">
        <li><a href="/<?= $user['username'] ?>/followers">Followers <?= $user['followers'] ?></a></li>
        <li><a href="/<?= $user['username'] ?>/following">Following <?= $user['following'] ?></a></li>
    </ul>
</div>
<div id="userListCol"></div>

<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
    $(function() {
        dahliawolfUserList = new userList(<?= json_encode($user) ?>, '<?= $self ?>');
        dahliawolfUserList.getUsers();
    });
</script>