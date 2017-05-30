<?php
include 'database.php';
$pdo = Database::connect();

if (isset($_GET['search'])) $search = preg_split('/\s+/', $_GET['search']);
else $search = null;

$sql = "SELECT cname, pname, `time` FROM transactions";
$sql .= " INNER JOIN customers ON cid = customer_id";
$sql .= " INNER JOIN products ON pid = product_id";

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

$result->execute();

$rows = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
Database::disconnect();