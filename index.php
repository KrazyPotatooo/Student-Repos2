<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php
    include_once("db.php");
    include_once("student.php");

    $db = new Database();
    $connection = $db->getConnection();
    $student = new Student($db);
    ?>
    <!-- Include the header -->
    <?php include('templates/header.html'); ?>
    <?php include('includes/navbar.php'); ?>


<div class="content">
    <!-- Include the footer -->
    <?php include('templates/footer.html'); ?>
    </div>
</body>
</html>
