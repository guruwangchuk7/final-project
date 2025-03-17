<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "9099"; // Your MySQL password
$dbname = "majorprojectdb"; // The name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_result = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);

    // SQL to search for student data based on the search term (could be first_name, last_name, or email)
    $sql = "SELECT * FROM students WHERE first_name LIKE '%$search_term%' OR last_name LIKE '%$search_term%' OR email LIKE '%$search_term%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_result[] = $row;
        }
    } else {
        echo "No student found with that search term.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Student</title>
</head>
<body>
    <h2>Search Student</h2>
    <form method="POST" action="search_student.php">
        <label for="search_term">Search by Name or Email:</label>
        <input type="text" name="search_term" required><br><br>

        <input type="submit" value="Search">
    </form>

    <?php if (!empty($search_result)): ?>
        <h3>Search Results:</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Nationality</th>
            </tr>
            <?php foreach ($search_result as $student): ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['first_name']; ?></td>
                    <td><?php echo $student['last_name']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td><?php echo $student['course']; ?></td>
                    <td><?php echo $student['nationality']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
