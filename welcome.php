<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "9099";
$dbname = "majorprojectdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch students
$sql = "SELECT * FROM students"; // Make sure the table 'students' exists in your database
$result = $conn->query($sql);

// Check if the query is successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
            <p>Student Management</p>
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="welcome.php" class="link active">Home</a></li>
                <li><a href="add_student.php" class="link">Add Student</a></li>
                <li><a href="search_students.php" class="link">Search Students</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </nav>

    <div class="content">
        <h2>Student Management System</h2>
        
        <!-- Display Students -->
        <h3>Students List</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
            <?php
            // Fetch and display the students
            while ($student = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $student['first_name'] . ' ' . $student['last_name'] . "</td>
                        <td>" . $student['email'] . "</td>
                        <td>" . $student['phone'] . "</td>
                        <td>" . $student['address'] . "</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php
$conn->close();
?>

</body>
</html>
