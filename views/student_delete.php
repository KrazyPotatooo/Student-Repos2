<?php
// Include necessary files
include_once("../db.php");
include_once("../student.php");
include_once("../student_details.php");

// Function to delete student and related details
function deleteStudentAndDetails($student, $studentDetails, $id) {
    try {
        $studentDeleted = $student->delete($id);
        $studentDetailsDeleted = $studentDetails->delete($id);

        if ($studentDeleted && $studentDetailsDeleted) {
            return true; // Deletion successful from both tables
        } else {
            return false; // Deletion failed from one or both tables
        }
    } catch (Exception $e) {
        // Log or handle the exception
        error_log("Deletion error: " . $e->getMessage());
        return false;
    }
}

// Main logic
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the 'id' from the URL

    // Instantiate the Database
    $db = new Database();

    // Instantiate the Student and StudentDetails classes
    $student = new Student($db);
    $studentDetails = new StudentDetails($db);

    // Delete student and related details
    $deletionResult = deleteStudentAndDetails($student, $studentDetails, $id);

    // Output result
    if ($deletionResult) {
        echo "Record deleted successfully from both tables.";
    } else {
        echo "Failed to delete the record from one or both tables.";
    }
}
?>
