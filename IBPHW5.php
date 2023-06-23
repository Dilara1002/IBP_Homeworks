<?php
// Server-side form validation
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate Full Name
    if (empty($_POST['full_name'])) {
        $errors[] = 'Full Name is required';
    }

    // Validate Email Address
    if (empty($_POST['email'])) {
        $errors[] = 'Email Address is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid Email Address';
    }

    // Connect to MySQL database
    $servername = 'localhost';
    $username = 'your_username';
    $password = 'your_password';
    $dbname = 'your_database';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Insert data into database if there are no errors
    if (empty($errors)) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];

        $sql = "INSERT INTO students (full_name, email, gender) VALUES ('$full_name', '$email', '$gender')";

        if ($conn->query($sql) === true) {
            $success_message = 'Registration successful!';
        } else {
            $errors[] = 'Error: ' . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}

// Display the students' information from the database
$servername = 'localhost';
$username = 'your_username';
$password = 'your_password';
$dbname = 'your_database';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

$students = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First PHP Aplication</title>
</head>
<body>
    <h1 class="text-center text-primary">Student Informations</h1>
    <br>
    <div class="container">
        <div class="row">
           <form method="post"
                <div class="form-group">
                    <label>Full Name:</label><br>
                    <input type="text" name="fullname" class="form-control"><br>
                    <label>E-Mail:</label><br>
                    <input type="email" id="email" name="email" required><br><br>
                    <label>Genter:</label><br>
                    <input type="radio" id="male" name="gender" value="Male" required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" required>
                    <label for="female">Female</label><br><br>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="btn-btn-primary">
                </div>
                    
            </form>
           
        </div>  
    </div> 
    <br >
    <h2 class="text-center text-danger"><b>students</b></h2> 
    <div class="row">
        <table class="table table-bordered table striped">
            <thead>
                <th>id</th>
                <th>full_name</th>
                <th>email</th>
                <th>genter</th>
            </thead>
            <tbody>
            <?php foreach ($students as $student) { ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['full_name']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td><?php echo $student['gender']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>