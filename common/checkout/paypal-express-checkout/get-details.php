<?

require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/classes/PayPalExpressCheckout.php';
$p = new PayPalExpressCheckout($useSandbox = true, 'rebekah-facilitator_api1.zyonnetworks.com','1373482287', 'AbmjisVIw-.85HPmDuT0wYxUXvZWAqX5h89QAoUcBIMG1Uf8qw7iJCQn');

$results = $p->completePurchase($_GET['paypal_token'], 274.00);
print_r($results);
if (!$results['success']) {
	die('failed');
}
die();
?>