<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php"); // Include the Student class file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student data by ID from the database
    $db = new Database();
    $student = new Student($db);
    $studentData = $student->read($id); // Implement the read method in the Student class

    if ($studentData) {
        // The student data is retrieved, and you can pre-fill the edit form with this data.
    } else {
        echo "Student not found.";
    }
} else {
    echo "Student ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'student_number' => $_POST['student_number'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birthday'],
    ];

    $db = new Database();
    $student = new Student($db);

    // Call the edit method to update the student data
    if ($student->update($id, $data)) {
        echo "Record updated successfully.";
        header("Location: students.view.php");
        exit; // Add exit to stop further execution
    } else {
        echo "Failed to update the record.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit Student</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit Student Information</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $studentData['id']; ?>">
        
        <label for="student_number">Student Number:</label>
        <input type="text" name="student_number" id="student_number" value="<?php echo isset($studentData['student_number']) ? $studentData['student_number'] : ''; ?>">
        
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo isset($studentData['first_name']) ? $studentData['first_name'] : ''; ?>">


        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" id="middle_name" value="<?php echo isset($studentData['middle_name']) ? $studentData['middle_name'] : ''; ?>">
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo isset($studentData['last_name']) ? $studentData['last_name'] : ''; ?>">

        
        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="0">Male</option>
            <option value="1">Female</option>
        </select>
        
        <label for="birthday">Birthdate:</label>
        <input type="date" name="birthday" id="birthday" required value="<?php echo date('Y-m-d'); ?>">
        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>