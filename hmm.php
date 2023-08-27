<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "student_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] === "insert") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $roll = $_POST["roll"];
            $website = $_POST["website"];
            $program = $_POST["program"];
            $reg_number = $_POST["reg_number"];
            
            $sqlInsert = "INSERT INTO student (name, email, roll, website, program, reg_number) VALUES ('$name', '$email', '$roll', '$website', '$program', '$reg_number')";
            
            if ($conn->query($sqlInsert) !== true) {
                echo "Error inserting data: " . $conn->error;
            }
        } elseif ($_POST["action"] === "delete") {
            $id = $_POST["id"];
            
            $sqlDelete = "DELETE FROM student WHERE id = '$id'";
            
            if ($conn->query($sqlDelete) !== true) {
                echo "Error deleting data: " . $conn->error;
            }
        }
    }
}

$sqlList = "SELECT * FROM students";
$result = $conn->query($sqlList);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
</head>
<body>
    <h1>Student Information</h1>
    
    <form method="post" action="">
        <label>Name: <input type="text" name="name"></label>
        <label>Email: <input type="text" name="email"></label>
        <label>Roll: <input type="number" name="roll"></label>
        <label>Website: <input type="text" name="website"></label>
        <label>Program: <input type="text" name="program"></label>
        <label>Reg Number: <input type="text" name="reg_number"></label>
        <input type="hidden" name="action" value="insert">
        <input type="submit" value="Insert">
    </form>
    
    <h2>Student List</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id'] . " Name: " . $row['name'] . " Email: " . $row['email'] . " <form method='post' action=''><input type='hidden' name='id' value='" . $row['id'] . "'><input type='hidden' name='action' value='delete'><input type='submit' value='Delete'></form><br>";
        }
    } else {
        echo "No records found.";
    }
    ?>
</body>
</html>

<?php
$conn->close();
?>
