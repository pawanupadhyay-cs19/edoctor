<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "Patients_info"; 

// Establishing connection to the database
$con = mysqli_connect($server, $username, $password, $database);
if (!$con) {
    die("Connection to the database failed due to: " . mysqli_connect_error());
}

// Retrieving patient data from the database
$query_patients = "SELECT * FROM info_patient";
$result_patients = mysqli_query($con, $query_patients);
if (!$result_patients) {
    die("Error fetching patient data: " . mysqli_error($con));
}

$patients = [];
while ($row = mysqli_fetch_assoc($result_patients)) {
    $patients[] = $row;
}

// Retrieving doctor data from the database
$query_doctors = "SELECT * FROM doctorinfo";
$result_doctors = mysqli_query($con, $query_doctors);
if (!$result_doctors) {
    die("Error fetching doctor data: " . mysqli_error($con));
}

$doctors = [];
while ($row = mysqli_fetch_assoc($result_doctors)) {
    $doctors[] = $row;
}

// Closing the database connection
mysqli_close($con);

// Sample data for demonstration (Admins)
$admins = array(
    array("id" => 1, "name" => "Admin 1", "email" => "admin1@example.com"),
    array("id" => 2, "name" => "Admin 2", "email" => "admin2@example.com")
);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom Styles */
        .bg-custom {
            background-color: #f8f9fa;
        }
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header-custom {
            border-bottom: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>
<body>

<div class="container-fluid bg-custom">
    <div class="row mt-3">
        <div class="col-md-3">
            <!-- Sidenav -->
            <div class="list-group">
                <a href="index.php" class="list-group-item list-group-item-action bg-info text-center text-white">Dashboard</a>  
                <a href="#" class="list-group-item list-group-item-action"> <i class="fas fa-user-shield mr-2"></i> Administrators <span class="badge badge-primary badge-pill"><?php echo count($admins); ?></span></a>  
                <a href="#" class="list-group-item list-group-item-action"> <i class="fas fa-user-md mr-2"></i> Doctors <span class="badge badge-primary badge-pill"><?php echo count($doctors); ?></span></a>  
                <a href="#" class="list-group-item list-group-item-action"> <i class="fas fa-user-injured mr-2"></i> Patients <span class="badge badge-primary badge-pill"><?php echo count($patients); ?></span></a> 
                <a href="doctorregister.php" class="list-group-item list-group-item-action text-center"><i class="fas fa-user-md mr-2"></i> Register as Doctor</a> 
            </div>   
        </div>
        <div class="col-md-9">
            <!-- Main Content -->
            <div class="card mt-3 card-custom">
                <div class="card-header card-header-custom">
                    <h4 class="mb-0">Admin Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-success text-white card-custom">
                                <div class="card-body">
                                    <h5 class="card-title">Total Administrators</h5>
                                    <p class="card-text"><?php echo count($admins); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-info text-white card-custom">
                                <div class="card-body">
                                    <h5 class="card-title">Total Doctors</h5>
                                    <p class="card-text"><?php echo count($doctors); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-warning text-white card-custom">
                                <div class="card-body">
                                    <h5 class="card-title">Total Patients</h5>
                                    <p class="card-text"><?php echo count($patients); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lists of Administrators, Doctors, and Patients -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card card-custom">
                        <div class="card-header card-header-custom">
                            <h5 class="mb-0">Administrators</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($admins as $admin): ?>
                                    <tr>
                                        <td><?php echo $admin['id']; ?></td>
                                        <td><?php echo $admin['name']; ?></td>
                                        <td><?php echo $admin['email']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom">
                        <div class="card-header card-header-custom">
                            <h5 class="mb-0">Doctors</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Specialization</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($doctors as $doctor): ?>
                                    <tr>
                                        <td><?php echo $doctor['ID']; ?></td>
                                        <td><?php echo $doctor['fullname']; ?></td>
                                        <td><?php echo $doctor['Specialization']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom">
                        <div class="card-header card-header-custom">
                            <h5 class="mb-0">Patients</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($patients as $patient): ?>
                                    <tr>
                                        <td><?php echo $patient['S_NO']; ?></td>
                                        <td><?php echo $patient['NAME']; ?></td>
                                        <td><?php echo $patient['GENDER']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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