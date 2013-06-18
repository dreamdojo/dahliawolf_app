<?
if (!isset($_GET['ajax'])) {
	$pageTitle = "Post";
	include "head.php";
	include "header.php";
	include "post_slideout.php";
}
else {	
	require 'config/config.php';
	require 'includes/php/initial-calls.php';
}

//require 'includes/php/classes/Spine' . $_data['spine_version'] . '.php';
$bare = isset($_GET['bare']);
$Spine = new Spine(array('bare' => $bare));
$Spine->output($_data['posts'], '');
?>
<?php
if (!isset($_GET['ajax'])) {
	include "footer.php";
}
?>
