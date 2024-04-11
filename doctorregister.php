<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "Patients_info"; // Replace with your actual database name

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        die("Connection to the database failed due to" . mysqli_connect_error());
    }

    // Collect data from the form
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $Specialization = mysqli_real_escape_string($con, $_POST['Specialization']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $experience = mysqli_real_escape_string($con, $_POST['experience']);

    // Prepare and execute SQL statement to insert doctor's data into the database
    $query = "INSERT INTO doctorinfo(username, fullname, phonenumber, Specialization, password, email, address, experience) 
              VALUES ('$username', '$fullname', '$phonenumber', '$Specialization', '$password', '$email', '$address', '$experience')";
    $result = mysqli_query($con, $query);

    if ($result) {
        header("Location: doctorlogin.php"); // Redirect to login page
        exit();
    } else {
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Doctor Registration</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phonenumber">Phone Number</label>
                <input type="tel" class="form-control" id="phonenumber" name="phonenumber" required>
            </div>
            <div class="form-group">
                <label for="Specialization">Specialization</label>
                <input type="text" class="form-control" id="Specialization" name="Specialization" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="experience">Years of Experience</label>
                <input type="number" class="form-control" id="experience" name="experience" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="text-center mt-3">
            <h5>Already have an account?</h5> 
            <a href="doctorlogin.php" class="btn btn-primary">Click Here to Login</a>
        </div>
    </div>
</body>
</html>
