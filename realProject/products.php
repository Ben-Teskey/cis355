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
    			<h3>Products</h3>
    		</div>
			<div class="row">
				<p>
					<a href="productCreate.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
						  <th>Description</th>
						  <th>Price</th>
						  <th>Action</th>
		                </tr>
		              </thead>
					  
					  <?php
					    include 'database.php';
						echo '<tbody>';
						$pdo = Database::connect();
						$sql = 'SELECT * FROM products ORDER BY pid DESC';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. $row['pname'] . '</td>';
							echo '<td>'. $row['description'] . '</td>';
							echo '<td>'. $row['price'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn btn-default" href="productRead.php?id='.$row['pid'].'">Read</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="productUpdate.php?id='.$row['pid'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="productDelete.php?id='.$row['pid'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';
						}	
						echo '</tbody>';
						Database::disconnect();
					  ?>
					  
	            </table>
				<a class="btn btn-info" href="customers.php">Customers</a>
				<a class="btn btn-info" href="transactions.html">Transactions</a>
                <a class="pull-right btn btn-danger" href="logout.php">Logout</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>