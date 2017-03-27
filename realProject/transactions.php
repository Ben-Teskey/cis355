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
    			<h3>Transactions</h3>
    		</div>
			<div class="row">
				<p>
					<a href="transactionCreate.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Customer</th>
						  <th>Product</th>
						  <th>Time</th>
						  <th>Action</th>
		                </tr>
		              </thead>
					  
					  <?php
					    include 'database.php';
						echo '<tbody>';
						$pdo = Database::connect();
						$sql = 'SELECT * FROM transactions ORDER BY id DESC';

						foreach ($pdo->query($sql) as $row) {

                            $prodID = $row['product_id'];
                            $custID = $row['customer_id'];

                            $prodSQL = 'SELECT pname FROM products WHERE pid = ' . $prodID;
                            $custSQL = 'SELECT cname FROM customers WHERE cid = ' . $custID;

                            $custName = '';
                            $prodName = '';
                            foreach ($pdo->query($prodSQL) as $prodRow) {
                                $prodName = $prodRow['pname'];
                            }

                            foreach ($pdo->query($custSQL) as $custRow) {
                                $custName = $custRow['cname'];
                            }

							echo '<tr>';
							echo '<td>'. $custName . '</td>';
							echo '<td>'. $prodName . '</td>';
							echo '<td>'. $row['time'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn" href="transactionRead.php?id='.$row['id'].'">Read</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="transactionUpdate.php?id='.$row['id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="transactionDelete.php?id='.$row['id'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';
						}	
						echo '</tbody>';
						Database::disconnect();
					  ?>
					  
	            </table>
				<a class="btn btn-info" href="customers.php">Customers</a>
				<a class="btn btn-info" href="products.php">Products</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>