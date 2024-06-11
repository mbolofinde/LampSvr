<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 50px;
        }
        .registration-container {
            max-width: 400px;
            margin: auto;
        }
        .register-btn {
            background-color: black; /* Blue button */
            color: #fff; /* White text */
        }
                .register-link {
            color: #343a40; /* Dark text */
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>User Registration</h2>
        <form method="post" >
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn register-btn">Register</button>
            <div class="mt-3">
            <a href="index.php" class="register-link">Login</a>
        </div>
        </form>
        <?php
        // Include the database connection file
        include 'db_connection.php';

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect form data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

            // Prepare SQL insert statement
            $sql = "INSERT INTO webusers (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $password);

            // Execute the statement
            if ($stmt->execute()) {
                echo '<div class="alert alert-success mt-3" role="alert">Registration successful!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">Error: ' . $conn->error . '</div>';
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
        ?>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
