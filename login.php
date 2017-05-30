<?php
session_start();
include 'database.php';
$pdo = Database::connect();

$username = $_POST['username'];
$password = $_POST['password'];
$errorMessage = "";

if (isset($_SESSION['username'])) header('Location: transactions.php');
else {

    if (isset($username) or isset($password)) {

        $sql = "SELECT username, usertype FROM `user` WHERE username = ? AND `password` = ?";
        $result = $pdo->prepare($sql);
        $result->execute(array($username, $password));

        if ($result->rowCount() == 1) {

            $row = $result->fetch();
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $row['usertype'];
            header('location: transactions.html');

        }
        else $errorMessage = "Invalid login credentials";

    }

}

Database::disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://bootswatch.com/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php echo $errorMessage ?>
    <form class="form" method="post" action="login.php">
        <div class="form-group col-xs-12">
            <div class="col-xs-2"><label for="username">Username:</label></div>
            <div class="col-xs-3"><input name="username" class="form-control" id="username"></div>
        </div>
        <div class="form-group col-xs-12">
            <div class="col-xs-2"><label for="password">Password:</label></div>
            <div class="col-xs-3"><input name="password" type="password" class="form-control" id="password"></div>
            <button type="submit" class="btn btn-default col-xs-1">Submit</button>
        </div>
        <div style="padding-top: 25px; display:inline-block;"><p>Don't have an account? <a href="register.php">Register here</a></p></div>
        <style>
            label {
                padding-top: 10px;
            }
            h2 {
                padding-bottom: 30px;
            }
        </style>
    </form>
</div>
</body>
</html>
