<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$customer_idError = null;
		$product_idError = null;
		
		// keep track post values
		$customer_id = $_POST['customer_id'];
		$product_id = $_POST['product_id'];
		echo $customer_id . ' ' . $product_id;

		// validate input
		$valid = true;
		if (empty($customer_id)) {
			$customer_idError = 'Please select a customer';
			$valid = false;
		}
		
		if (empty($product_id)) {
			$product_idError = 'Please select a product';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO transactions (customer_id,product_id) values(?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($customer_id,$product_id));
			Database::disconnect();
			header("Location: transactions.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a transaction</h3>
		    		</div>

	    			<form class="form-horizontal" action="transactionCreate.php" method="post">
					  <div class="control-group <?php echo !empty($customer_idError)?'error':'';?>">
					    <label class="control-label">Customer</label>

                          <div class="controls">
                              <select name="customer_id">
                                  <?php
                                  $pdoCustomer = Database::connect();
                                  $sqlCustomer = 'SELECT * FROM customers';

                                  foreach ($pdoCustomer->query($sqlCustomer) as $rowCustomer) {
                                      echo '<option value="' . $rowCustomer['cid'] . '">' . $rowCustomer['cname']
                                          . '</option>';

                                  }
                                  ?>
                              </select>
					      	<?php if (!empty($customer_idError)): ?>
					      		<span class="help-inline"><?php echo $customer_idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <form class="form-horizontal" action="transactionCreate.php" method="post">
					  <div class="control-group <?php echo !empty($product_idError)?'error':'';?>">
					    <label class="control-label">Product</label>
					    <div class="controls">
                            <select name="product_id">
                                <?php
                                $pdoProduct = Database::connect();
                                $sqlProduct = 'SELECT * FROM products';

                                foreach ($pdoProduct->query($sqlProduct) as $rowProduct) {
                                    echo '<option value="' . $rowProduct['pid'] . '">' . $rowProduct['pname']
                                        . '</option>';

                                }
                                ?>
                            </select>

					      	<?php if (!empty($product_idError)): ?>
					      		<span class="help-inline"><?php echo $product_idError;?></span>
					      	<?php endif; ?>
					    </div>

					  </div>

					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="transactions.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>