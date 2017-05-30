<?php

class TransactionClass
{

    public static function getTransactions($search)
    {
        include 'database.php';
        echo '<tbody>';
        $pdo = Database::connect();
        $sql = 'SELECT pname, cname, id, `time` FROM transactions';
        $sql .= ' INNER JOIN products ON pid = product_id';
        $sql .= ' INNER JOIN customers ON cid = customer_id';

        // Break up search string into an array of keywords. Using regular expression found on
        // stack overflow to eliminate any and all white space in-between
        $search = preg_split('/\s+/', $search);

        // Now we will assemble the where clause of our query based on the key words entered
        for ($i = 0; $i < sizeof($search); $i++) {

            // We include the where clause if there is at least one search parameter,
            // but due to SQL query structure, we obviously don't include it for every parameter
            if ($i == 0) $sql .= " WHERE (cname LIKE :search$i OR pname LIKE :search$i)";
            else $sql .= " AND (cname LIKE :search$i OR pname LIKE :search$i)";

        }

        // Prepare the statement
        $result = $pdo->prepare($sql);

        // Bind our keyword variables to the search parameters we added to our SQL code
        for ($i = 0; $i < sizeof($search); $i++) $result->bindValue(":search$i", "%$search[$i]%");

        // Execute the query
        $result->execute();

        // Return the table header
        echo '<thead><tr><th>Customer</th><th>Product</th><th>Time</th><th>Action</th></tr></thead>';

        // Fetch and return the results
        echo '<tbody>';
        foreach ($result->fetchAll() as $row) {

            echo '<tr>';
            echo '<td>' . $row['cname'] . '</td>';
            echo '<td>' . $row['pname'] . '</td>';
            echo '<td>' . $row['time'] . '</td>';
            echo '<td width=250>';
            echo '<a class="btn btn-default" href="transactionRead.html?id=' . $row['id'] . '">Read</a>';
            echo '&nbsp;';
            echo '<a class="btn btn-success" href="transactionUpdate.html?id=' . $row['id'] . '">Update</a>';
            echo '&nbsp;';
            echo '<a class="btn btn-danger" href="transactionDelete.html?id=' . $row['id'] . '">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        Database::disconnect();

    }
	
	public static function getTime($id) {
		include 'database.php';
		$pdo = Database::connect();
		$sql = "SELECT time FROM transactions WHERE id = ?";
		$result = $pdo->prepare($sql);
		$result->execute(array($id));
		
		$row = $result->fetch();
		
		echo '<input id="timeInputBox" name="time" type="text"  placeholder="time" value="' . $row['time'] . '">';
	}

    public static function getCustomer($id) {
        include 'database.php';
        $pdo = Database::connect();
        $sql = "SELECT cname FROM transactions ";
        $sql .= " INNER JOIN customers ON cid = customer_id";
        $sql .= " WHERE id = ?";

        $result = $pdo->prepare($sql);

        $result->execute(array($id));

        $row = $result->fetch();
        echo $row['cname'];
        Database::disconnect();
    }

    public static function getProduct($id) {
        include 'database.php';
        $pdo = Database::connect();
        $sql = "SELECT pname FROM transactions ";
        $sql .= " INNER JOIN products ON pid = product_id";
        $sql .= " WHERE id = ?";

        $result = $pdo->prepare($sql);

        $result->execute(array($id));

        $row = $result->fetch();
        echo $row['pname'];
        Database::disconnect();
    }

	public static function getTimeLabel($id) {
        include 'database.php';
        $pdo = Database::connect();
        $sql = "SELECT time FROM transactions WHERE id = ?";

        $result = $pdo->prepare($sql);

        $result->execute(array($id));

        $row = $result->fetch();
        echo $row['time'];
        Database::disconnect();
    }
	
	public static function updateTransaction($id, $customer_id, $product_id, $time) {
        include 'database.php';
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE transactions  set customer_id = ?, product_id = ?, time = ? WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($customer_id, $product_id, $time, $id));
		Database::disconnect();
		
	}

    public static function insertTransaction($customer_id, $product_id) {
        include 'database.php';
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO transactions (customer_id,product_id) values(?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($customer_id,$product_id));
        Database::disconnect();

    }

    public static function getCustomerOptions($customer_id) {
        $pdoCustomer = Database::connect();
        $sqlCustomer = 'SELECT * FROM customers';

        foreach ($pdoCustomer->query($sqlCustomer) as $rowCustomer) {
            if ($customer_id == $rowCustomer['cid']) echo '<option selected="selected" value="' 
			. $rowCustomer['cid'] . '">' . $rowCustomer['cname'] . '</option>';
			else echo '<option value="' . $rowCustomer['cid'] . '">' . $rowCustomer['cname']
                . '</option>';

        }
		Database::disconnect();
    }

    public static function getProductOptions($product_id) {
        $pdoProduct = Database::connect();
        $sqlProduct = 'SELECT * FROM products';

        foreach ($pdoProduct->query($sqlProduct) as $rowProduct) {
			if ($product_id == $rowProduct['pid']) echo '<option selected="selected" value="' . $rowProduct['pid'] . '">' 
			. $rowProduct['pname'] . '</option>';
			else echo '<option value="' . $rowProduct['pid'] . '">' . $rowProduct['pname']
                . '</option>';

        }
		Database::disconnect();
    }

    public static function deleteTransaction($id) {
        require 'database.php';

        $pdo = Database::connect();
        $sql = "DELETE FROM transactions  WHERE id = ?";
        $result = $pdo->prepare($sql);
        $result->execute(array($id));
        Database::disconnect();
    }

    public static function getDeleteConfirm($id) {
        include 'database.php';

        $pdo = Database::connect();
        $sql = "SELECT cname, pname FROM transactions";
        $sql .= " INNER JOIN customers ON customer_id = cid";
        $sql .= " INNER JOIN products ON product_id = pid";
        $sql .= " WHERE id = ?";

        $result = $pdo->prepare($sql);
        $result->execute(array($id));
        $row = $result->fetch();

        echo 'Delete ' . $row['cname'] . '\'s purchase of ' . $row['pname'] . '?';

    }

}