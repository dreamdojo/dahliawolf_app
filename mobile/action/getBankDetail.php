<?
	require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
	//require 'functions-api.php';
	$result = array();
	
	$params = array(
		'posting_id' => $_GET['id'],
		'limit' => 1
	);
	$params['viewer_user_id'] = $_GET['viewer_user_id'];
	
	$data = api_call('posting', 'get_post', $params, true);
	$result['current'] = $data['data'];
	
	$params = array(
		'posting_id' => $result['current']['previous_posting_id'],
		'limit' => 1,
	);
	$params['viewer_user_id'] = $_GET['viewer_user_id'];
	
	$data = api_call('posting', 'get_post', $params, true);
	$result['previous'] = $data['data'];
	
	header('Content-type: application/json');
	echo json_encode($result);
?>