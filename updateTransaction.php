<?php
include 'TransactionClass.php';
$id = $_POST['id'];
$customer_id = $_POST['customer_id'];
$product_id = $_POST['product_id'];
$time = $_POST['time'];

TransactionClass::updateTransaction($id, $customer_id, $product_id, $time);