<?php
include 'C:/xamp/htdocs/Blood_System_IDBMS/config.php';

// Fetch all donation records from the donations table
$stmt = $pdo->query("SELECT * FROM donations ORDER BY donation_date DESC");
$donations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Donations</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            margin-top: 60px;
            text-align: center;
        }
        h1 {
            font-size: 3em;
            color: #9B1B30;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 8px 15px;
            border: 1px solid #ddd;
            font-size: 1em;
        }
        th {
            background-color: #5bc0de;
            color: white;
        }
        td {
            background-color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-button {
            font-size: 1.2em;
            padding: 10px 20px;
            color: white;
            background-color: #5bc0de;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #31b0d5;
        }
        button {
            font-size: 1em;
            padding: 8px 16px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #d32f2f;
        }
        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
<body>
    <div class="container">
        <h1>All Donations</h1>

        <?php if (count($donations) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Location</th>
                        <th>Quantity (in liters)</th>
                        <th>Donation Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donations as $donation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($donation['blood_type']); ?></td>
                            <td><?php echo htmlspecialchars($donation['location']); ?></td>
                            <td><?php echo number_format((float)$donation['quantity'], 2, '.', ''); ?></td>
                            <td><?php echo htmlspecialchars($donation['donation_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No donations recorded yet.</p>
        <?php endif; ?>

        <a href="index.php" class="btn btn-primary">Go Back</a>
    </div>
</body>
</html>

