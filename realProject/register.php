<?php
session_start();
include 'database.php';
$pdo = Database::connect();

$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$errorMessage = "";

if (isset($_POST['username']) or isset($_POST['password']) or isset($_POST['confirmPassword'])) {
    if (!empty($username) and !empty($password) and $password == $confirmPassword) {

            // Attempt to register the user
            $sql = "INSERT INTO `user` (username, `password`, usertype) VALUES (?, ?, ?)";
            $result = $pdo->prepare($sql);

            if ($result->execute(array($username, $password, "standard"))) {
                $_SESSION['username'] = $username;
                $_SESSION['usertype'] = "standard";
                header('Location: transactions.html');
            }
            else $errorMessage = 'User already exists.';


    }
    else $errorMessage = 'Your data is invalid.';
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
    <h2>Register</h2>
    <?php echo $errorMessage ?>
    <form class="form" method="post" action="register.php">
        <div class="form-group col-xs-12">
            <div class="col-xs-2"><label for="username">Username:</label></div>
            <div class="col-xs-3"><input name="username" class="form-control" id="username"></div>
        </div>
        <div class="form-group col-xs-12">
            <div class="col-xs-2"><label for="password">Password:</label></div>
            <div class="col-xs-3"><input name="password" type="password" class="form-control" id="password"></div>
        </div>
        <div class="form-group col-xs-12">
            <div class="col-xs-2"><label for="confirmPassword">Confirm Password:</label></div>
            <div class="col-xs-3"><input name="confirmPassword" type="password" class="form-control" id="confirmPassword"></div>
            <button type="submit" class="btn btn-default col-xs-1">Submit</button>
        </div>
        <div style="padding-top: 25px; display:inline-block;"><p>Already have an account? <a href="login.php">Login here</a></p></div>
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
