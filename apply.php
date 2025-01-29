<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$successMessage = ''; // Initialize success message variable
$error = ''; // Initialize error message variable

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Get the job details from the database
    $sql = "SELECT * FROM jobs WHERE id = :job_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the job is found, display the application form
    if ($job) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the application form
            $cover_letter = $_POST['cover_letter'];
            $resume = $_FILES['resume'];

            // Validate the form inputs
            if (empty($cover_letter) || empty($resume['name'])) {
                $error = "Please fill out all fields and upload your resume.";
            } else {
                // Handle file upload for the resume
                $upload_dir = 'uploads/resumes/';
                $resume_path = $upload_dir . basename($resume['name']);
                move_uploaded_file($resume['tmp_name'], $resume_path);

                // Insert application into the database
                $user_id = $_SESSION['user_id'];
                $sql = "INSERT INTO applications (user_id, job_id, cover_letter, resume_path) 
                        VALUES (:user_id, :job_id, :cover_letter, :resume_path)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':job_id', $job_id);
                $stmt->bindParam(':cover_letter', $cover_letter);
                $stmt->bindParam(':resume_path', $resume_path);

                if ($stmt->execute()) {
                    // Set the success message
                    $successMessage = "Application submitted successfully!";
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            }
        }
    } else {
        echo "Job not found.";
        exit;
    }
} else {
    echo "No job ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - Job Bloom</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="job-details.php">Job Details</a></li>
                <li><a href="job-listings.php">Job Listings</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="apply-job">
        <h2>Apply for Job: <?php echo htmlspecialchars($job['title']); ?></h2>

        <?php if ($successMessage): ?>
            <p class="success" style="color: green;"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p class="error" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="apply.php?job_id=<?php echo $job['id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="cover_letter">Cover Letter:</label>
            <textarea name="cover_letter" id="cover_letter" rows="4" placeholder="Write a cover letter..." required></textarea>

            <label for="resume">Resume:</label>
            <input type="file" name="resume" id="resume" required>

            <button type="submit" class="submit-btn">Submit Application</button>
        </form>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Job Bloom. All rights reserved.</p>
    </footer>
</body>
</html>