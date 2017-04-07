<?php
include 'TransactionClass.php';
include 'database.php';
$pdo = Database::connect();
$sql = "SELECT product_id FROM transactions WHERE id = :id";
$result = $pdo->prepare($sql);

$id = $_POST['id'];
$result->bindParam(':id', $id);

$result->execute();

$row = $result->fetch();
Database::disconnect();

$product_id = $row['product_id'];

TransactionClass::getProductOptions($product_id);
