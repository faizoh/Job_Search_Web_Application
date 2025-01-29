<?php
session_start();
include('db.php');

$error = ''; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $name = trim($_POST['name']);

    if (empty($email) || empty($password) || empty($name)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error = "Email already exists. Please log in.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (email, password, name) VALUES (:email, :password, :name)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':name', $name);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Error creating account. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Job Bloom</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="signup-page">
    <h1 class="page-title">Welcome to Job Bloom!</h1>
    <div class="container">
        <div class="signupHeader">
            <h2>Sign up to Your Account</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </div>
        <div class="signupBody">
            <form action="sign-up.php" method="post">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required />
                </div>
                <div class="input-group">
                    <label for="email"><i class="fas fa-envelope"></i>Email Address</label>
                    <input type="email" name="email" id="email" required />
                </div>
                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i>Password</label>
                    <input type="password" name="password" id="password" required />
                </div>
                <div class="input-group">
                    <button type="submit">Sign Up</button>
                </div>
            </form>
            <p><a href="forgot-password.php">Forgot your password?</a></p>
        </div>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>