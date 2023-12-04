<?php
$servername = "localhost";
$username = "root";
$password = "allen";
$dbname = "school_db1";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$queryProvinces = "SELECT province.name AS province_name, COUNT(students.id) AS student_count 
FROM students 
JOIN student_details ON students.id = student_details.student_id
JOIN province ON student_details.province = province.id 
GROUP BY student_details.province
ORDER BY student_count DESC";

$resultProvinces = mysqli_query($conn, $queryProvinces);

$provinceCounts = [];
$provinceNames = [];

if ($resultProvinces && mysqli_num_rows($resultProvinces) > 0) {
    while ($row = mysqli_fetch_assoc($resultProvinces)) {
        $provinceCounts[] = $row['student_count'];
        $provinceNames[] = $row['province_name'];
    }
} else {
    echo "No records found for province distribution.";
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Database Report</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
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


    <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="header">
                        <h2>Student Per Province</h2>
                        <p class="category">Province</p>
                    </div>
                    <div class="content">
                        <canvas id="myChartProvince"></canvas>
                        <script>
                            const provinceCountsData = <?php echo json_encode($provinceCounts); ?>;
                            const provinceNamesData = <?php echo json_encode($provinceNames); ?>;
                            const dataProvince = {
                                labels: provinceNamesData,
                                datasets: [{
                                    label: 'Student Count',
                                    data: provinceCountsData,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.7)',
                                        'rgba(54, 162, 235, 0.7)',
                                        'rgba(255, 205, 86, 0.7)',
                                        'rgba(75, 192, 192, 0.7)',
                                        'rgba(153, 102, 255, 0.7)',
                                        'rgba(255, 159, 64, 0.7)',
                                        'rgba(255, 0, 0, 0.7)',
                                        'rgba(0, 255, 0, 0.7)',
                                        'rgba(0, 0, 255, 0.7)',
                                        'rgba(128, 0, 128, 0.7)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 205, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 0, 0, 1)',
                                        'rgba(0, 255, 0, 1)',
                                        'rgba(0, 0, 255, 1)',
                                        'rgba(128, 0, 128, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            };

                            const configProvince = {
                                type: 'bar',
                                data: dataProvince,
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            };

                            const myChartProvince = new Chart(document.getElementById('myChartProvince'), configProvince);
                        </script>
                    </div>
                    <hr>
                    <div class="stats">
                        <i class="fa fa-history"></i> Updated 3 minutes ago
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>