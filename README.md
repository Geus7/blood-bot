# Blood Bot - Blood Bank Management System

## Overview
Blood Bot is a Blood Bank Management System that allows users to:
- Register as blood donors
- Request blood units
- View donor and request lists
- Predict blood demand using machine learning

## Features
- **PHP & MySQL Backend** for managing blood donors and requests
- **Machine Learning Model** to predict blood demand
- **Bootstrap UI** for a modern, responsive design

## Installation & Setup

### Prerequisites
Ensure you have the following installed:
- [XAMPP](https://www.apachefriends.org/download.html) (or any local PHP server)
- PHP 7.4+
- MySQL Database
- Python 3.x
- Required Python Libraries (see below)

### Steps to Run Locally

#### 1. Clone the Repository
```
sh
git clone <repository-url>
cd blood-bot
```

#### 2. Move Files to Server Directory

```
C:\xampp\htdocs\blood-bot
```

#### 3.Setup Database

- Start Apache and MySQL in XAMPP.
- Open phpMyAdmin at http://localhost/phpmyadmin/.
- Create a database named blood_bank.
- Import the blood_bank_database.sql file into blood_bank.

#### 4.Configure Database Connection

```
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "blood_bank";
```

#### 5. Install Python Dependencies

```
pip install pandas numpy scikit-learn joblib
```

#### 6. Train the Machine Learning Model (Optional)

```
python predict_demand.py blood_demand_data.csv
```

#### 7.Start the Server

```
php -S localhost:8000
```
### Now visit http://localhost:8000/{your foldername}/index.php in your browser.

![image](https://github.com/user-attachments/assets/4c02323f-ffd4-43e7-b05b-005a136b521a)



# Usage

### Register as a donor via register.php
### Donate or Request blood from donate.php & request.php
### View Donors & Requests from view_donors.php & view_requests.php
### Predict future blood demand using predict_demand.php

# Contributing

### Feel free to submit issues or pull requests to improve the system!



