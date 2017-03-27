<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	$data = null;
	if ( null==$id ) {
		header("Location: transactions.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT cname, pname, time ";
		$sql .= "FROM transactions ";
		$sql .= "INNER JOIN customers ON cid = customer_id ";
		$sql .= "INNER JOIN products ON pid = product_id ";
		$sql .= "WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
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
		    			<h3>Read a transaction</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Customer</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['cname'];?>
						    </label>
					    </div>
					  </div>
					 </div>
					<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Product</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['pname'];?>
						    </label>
					    </div>
					  </div>
					  <div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Time</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['time'];?>
						    </label>
					    </div>
					  </div>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="transactions.php">Back</a>
					   </div>
					
					 
					
				</div>
    </div> <!-- /container -->
  </body>
</html>