<?
$pageTitle = "Wolf Pack";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<div id="wolfPackHeader" style="height: 1px;width: 100px;"></div>
<div id="userListCol"></div>

<
<?
//include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
    $(function() {
        dahliawolfUserList = new userList({username:'<?= json_encode($user) ?>', api:'get_top_users'});
    });
</script>