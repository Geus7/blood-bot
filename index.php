<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bot - Blood Bank Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding-bottom: 50px;
        }
        .container {
            margin-top: 60px;
            text-align: center;
        }
        h1 {
            font-size: 3.5em;
            color: #9B1B30;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        p {
            font-size: 1.4em;
            color: #555;
            margin-bottom: 40px;
        }
        nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            margin-bottom: 40px;
        }
        .btn-primary {
            font-size: 1.4em;
            padding: 15px 30px;
            color: #fff;
            background-color: #f44336;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #d32f2f;
            transform: scale(1.05);
        }
        .card {
            width: 20rem;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .card-img-top {
            height: 200px; /* Uniform height */
            object-fit: cover; /* Ensures the image maintains aspect ratio */
            width: 100%;
        }
        .card-title {
            font-size: 1.5em;
            color: #9B1B30;
        }
        .card-text {
            font-size: 1.2em;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Blood Bot</h1>
        <p>Your trusted Blood Bank Management System</p>
        
        <nav>
            <a href="view_donors.php" class="btn btn-primary">View Donors</a>
            <a href="view_requests.php" class="btn btn-primary">View Requests</a>
            <a href="predict_demand.php" class="btn btn-primary">Predict Blood Demand</a>
            <a href="view_donations.php" class="btn btn-primary">View All Donations</a>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <img src="images/register_donor.jpg" class="card-img-top" alt="Register as Donor">
                    <div class="card-body">
                        <h5 class="card-title">Register as Donor</h5>
                        <p class="card-text">Join our community of life-savers by registering as a donor.</p>
                        <a href="register.php" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <img src="images/donate_blood.jpg" class="card-img-top" alt="Donate Blood">
                    <div class="card-body">
                        <h5 class="card-title">Donate Blood</h5>
                        <p class="card-text">Find out how you can donate blood to save lives.</p>
                        <a href="donate.php" class="btn btn-primary">Donate</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <img src="images/request_blood.jpg" class="card-img-top" alt="Request Blood">
                    <div class="card-body">
                        <h5 class="card-title">Request Blood</h5>
                        <p class="card-text">Request blood units urgently and connect with donors.</p>
                        <a href="request.php" class="btn btn-primary">Request</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
