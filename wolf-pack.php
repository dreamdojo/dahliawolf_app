<?
$pageTitle = "Wolf Pack";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

$params = array(
    'username' => strtolower($_SESSION['user']['username']),
    'limit' => 0
);

if (IS_LOGGED_IN) {
    $params['viewer_user_id'] = $_SESSION['user']['user_id'];
}
$data = api_call('user', 'get_user', $params, true);
$user = $data['data'];
?>
<div id="wolfPackHeader" style="height: 1px;width: 100px;"></div>
<div id="userListCol"></div>

<
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
    $(function() {
        dahliawolfUserList = new userList(<?= json_encode($user) ?>, '<?= $self ?>');
        dahliawolfUserList.getUsers();
    });
</script>