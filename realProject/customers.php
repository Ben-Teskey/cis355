<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
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
							echo '<a class="btn" href="customerRead.php?id='.$row['cid'].'">Read</a>';
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
				<a class="btn btn-info" href="transactions.php">Transactions</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>