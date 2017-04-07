<?php
include 'TransactionClass.php';
$customer_id = $_POST['customer_id'];
$product_id = $_POST['product_id'];
TransactionClass::insertTransaction($customer_id, $product_id);