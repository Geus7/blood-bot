<?php
session_start(); // Start the session to store success or error messages

// Include the database configuration file
include 'C:/xamp/htdocs/Blood_System_IDBMS/config.php';

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process CSV upload if 'Upload CSV' button was clicked and a file is uploaded
    if (isset($_POST['submit_csv']) && isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {
        // Open and read the CSV file
        $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
        fgetcsv($csvFile); // Skip the header row

        $inserted = 0;
        $errors = 0;
        while (($row = fgetcsv($csvFile)) !== false) {
            $blood_type = htmlspecialchars($row[0]);
            $location = htmlspecialchars($row[1]);
            $quantity = (int)$row[2];
            $request_date = htmlspecialchars($row[3]);

            // Prepare and execute the insert statement for each row in CSV
            $stmt = $pdo->prepare("INSERT INTO requests (blood_type, location, quantity, request_date) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$blood_type, $location, $quantity, $request_date])) {
                $inserted++;
            } else {
                $errors++;
            }
        }
        fclose($csvFile);

        // Set success/error messages in session
        $_SESSION['csv_success'] = "CSV upload successful! $inserted requests added.";
        if ($errors > 0) {
            $_SESSION['csv_error'] = "$errors rows failed to insert.";
        }
    }

    // Process manual form input if 'Submit Request' button was clicked
    elseif (isset($_POST['submit_manual'])) {
        // Capture form data
        $blood_type = $_POST['blood_type'];
        $location = $_POST['location'];
        $quantity = $_POST['quantity'];
        $request_date = $_POST['request_date'];

        // Prepare and execute the insert statement for manual input
        $stmt = $pdo->prepare("INSERT INTO requests (blood_type, location, quantity, request_date) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$blood_type, $location, $quantity, $request_date])) {
            // Set success message for manual form submission
            $_SESSION['manual_success'] = "Blood request submitted successfully.";
        } else {
            // Set error message for manual form submission
            $_SESSION['manual_error'] = "Error submitting request.";
        }
    }

    // Redirect to the same page to avoid resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        h1 {
            font-size: 3.5em;
            color: #9B1B30;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 15px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 1.1em;
            font-weight: 500;
            color: #333;
        }
        input, button {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1.1em;
        }
        input[type="text"], input[type="number"], input[type="date"], input[type="file"] {
            width: 100%;
        }
        button {
            font-size: 1em;
            padding: 10px 20px;
            background-color: #5bc0de;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #31b0d5;
        }
        .back-button {
            margin-top: 20px;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            display: block;
        }
        .back-button:hover {
            background-color: #218838;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success {
            background-color: #28a745;
            color: white;
        }
        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Request Blood</h1>

        <!-- Display session-based success or error messages -->
        <?php if (isset($_SESSION['csv_success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['csv_success']; ?></div>
            <?php unset($_SESSION['csv_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['csv_error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['csv_error']; ?></div>
            <?php unset($_SESSION['csv_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['manual_success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['manual_success']; ?></div>
            <?php unset($_SESSION['manual_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['manual_error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['manual_error']; ?></div>
            <?php unset($_SESSION['manual_error']); ?>
        <?php endif; ?>

        <!-- Manual Entry Form -->
        <form method="post" enctype="multipart/form-data">
            <h2>Submit a Blood Request Manually</h2>
            <label for="blood_type">Blood Type:</label>
            <input type="text" id="blood_type" name="blood_type" required>
            
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            
            <label for="quantity">Quantity (in liters):</label>
            <input type="number" id="quantity" name="quantity" required>
            
            <label for="request_date">Request Date:</label>
            <input type="date" id="request_date" name="request_date" required>
            
            <button type="submit" name="submit_manual">Submit Request</button>
        </form>
<br></br>
        <!-- CSV Upload Form -->
        <form method="post" enctype="multipart/form-data">
            <h2>Or Upload a CSV File</h2>
            <label for="csv_file">CSV File:</label>
            <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
            
            <button type="submit" name="submit_csv">Upload CSV</button>
        </form>

        <!-- Go Back Button -->
        <a class="back-button" href="index.php">Go Back</a>
    </div>
</body>
</html>

