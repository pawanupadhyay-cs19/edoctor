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
    $password = ($_POST['password']); // No need to hash the password here

    // Prepare SQL statement to retrieve the user's data from the database
    $query = "SELECT * FROM doctorinfo WHERE username=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the entered password with the hashed password from the database
        if ($password == $row['password']) { // Adjust this line to use proper password hashing and comparison
            // Passwords match, set session and redirect
            $_SESSION['username'] = $row['username'];
            header("Location:doctorportal.php"); // Redirect to doctor portal
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found');</script>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Doctor Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="text-center mt-3">
            <h5>Don't have an account?</h5> 
            <a href="doctorregistration.php" class="btn btn-primary">Register Here</a>
        </div>
    </div>
</body>
</html>
