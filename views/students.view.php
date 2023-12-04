<?php
include_once("../db.php");
include_once("../student.php");
include_once("../student_details.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);
$studentDetails  = new StudentDetails($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Student Records</h2>
    <a class="button-link" href="student_add.php">Add New Record</a>
    <table class="orange-theme">
    <thead>
        <tr>
            <th>Student Number</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Contact Number</th>
            <th>Street</th>
            <th>Zip Code</th>
            <th>Town City</th>
            <th>Province</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- You'll need to dynamically generate these rows with data from your database -->
        <?php
        $results = $student->displayAll();
        foreach ($results as $output) {
        $results = $studentDetails->displayAll();
        foreach ($results as $result) {
        ?>
                <tr>
                    <td><?php echo $output['student_number']; ?></td>
                    <td><?php echo $output['first_name']; ?></td>
                    <td><?php echo $output['middle_name']; ?></td>
                    <td><?php echo $output['last_name']; ?></td>
                    <td><?php echo $output['gender']; ?></td>
                    <td><?php echo $output['birthday']; ?></td>
                    <td><?php echo $result['contact_number']; ?></td>
                    <td><?php echo $result['street']; ?></td>
                    <td><?php echo $result['zip_code']; ?></td>
                    <td><?php echo $result['town_city']; ?></td>
                    <td><?php echo $result['province']; ?></td>
                    <td>
                        <a href="student_edit.php?id=<?php echo $output['id']; ?>">Edit</a>
                        |
                        <a href="student_delete.php?id=<?php echo $output['id']; ?>">Delete</a>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>

        
        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>