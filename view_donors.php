<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>View Donors</title>
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
            width: 80%; /* Smaller table width */
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 8px 15px; /* Reduced padding for a more compact look */
            border: 1px solid #ddd;
            font-size: 1em; /* Smaller font size */
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
</head>
<body>
    <div class="container">
        <h1>Registered Donors</h1>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root"; // Your MySQL username
        $password = ""; // Your MySQL password
        $dbname = "blood_bank";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle deletion if delete form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['email'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];

            // Prepare the delete statement based on name and email
            $delete_sql = "DELETE FROM donors WHERE name = ? AND email = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("ss", $name, $email);

            if ($stmt->execute()) {
                $message = "Donor deleted successfully.";
            } else {
                $message = "Error deleting donor: " . $stmt->error;
            }

            $stmt->close();

            // Redirect to refresh the page and display the message
            header("Location: view_donors.php?message=" . urlencode($message));
            exit;
        }

        // Display success or error message if present
        if (isset($_GET['message'])) {
            $message = htmlspecialchars($_GET['message']);
            if (strpos($message, 'Error') !== false) {
                echo "<p class='error-message'>$message</p>";
            } else {
                echo "<p class='success-message'>$message</p>";
            }
        }

        // Query to get donors
        $sql = "SELECT * FROM donors";
        $result = $conn->query($sql);
        ?>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Blood Type</th>
                    <th>Location</th>
                    <th>Date Donated</th>
                    <th>Action</th> <!-- Action column for delete button -->
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php 
                    $donors = $result->fetch_all(MYSQLI_ASSOC); // Store all donors in an array for later use
                    foreach ($donors as $index => $donor): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td> <!-- Serial number based on the loop index -->
                            <td><?php echo htmlspecialchars($donor['name']); ?></td>
                            <td><?php echo htmlspecialchars($donor['email']); ?></td>
                            <td><?php echo htmlspecialchars($donor['blood_type']); ?></td>
                            <td><?php echo htmlspecialchars($donor['location']); ?></td>
                            <td><?php echo htmlspecialchars($donor['date_donated']); ?></td>
                            <td>
                                <!-- Inline delete form for each donor -->
                                <form method="post" action="view_donors.php" style="display:inline;">
                                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($donor['name']); ?>"> <!-- Using name -->
                                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($donor['email']); ?>"> <!-- Using email -->
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this donor?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No donors registered.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a class="back-button" href="index.php">Go Back</a>

        <?php $conn->close(); ?>
    </div>
</body>
</html>

