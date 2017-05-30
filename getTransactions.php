<?php
include 'TransactionClass.php';
$search = $_POST['search'];
TransactionClass::getTransactions($search);