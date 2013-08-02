<?
if (!empty($_GET['iso_code'])) {
	require '../config/config.php';

	$calls = array(
		'get_states_by_country_iso_code' => array(
			'iso_code' => $_GET['iso_code']
		)
	);
	$data = commerce_api_request('address', $calls, true);

	if ($data['success'] && $data['data']['get_states_by_country_iso_code']['success']) {
		echo json_encode($data['data']['get_states_by_country_iso_code']['data']);
	}
}
?>