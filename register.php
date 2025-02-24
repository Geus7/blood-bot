<?php
// Database connection setup
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "blood_bank"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for registration and CSV upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register_manual'])) {
        // Manual registration
        $name = htmlspecialchars($_POST["name"]);
        $email = trim(strtolower(htmlspecialchars($_POST["email"])));  // Trim and convert email to lowercase
        $blood_type = htmlspecialchars($_POST["blood_type"]);
        $location = htmlspecialchars($_POST["location"]);
        $date_donated = htmlspecialchars($_POST["date_donated"]);

        // Log the email being checked (for debugging purposes)
        error_log("Checking email: $email");

        // Check if the email already exists
        $sql = "SELECT * FROM donors WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            echo "<p class='error-message'>Error: The email '$email' is already registered.</p>";
        } else {
            // Insert the new donor
            $sql = "INSERT INTO donors (name, email, blood_type, location, date_donated) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $email, $blood_type, $location, $date_donated);

            if ($stmt->execute()) {
                echo "<p class='success-message'>Registration Successful! Thank you, $name.</p>";
            } else {
                echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
            }
        }

        $stmt->close();
    }

    // Handle CSV file upload
    elseif (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
        fgetcsv($csvFile); // Skip header row

        $inserted = 0;
        while (($row = fgetcsv($csvFile)) !== false) {
            $name = htmlspecialchars($row[0]);
            $email = trim(strtolower(htmlspecialchars($row[1])));  // Trim and convert email to lowercase
            $blood_type = htmlspecialchars($row[2]);
            $location = htmlspecialchars($row[3]);
            $date_donated = htmlspecialchars($row[4]);

            // Log the email being checked (for debugging purposes)
            error_log("Checking email: $email");

            // Check if the email already exists
            $sql = "SELECT * FROM donors WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Email already exists
                echo "<p class='error-message'>Error: The email '$email' is already registered. Skipping this row.</p>";
            } else {
                // Insert the new donor
                $sql = "INSERT INTO donors (name, email, blood_type, location, date_donated) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $name, $email, $blood_type, $location, $date_donated);

                if ($stmt->execute()) {
                    $inserted++;
                } else {
                    echo "<p class='error-message'>Error inserting row for $name: " . $stmt->error . "</p>";
                }
            }

            $stmt->close();
        }

        fclose($csvFile);
        echo "<p class='success-message'>CSV upload successful! $inserted records added.</p>";
    } else {
        echo "<p class='error-message'>Please upload a CSV file or fill in the manual registration form.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Donor</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* General page layout */
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

        /* Success and error message styles */
        .success-message, .error-message {
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }

        /* Form layout */
        form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin: 0 auto;
        }

        label {
            font-size: 1.2em;
            margin-top: 15px;
            display: block;
            text-align: left;
        }

        input[type="text"], input[type="email"], input[type="date"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Register as a Donor</h1>

        <!-- Registration Form -->
        <form method="post" action="register.php" enctype="multipart/form-data">
            <h2>Register Manually</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="blood_type">Blood Type:</label>
            <input type="text" id="blood_type" name="blood_type" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="date_donated">Date Donated:</label>
            <input type="date" id="date_donated" name="date_donated" required>

            <button type="submit" name="register_manual">Register</button>
        </form>

        <br>

        <h2>Or Upload a CSV File</h2>
        <form method="post" action="register.php" enctype="multipart/form-data">
            <label for="csv_file">Select CSV File:</label>
            <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
            <button type="submit" name="upload_csv">Upload CSV</button>
        </form>

        <a href="index.php" class="back-button">Back to Home</a>
    </div>
</body>
</html>

