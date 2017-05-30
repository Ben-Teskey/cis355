<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://bootswatch.com/cyborg/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>Customers</h3>
    		</div>
			<div class="row">
				<p>
					<a href="customerCreate.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
						  <th>Username</th>
						  <th>Password</th>
						  <th>Address</th>
						  <th>Payment Info</th>
		                  <th>Email Address</th>
		                  <th>Mobile Number</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
					  
					  <?php
					    include 'database.php';
						echo '<tbody>';
						$pdo = Database::connect();
						$sql = 'SELECT * FROM customers ORDER BY cid DESC';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. $row['cname'] . '</td>';
							echo '<td>'. $row['username'] . '</td>';
							echo '<td>'. $row['password'] . '</td>';
							echo '<td>'. $row['address'] . '</td>';
							echo '<td>'. $row['payment_info'] . '</td>';
							echo '<td>'. $row['email'] . '</td>';
							echo '<td>'. $row['mobile'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn btn-default" href="customerRead.php?id='.$row['cid'].'">Read</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="customerUpdate.php?id='.$row['cid'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="customerDelete.php?id='.$row['cid'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';
						}	
						echo '</tbody>';
						Database::disconnect();
					  ?>
					  
	            </table>
				<a class="btn btn-info" href="products.php">Products</a>
				<a class="btn btn-info" href="transactions.html">Transactions</a>
                <a class="pull-right btn btn-danger" href="logout.php">Logout</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>