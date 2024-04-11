<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        textarea {
            resize: none;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Send Report</h1>
        <?php
        session_start();

        // Check if doctor is logged in
        if (!isset($_SESSION['doctor_username'])) {
            echo "<div class='alert alert-danger' role='alert'>You are not logged in. Please <a href='doctorlogin.php' class='alert-link'>log in</a> to access this page.</div>";
            exit();
        }

        // Check if patient ID is provided in the URL
        if (!isset($_GET['patient_id'])) {
            echo "<div class='alert alert-danger' role='alert'>Patient ID not provided.</div>";
            exit();
        }

        $patient_id = $_GET['patient_id'];

        // Get patient data from the database using the provided ID
        $server = "localhost";
        $username = "root";
        $password = "";
        $database = "Patients_info"; 

        $con = mysqli_connect($server, $username, $password, $database);
        if (!$con) {
            die("Connection to the database failed due to" . mysqli_connect_error());
        }

        $query = "SELECT * FROM info_patient WHERE id = $patient_id";
        $result = mysqli_query($con, $query);
        if (!$result) {
            echo "<div class='alert alert-danger' role='alert'>Error fetching patient data: " . mysqli_error($con) . "</div>";
            exit();
        }

        $patient = mysqli_fetch_assoc($result);

        // Process form submission to send the report
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle the report sending functionality here
            $report = $_POST['report']; // Assuming report data is submitted via a form field named 'report'

            // Dummy code to display the report content
            echo "<div class='alert alert-success' role='alert'><strong>Report Sent Successfully!</strong> You can view the sent report <a href='view_report.php?patient_id=$patient_id' class='alert-link'>here</a>.</div>";
        }
        ?>
        <form method="post">
            <div class="form-group">
                <label for="report">Patient Name:</label>
                <input type="text" class="form-control" value="<?php echo $patient['NAME']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="report">Report:</label>
                <textarea id="report" name="report" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Send Report</button>
        </form>
    </div>
</body>
</html>
