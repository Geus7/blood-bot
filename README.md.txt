Blood Bot - Blood Bank Management System

Overview

Blood Bot is a Blood Bank Management System that allows users to:

Register as blood donors

Request blood units

View donor and request lists

Predict blood demand using machine learning

Features

PHP & MySQL Backend for managing blood donors and requests

Machine Learning Model to predict blood demand

Bootstrap UI for a modern, responsive design

Installation & Setup

Prerequisites

Ensure you have the following installed:

XAMPP (or any local PHP server)

PHP 7.4+

MySQL Database

Python 3.x

Required Python Libraries (see below)

Steps to Run Locally

1. Clone the Repository

git clone <repository-url>
cd blood-bot

2. Move Files to Server Directory

Place the project folder inside htdocs (for XAMPP) or www (for WAMP):

C:\xampp\htdocs\blood-bot

3. Setup Database

Start Apache and MySQL in XAMPP.

Open phpMyAdmin at http://localhost/phpmyadmin/.

Create a database named blood_bank.

Import the blood_bank_database.sql file into blood_bank.

4. Configure Database Connection

Edit config.php with correct database details:

$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "blood_bank";

5. Install Python Dependencies

Run the following command to install required libraries:

pip install pandas numpy scikit-learn joblib

6. Train the Machine Learning Model (Optional)

To train the blood demand prediction model:

python predict_demand.py blood_demand_data.csv

7. Start the Server

Start your local PHP server:

php -S localhost:8000

Now visit http://localhost:8000/index.php in your browser.

File Structure

project-folder/
│-- blood_bank_database.sql   # MySQL Database Schema
│-- config.php                # Database Configuration
│-- index.php                 # Homepage
│-- register.php              # Donor Registration
│-- donate.php                # Donation Page
│-- request.php               # Request Blood Page
│-- view_donors.php           # View Donors List
│-- view_requests.php         # View Requests
│-- predict_demand.php        # PHP script for ML integration
│-- predict_demand.py         # Python ML Model
│-- datasets/                 # CSV files for training model
│   │-- blood_demand_data.csv
│   │-- donor_data.csv
│   │-- blood_request.csv

Usage

Register as a donor via register.php

Donate or Request blood from donate.php & request.php

View Donors & Requests from view_donors.php & view_requests.php

Predict future blood demand using predict_demand.php

Contributing

Feel free to submit issues or pull requests to improve the system!

License

This project is open-source and available under the MIT License.

