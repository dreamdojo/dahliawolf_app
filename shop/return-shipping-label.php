<?
require_once $_SERVER['DOCUMENT_ROOT'] .'/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mobile-detect.php';

if (empty($_SESSION['user'])) {
	$_SESSION['errors'] = array('Please login to continue.');
	redirect('/login.php');
	die();
}

$errors = NULL;
$generateNewLabel = (isset($_GET['new-label']) && $_GET['new-label'] == '1') ? true : false;
$labelPath = '/shop/return-shipping-labels/' . (isset($_GET['id_order']) ? $_GET['id_order'] : '');
$labelExists = file_exists($_SERVER['DOCUMENT_ROOT'] . $labelPath);
	
if (empty($_GET['id_order']) || !is_numeric($_GET['id_order'])) {
	$errors = array(
		'Order ID is required.'
	);
}
else if (!$generateNewLabel && !$labelExists) {
	$_SESSION[CR]['user-error'] = 'No current label exists. Please create new shipping label.';
}
else {
	
	$calls = array(
		'generate_return_shipping_label' => array(
			'id_order' => $_GET['id_order']
			, 'user_id' => $_SESSION['user']['user_id']
			, 'generate-new-label' => $generateNewLabel
		)
	);
	
	$data = commerce_api_request('orders', $calls, true);
	//$data = commerce_api_request('orders', $calls, false); echo $data; die();
	
	$errors = api_errors_to_array($data);
				
	if (empty($errors) && $generateNewLabel) {
		$fp = fopen(DR . $labelPath, 'w+');
		if ($data['data']['generate_return_shipping_label']['data']['base64_encoded']) {
			fwrite($fp, base64_decode($data['data']['generate_return_shipping_label']['data']['label']));
		}
		else {
			fwrite($fp, $data['data']['generate_return_shipping_label']['data']['label']);
		}
		fclose($fp);
	}
	
	if (empty($errors)) {
		
		header('Content-type:' . $data['data']['generate_return_shipping_label']['data']['content-type']);
		header('Content-Disposition: inline; filename="shipping label"');
		header('Pragma: public'); // need for IE
		header('Content-Length: ' . filesize(DR . $labelPath));
		
		readfile(DR . $labelPath);
		
		/* Do not forgot to call exit; after readfile else you will get trouble 
		with the file checksum of the file, because there will be added \n at the end of the script. */
		exit;
		
	}
}

if (!empty($errors)) {
	$_SESSION['errors'] = $errors;
}

$pageTitle = "Shop - Order Return Shipping Label";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";

?>
<div class="shop body checkout order">
	<?
	include $_SERVER['DOCUMENT_ROOT'] . "/common/cart-summary.php";
	?>

</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>