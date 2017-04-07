<?php
include 'TransactionClass.php';
include 'database.php';

$pdo = Database::connect();

$sql = "SELECT customer_id FROM transactions WHERE id = :id";
$result = $pdo->prepare($sql);

$id = $_POST['id'];

$result->bindParam(':id', $id);

$result->execute();

$row = $result->fetch();
Database::disconnect();

$customer_id = $row['customer_id'];

TransactionClass::getCustomerOptions($customer_id);
