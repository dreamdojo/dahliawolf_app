<?php 
	include "functions-api.php";
	$params = array();
	$params = array(
		 //'limit' => 50
		 'limit' => 15
		 , 'status' => 'Approved'
	);
	if (!empty($_GET['domain_keyword'])) {
		$params['domain_keyword'] = $_GET['domain_keyword'];
	}
	if (!empty($_GET['user_id'])) {
		$params['user_id'] = $_GET['user_id'];
	}
	if (!empty($_GET['offset'])) {
		$params['offset'] = $_GET['offset'];
	}
	
	$temp_data = api_call('feed_image', 'get_feed_images', $params);
	$feed_data = array();
	$feed_data = json_decode($temp_data, true);
	header('Content-type: application/json');
	echo $temp_data;
	//var_dump($feed_data['data']);
?>
