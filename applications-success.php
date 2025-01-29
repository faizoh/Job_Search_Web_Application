<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - Job Bloom</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="job-listings.php">Job Listings</a></li>
                <li><a href="contact.php">Contact/About</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="success-message">
        <h2>Application Submitted</h2>
        <p>Your application has been submitted successfully!</p>
        <a href="job-listings.php">Return to Job Listings</a>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Job Bloom. All rights reserved.</p>
    </footer>
</body>
</html>