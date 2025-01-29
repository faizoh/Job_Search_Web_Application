<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include('db.php');

// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = :id"; // Modify as per your database schema
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>User Profile</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="job-listings.php">Job Listings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="user-info">
            <h2>Your Information</h2>
            <div class="info-card">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Joined:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($user['created_at']))); ?></p> <!-- Assuming there's a created_at field -->
            </div>
        </section>

        <section class="user-actions">
            <h3>Actions</h3>
            <div class="button-group">
                <a class="button" href="edit-profile.php">Edit Profile</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Job Bloom - All rights reserved.</p>
    </footer>
</body>
</html>