<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$_data['cart'] = get_cart();

echo json_encode($_data['cart']);
?>