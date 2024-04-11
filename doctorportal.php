<?php
session_start();

// Check if doctor is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: doctorportal.php"); // Redirect to login page if not logged in
    exit();
}

// Connect to the database
$server = "localhost";
$username = "root";
$password = "";
$database = "Patients_info";

$con = mysqli_connect($server, $username, $password, $database);
if (!$con) {
    die("Connection to the database failed due to" . mysqli_connect_error());
}

// Include database connection and fetch counts
// Assuming you have already fetched counts from the database
$total_patients_query = "SELECT COUNT(*) AS total FROM info_patient";
$total_patients_result = mysqli_query($con, $total_patients_query);
if (!$total_patients_result) {
    die("Error fetching total patients count: " . mysqli_error($con));
}
$total_patients_data = mysqli_fetch_assoc($total_patients_result);
$total_patients = $total_patients_data['total'];

// Fetch filtered patients count
$filtered_patients_count = 0;

// Fetch all patients initially
$query = "SELECT * FROM info_patient";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Error fetching all patient data: " . mysqli_error($con));
}
$patients = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Dummy data for diagnosed patients (IDs)
$diagnosed_patients = array();

// Check if diagnosed patients form is submitted
if (isset($_POST['diagnosed'])) {
    // Retrieve diagnosed patient IDs from form submission
    $diagnosed_patients = isset($_POST['patient']) ? $_POST['patient'] : array();
    // Update database or perform necessary actions with the diagnosed patients
}

// Check if filter is submitted
if (isset($_POST['filter'])) {
    // Retrieve start and end dates from form submission
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    // Modify the SQL query to include date filtering
    $query = "SELECT * FROM info_patient WHERE DATE BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        die("Error fetching filtered patient data: " . mysqli_error($con));
    }
    $patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // Update filtered patients count
    $filtered_patients_count = count($patients);
}

// Check if "Show All Patients" button is clicked
if (isset($_POST['show_all'])) {
    $query = "SELECT * FROM info_patient";
    $result = mysqli_query($con, $query);
    if (!$result) {
        die("Error fetching all patient data: " . mysqli_error($con));
    }
    $patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom Styles */
        .bg-info-custom {
            background-color: #17a2b8;
        }
        .text-white-custom {
            color: #fff;
        }
        .list-group-item-action-custom {
            transition: all 0.3s;
        }
        .list-group-item-action-custom:hover {
            background-color: #138496;
        }
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header-custom {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
        }
        .card-body-custom {
            background-color: #f8f9fa;
        }
        .specialization-list {
            list-style-type: none;
            padding-left: 0;
        }
        .specialization-list li {
            padding: 5px 0;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" style="margin-left: -30px;">
            <!--sidenav-->
            <div class="list-group bg-info-custom" style="height: 100vh;">
                <a href="index.php" class="list-group-item list-group-item-action list-group-item-action-custom text-center text-custom">Dashboard</a>  
                <a href="#" class="list-group-item list-group-item-action list-group-item-action-custom text-center text-custom">Doctors</a>     
            </div>   
        </div>
        <div class="col-md-10">
            <h4 class="my-2">Doctor Dashboard</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-info mx-2 card-custom">
                        <div class="card-header card-header-custom">
                            <h5 class="my-2 text-white-custom">Total Patients</h5>
                        </div>
                        <div class="card-body card-body-custom">
                            <h5 class="card-title"><?php echo $total_patients; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success mx-2 card-custom">
                        <div class="card-header card-header-custom">
                            <h5 class="my-2 text-white-custom">Filtered Patients</h5>
                        </div>
                        <div class="card-body card-body-custom">
                            <h5 class="card-title"><?php echo $filtered_patients_count; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
           

            <div class="row mt-3">
                <div class="col-md-12">
                    <h1 class="mb-4">Patient List</h1>
                    <!-- Add date filter option -->
                    <form method="post">
                        <div class="form-row align-items-center mb-3">
                            <div class="col-auto">
                                <label for="start_date" class="sr-only">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control mr-2" placeholder="Start Date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>">
                            </div>
                            <div class="col-auto">
                                <label for="end_date" class="sr-only">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control mr-2" placeholder="End Date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>">
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="filter" class="btn btn-primary mr-2">Apply Filter</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="show_all" class="btn btn-secondary">Show All Patients</button>
                            </div>
                        </div>
                    </form>
                 <form method="post">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Date</th>
                                    <th>Disease</th>
                                    <th>Diagnosed</th>
                                    <th>Actions</th> <!-- New column for actions -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patients as $patient): ?>
                                    <tr>
                                        <td><?php echo $patient['S_NO']; ?></td>
                                        <td><?php echo $patient['NAME']; ?></td>
                                        <td><?php echo $patient['PHONE']; ?></td>
                                        <td><?php echo $patient['GENDER']; ?></td>
                                        <td><?php echo $patient['DATE']; ?></td>
                                        <td><?php echo $patient['DISEASE']; ?></td>
                                        <td>
                                            <input type="checkbox" name="patient[]" value="<?php echo $patient['S_NO']; ?>" <?php echo in_array($patient['S_NO'], $diagnosed_patients) ? 'checked' : ''; ?>>
                                        </td>
                                        <td>
                                            <a href="reports.php?patient_id=<?php echo $patient['S_NO']; ?>" class="btn btn-primary">Send Report</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" name="diagnosed" class="btn btn-primary">Update Diagnosed Patients</button>
                 </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
