<?php
include_once("../db.php");
include_once("../province.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $db = new Database();
    $province = new Province($db);
    $province_data = $province->read($id);

    if ($province_data) {
        // Fetch the province data and assign it to variables
        $province_id = $province_data['id'];
        $province_name = $province_data['name'];
    } else {
        echo "Province not found.";
    }
} else {
    echo "Province ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
    ];

    $db = new Database();
    $province = new Province($db);

    if ($province->update($data['id'], $data)) {
        echo "Record updated successfully.";
        header('location: province.view.php');
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
    <title>Edit Province</title>
</head>
<body>
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
        <h2>Edit Province Information</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $province_id; ?>">
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $province_name; ?>">
            
            <input type="submit" value="Update">
        </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
