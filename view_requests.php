<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'C:/xamp/htdocs/Blood_System_IDBMS/config.php';

// Check if a delete request has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['blood_type']) && isset($_POST['request_date'])) {
    $blood_type = $_POST['blood_type'];
    $request_date = $_POST['request_date'];
    try {
        // Prepare and execute delete query based on blood_type and request_date
        $stmt = $pdo->prepare("DELETE FROM requests WHERE blood_type = :blood_type AND request_date = :request_date");
        $stmt->execute(['blood_type' => $blood_type, 'request_date' => $request_date]);
        
        // Redirect with a success message
        header("Location: view_requests.php?message=Request+deleted+successfully");
        exit;
    } catch (PDOException $e) {
        $error_message = "Error deleting request: " . $e->getMessage();
    }
}

try {
    // Fetch all requests to display
    $stmt = $pdo->query("SELECT * FROM requests");
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching requests: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    <title>View Requests</title>
</head>
<body>
    <div class="container">
        <h1>Blood Requests</h1>

        <!-- Display success or error message -->
        <?php if (isset($_GET['message'])): ?>
            <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>#</th> <!-- Dynamic row number -->
                    <th>Blood Type</th>
                    <th>Location</th>
                    <th>Quantity</th>
                    <th>Request Date</th>
                    <th>Action</th> <!-- Action column for delete button -->
                </tr>
            </thead>
            <tbody>
                <?php if (empty($requests)): ?>
                    <tr>
                        <td colspan="6">No requests made.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($requests as $index => $request): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td> <!-- Sequential numbering -->
                            <td><?php echo htmlspecialchars($request['blood_type']); ?></td>
                            <td><?php echo htmlspecialchars($request['location']); ?></td>
                            <td><?php echo htmlspecialchars($request['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($request['request_date']); ?></td>
                            <td>
                                <!-- Inline delete form for each request based on blood_type and request_date -->
                                <form method="post" action="view_requests.php" style="display:inline;">
                                    <input type="hidden" name="blood_type" value="<?php echo htmlspecialchars($request['blood_type']); ?>">
                                    <input type="hidden" name="request_date" value="<?php echo htmlspecialchars($request['request_date']); ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this request?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <a class="back-button" href="index.php">Go Back</a>
    </div>
</body>
</html>
