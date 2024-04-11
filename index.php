<?php
if(isset($_POST['NAME'])){

$server="localhost";
$username="root";
$password="";
$database="Patients_info"; 
$con= mysqli_connect($server,$username,$password,$database);
if(!$con){
    die("connection to the database failed due to".mysqli_connect_error());
}
$NAME=$_POST["NAME"];
$PHONE=$_POST["PHONE"];
$GENDER=$_POST["GENDER"];
$DATE=$_POST["DATE"];
$DISEASE=$_POST["DISEASE"];
$sql="INSERT INTO `info_patient` ( `NAME`, `PHONE`, `GENDER`, `DATE`, `DISEASE`) VALUES ( '$NAME', '$PHONE', '$GENDER', '$DATE', '$DISEASE');";
//echo $sql;
if($con->query($sql)==true){
    echo "Submitted Successfully";
}
    else{
        echo "error: ".$sql . "<br>" . $con->error;
    }
    $con->close();  


}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #495057;
        }

        nav {
            background-color: #4caf50;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        .carousel {
            max-width: 1300px;
            margin: 20px auto;
            border-radius: 10px;
            overflow: hidden;
        }

        .carousel-inner {
            border-radius: 10px;
        }

        .carousel-item img {
            border-radius: 10px;
            object-fit: cover;
            max-height: 400px;
        }

        .doctor-info {
        
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .doctor-info img {
            border-radius: 50%;
            max-width: 300px;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center; /* Center the form */
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 0 auto; /* Center the button */
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <a class="navbar-brand" href="#">Doctor's Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="login.php">Admin Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="doctorlogin.php">Doctor Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#prescription-form">Prescription Form</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Doctor Carousel -->
    <div id="doctor-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://t4.ftcdn.net/jpg/01/33/33/41/360_F_133334155_X23HzbJKawbIgXVaub4bPM8CjpkS5uMS.jpg" class="d-block w-100" alt="Doctor Image 1">
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/40568/medical-appointment-doctor-healthcare-40568.jpeg?cs=srgb&dl=pexels-pixabay-40568.jpg&fm=jpg" class="d-block w-100" alt="Doctor Image 2">
            </div>
            <!-- Add more carousel items as needed -->
        </div>
    </div>

    <!-- Doctor Information -->
    <div id="doctor-info" class="doctor-info text-center">
        <img src="https://cdn.pixabay.com/photo/2016/03/31/20/11/doctor-1295571_640.png" alt="Doctor Image" class="mb-4">
        <h2 class="text-success">Doctor Information</h2>
        <p><strong>Doctor Name:</strong> Dr. John Doe</p>
        <p><strong>Specialization:</strong> Internal Medicine</p>
        <p><strong>Contact:</strong> (123) 456-7890</p>
        <p><strong>Email:</strong> doctor@example.com</p>
        <p><strong>Address:</strong> 123 Medical Street, Cityville</p>
    </div>

    <!-- Prescription Form -->
    <form id="prescription-form" action="index.php" method="post">
        <h2 class="text-success">Prescription Form</h2>
        <div class="form-group">
            <label for="patientName">Patient Name:</label>
            <input type="text" id="patientName" name="NAME" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="age">Phone Number:</label>
            <input type="number" id="age" name="PHONE" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="GENDER" class="form-control" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="disease">Prescription for Disease:</label>
            <textarea id="disease" name="DISEASE" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="date">Prescription Date:</label>
            <input type="date" id="date" name="DATE" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
         <button type="submit" class="btn btn-success">Submit Prescription</button>

      
</form>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
