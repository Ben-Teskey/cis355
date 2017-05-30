<?php
session_start();
if (isset($_SESSION['username'])) {
} else throw new Exception('You are not logged in.');
?>