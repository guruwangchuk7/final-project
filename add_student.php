<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "9099";
$dbname = "majorprojectdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']); // Ensure this is correct
    $address = mysqli_real_escape_string($conn, $_POST['address']); // Ensure this is correct
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);

    // Check if email already exists
    $check_email = "SELECT * FROM students WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        // Email exists
        echo "Error: This email is already registered.";
    } else {
        // Email does not exist, proceed with inserting
        $sql = "INSERT INTO students (first_name, last_name, email, phone, address, course, nationality) 
                VALUES ('$first_name', '$last_name', '$email', '$phone', '$address', '$course', '$nationality')";

        if ($conn->query($sql) === TRUE) {
            echo "New student added successfully!";
            header("Location: students_list.php"); // Redirect after successful insertion
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <h2>Add Student</h2>
    <form action="add_student.php" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required><br><br>

        <label for="address">Address:</label>
        <textarea name="address" id="address" required></textarea><br><br>

        <label for="course">Course:</label>
        <input type="text" name="course" id="course" required><br><br>

        <label for="nationality">Nationality:</label>
        <input type="text" name="nationality" id="nationality" required><br><br>

        <input type="submit" value="Add Student">
    </form>
</body>
</html>

