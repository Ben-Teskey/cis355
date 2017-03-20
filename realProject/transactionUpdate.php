<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: transactions.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$customer_idError = null;
		$product_idError = null;
		$timeError = null;
		
		// keep track post values
		$customer_id = $_POST['customer_id'];
		$product_id = $_POST['product_id'];
		$time = $_POST['time'];
		
		// validate input
		$valid = true;
		if (empty($customer_id)) {
			$customer_idError = 'Please enter customer_id';
			$valid = false;
		}
		
		if (empty($product_id)) {
			$product_idError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		if (empty($time)) {
			$timeError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE transactions  set customer_id = ?, product_id = ?, time = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($customer_id, $product_id, $time, $id));
			Database::disconnect();
			header("Location: transactions.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM transactions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$customer_id = $data['customer_id'];
		$product_id = $data['product_id'];
		$time = $data['time'];
		Database::disconnect();
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
		    			<h3>Update a transaction</h3>
		    		</div>
    		
			          <form class="form-horizontal" action="transactionUpdate.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($customer_idError)?'error':'';?>">
					    <label class="control-label">customer_id</label>
					    <div class="controls">
					      	<input name="customer_id" type="text"  placeholder="customer_id" value="<?php echo !empty($customer_id)?$customer_id:'';?>">
					      	<?php if (!empty($customer_idError)): ?>
					      		<span class="help-inline"><?php echo $customer_idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($product_idError)?'error':'';?>">
					    <label class="control-label">product_id</label>
					    <div class="controls">
					      	<input name="product_id" type="text"  placeholder="product_id" value="<?php echo !empty($product_id)?$product_id:'';?>">
					      	<?php if (!empty($product_idError)): ?>
					      		<span class="help-inline"><?php echo $product_idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
					    <label class="control-label">time</label>
					    <div class="controls">
					      	<input name="time" type="text"  placeholder="time" value="<?php echo !empty($time)?$time:'';?>">
					      	<?php if (!empty($timeError)): ?>
					      		<span class="help-inline"><?php echo $timeError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="transactions.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>