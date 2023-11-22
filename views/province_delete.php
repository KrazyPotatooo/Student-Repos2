<?php
include_once("../db.php"); // Include the Database class file
include_once("../province.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the 'id' from the URL
    
    $db = new Database();
    $province = new Province($db);

    // Call the delete method to delete the town city record
    if ($province->delete($id)) {
        echo "Record deleted successfully.";
        header("Location: /views/province.view.php");
    } else {
        echo "Failed to delete the record.";
    }
}
?>
