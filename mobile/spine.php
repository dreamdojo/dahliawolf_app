<?
header( 'Location: post-feed.php?session_type=web' ) ;
$pageTitle = "Posts - Dahlia\Wolf";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";


//require DR . '/includes/php/classes/Spine.php';
$Spine = new Spine(array('bare' => true));
$Spine->output($_data['posts']);
?>
<style>
#sign-up-modal{ position:fixed; width:1000px; height:600px; left:50%; margin-left:-500px; top:50%; margin-top:-300px; background-color:#000; background-image:url(images/modal-popup-bg.jpg); background-size:cover; display:none;}
</style>
<div id="sign-up-modal"></div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>