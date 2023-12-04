<?php


$servername = "localhost";
$username = "root";
$password = "allen";
$dbname = "school_db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT gender, COUNT(*) as count FROM students WHERE gender IN ('1', '0') GROUP BY gender";
$result = mysqli_query($conn, $query);

$maleCount = 0;
$femaleCount = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['gender'] === '1') {
            $maleCount += $row['count'];
        } elseif ($row['gender'] === '0') {
            $femaleCount += $row['count'];
        }
    }
} else {
    echo "No records found for gender distribution.";
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Gender Distribution Report</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            text-align: center; /* Center text in the card */
        }

        .header h2 {
            margin-bottom: 0; /* Remove default margin to center vertically */
        }
    </style>


</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>


    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Student Gender Distribution Report</h2>
                    <p class="category"></p>
                </div>
    <div class="content">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

<script>
    const data = {
        labels: ['Male','Female'],
        datasets: [{
            label: 'Gender Distribution',
            data: [<?php echo $maleCount; ?>, <?php echo $femaleCount; ?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)', // Blue for Male
                'rgba(255, 99, 132, 0.5)', // Red for Female
            ],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const genderChart = new Chart(
        document.getElementById('genderChart'),
        config
    );
</script>
</body>
</html>