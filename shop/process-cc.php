<?
require '../config/config.php';
require '../includes/php/initial-calls.php';
if (isset($_SESSION) && isset($_GET['s'])) {
	print_r($_SESSION);
}

die();

/*
$calls = array(
	'process_credit_card' => array(
		'amount' => 2
		, 'name' => 'fname lname'
		, 'number' => '4111111111111111'
		, 'exp_month' => '01'
		, 'exp_year' => '2020'
		, 'cvv' => '000'
		
	)
);
$data = api_request('payment', $calls, true);
*/
$calls = array(
	'place_order' => array(
		'payment_info' => array(
			'amount' => 33
			, 'cc_name' => 'fname2 lname2'
			, 'cc_number' => '4111111111111111'
			, 'cc_exp_month' => '01'
			, 'cc_exp_year' => '2020'
			, 'cc_cvv' => '111'
			, 'description' => 'Test purchase'
		)
	)
);
$data = commerce_api_request('orders', $calls, true);

p_r($data);
?>