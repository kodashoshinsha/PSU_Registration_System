<?php
include 'connection.php';

// Get the SQL query from the query string parameter
$query = $_GET['query'];

// Execute the query and fetch the results
$result = $con->query($query);

// Fetch the results into an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the database connection
$con->close();

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
