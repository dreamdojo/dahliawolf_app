<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/shop-initial-calls.php';

echo json_encode($_data['cart']);
?>