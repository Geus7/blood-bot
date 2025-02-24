<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Blood Demand Prediction</title>
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
            font-size: 3.5em; /* Increased font size */
            color: #9B1B30;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
      
        label {
            font-size: 1.2em;
            margin-top: 15px;
            display: block;
            text-align: left;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1.1em;
            margin-bottom: 20px;
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
        .form-group {
            margin-bottom: 30px;
        }
        .back-button {
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            padding: 12px;
            border-radius: 8px;
        }
        .back-button:hover {
            background-color: #218838;
        }
        .form-container {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Predict Blood Demand</h1>

        <?php
        // Enable error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if the CSV file is uploaded
            if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
                // Get the uploaded file path
                $csvFilePath = $_FILES['csv_file']['tmp_name'];

                // Get form inputs
                $location = htmlspecialchars($_POST['location']);
                $bloodType = htmlspecialchars($_POST['blood_type']);
                $month = htmlspecialchars($_POST['month']);
                $year = htmlspecialchars($_POST['year']);

                // Command to run the Python script
                $command = escapeshellcmd("python C:\\xamp\\htdocs\\Blood_System_IDBMS\\predict_demand.py $csvFilePath $location $bloodType $month $year");
                $output = shell_exec($command);

                // Display the output
                echo "<pre class='alert alert-info'>$output</pre>";
            } else {
                echo "<p class='alert alert-danger'>Error uploading the CSV file.</p>";
            }
        }
        ?>

        <form method="post" action="predict_demand.php" enctype="multipart/form-data">
            <div class="form-container">
                <h2>Upload CSV File</h2>
                <div class="form-group">
                    <label for="csv_file">CSV File:</label>
                    <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
                </div>

                <h2>Prediction Inputs</h2>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required>
                </div>

                <div class="form-group">
                    <label for="blood_type">Blood Type:</label>
                    <input type="text" id="blood_type" name="blood_type" required>
                </div>

                <div class="form-group">
                    <label for="month">Month:</label>
                    <input type="number" id="month" name="month" min="1" max="12" required>
                </div>

                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year" required>
                </div>

                <button type="submit">Submit</button>
            </div>
        </form>

        <!-- Go Back Button -->
        <a class="back-button" href="index.php">Go Back</a>
    </div>
</body>
</html>

