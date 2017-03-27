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
							echo '<a class="btn" href="productRead.php?id='.$row['pid'].'">Read</a>';
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
				<a class="btn btn-info" href="transactions.php">Transactions</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>