<?php
include 'TransactionClass.php';
$id = $_POST['id'];
TransactionClass::getTime($id);