<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Fill out the fields required before you continue.";
    } else {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Bloom</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-page">
    <h1 class="page-title">Welcome Back!</h1>
    <div class="container">
        <div class="loginHeader">
            <h2>Login to Your Account</h2>

            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>
        <div class="loginBody">
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="email"><i class="fas fa-envelope"></i>Email Address</label>
                    <input type="email" name="email" id="email" required />
                </div>
                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i>Password</label>
                    <input type="password" name="password" id="password" required />
                </div>
                <div class="input-group">
                    <button type="submit">Login</button>
                </div>
            </form>
            <p><a href="forgot-password.php">Forgot your password?</a></p>
        </div>
        <p>Don't have an account? <a href="sign-up.php">Sign up here</a></p>
    </div>
</body>
</html>