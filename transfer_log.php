<?php

include 'partials/_dbconnect.php';

// Initialize variables for date filtering
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Build the SQL query based on date filter input
$sql = "SELECT * FROM transactions";
if (!empty($startDate) && !empty($endDate)) {
    $sql .= " WHERE transfer_date BETWEEN '$startDate' AND '$endDate'";
}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/table.css">
    <title>TRANSACTION LOG</title>
    <style>
        /* index.css */
        button {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php include 'partials/_navbar.php' ?>

    <div class="cover"></div>

    <h1>TRANSACTION &nbsp; LOG</h1>
    <div class="filter-form">
        <form method="POST" action="">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $startDate; ?>" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $endDate; ?>" required>
            <button type="submit">Filter</button>
        </form>
    </div>
    <div class="all_users" style="height: 500px;">
        <table>
            <tr>
                <th>ID</th>
                <th>SENDER</th>
                <th>RECEIVER</th>
                <th>AMOUNT</th>
                <th>DATE & TIME</th>
            </tr>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = isset($row['id']) ? $row['id'] : '';
                    $sender = isset($row['sender_id']) ? $row['sender_id'] : '';
                    $receiver = isset($row['receiver_id']) ? $row['receiver_id'] : '';
                    $amount = isset($row['amount']) ? $row['amount'] : '';
                    $time = isset($row['transfer_date']) ? $row['transfer_date'] : '';
                    echo "
                    <tr>
                        <td>$id</td>
                        <td>$sender</td>
                        <td>$receiver</td>
                        <td>$amount</td>
                        <td>$time</td>
                    </tr>
                    ";
                }
            } else {
                echo "<tr><td colspan='5'>No transactions found</td></tr>";
            }
            ?>
        </table>
    </div>
    <button onclick="window.print()">Print Logs</button>

    <?php include 'partials/_footer.php' ?>
    <!-- script -->
    <script src="js/navscroll.js"></script>
</body>

</html>
