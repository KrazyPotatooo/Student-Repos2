<?php
$servername = "localhost";
$username = "root";
$password = "allen";
$dbname = "school_db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query04 = "SELECT birthday, COUNT(gender) as order_count FROM students GROUP BY birthday,gender limit 20";
$result04 = mysqli_query($conn, $query04);

if (mysqli_num_rows($result04) > 0) {
    $order_count = array();
    $label_barchart = array();

    while ($row = mysqli_fetch_array($result04)) {
        $order_count[] = $row['order_count'];
        $label_barchart[] = $row['birthday'];
    }

    mysqli_free_result($result04);
} else {
    echo "No records matching your query were found.";
}

$querySalesByCategory = "SELECT province.name, COUNT(gender) as TotalSales FROM province JOIN students ON province.id = students.id GROUP BY province.name, students.gender";
$resultSalesByCategory = mysqli_query($conn, $querySalesByCategory);

if (mysqli_num_rows($resultSalesByCategory) > 0) {
    $categoryNames = array();
    $totalSales = array();

    while ($row = mysqli_fetch_array($resultSalesByCategory)) {
        $categoryNames[] = $row['name']; // Fix: use 'name' instead of 'CategoryName'
        $totalSales[] = $row['TotalSales'];
    }

    mysqli_free_result($resultSalesByCategory);
} else {
    echo "No records matching your query were found.";
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
                <div class="card text-center"> <!-- Fix: Remove the equal sign in the class attribute -->
                    <div class="header">
                        <h4 class="title">Gender Counts per Province</h4>
                        <p class="category"></p>
                    </div>
                    <div class="content">
                        <canvas id="chartSalesByCategory"></canvas>
                        <script>
                            const categoryNames = <?php echo json_encode($categoryNames); ?>;
                            const totalSales = <?php echo json_encode($totalSales); ?>;
                            const dataSalesByCategory = {
                                labels: categoryNames,
                                datasets: [{
                                    label: 'Gender Count Per Province',
                                    data: totalSales,
                                    backgroundColor: 'rgba(0, 128, 128, 0.8)',
                                    borderColor: 'rgba(0, 128, 128, 1)',
                                    borderWidth: 1
                                }]
                            };

                            const configSalesByCategory = {
                                type: 'bar',
                                data: dataSalesByCategory,
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: function (value, index, values) {
                                                    return value;
                                                }
                                            }
                                        }
                                    }
                                }
                            };

                            const chartSalesByCategory = new Chart(document.getElementById('chartSalesByCategory'), configSalesByCategory);
                        </script>

                        <hr>
                        <div class="stats">
                            <i class="fa fa-history"></i> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
