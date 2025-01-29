<?php
include('db.php');

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    
    $sql = "SELECT * FROM jobs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $job_id, PDO::PARAM_INT);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($job) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($job['title']); ?></title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <header>
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="job-listings.php">Job Listings</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
            </header>

            <main>
                <section class="job-details">
                    <h2><?php echo htmlspecialchars($job['title']); ?></h2>
                    <div class="job-details-content">
                        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                        <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                    </div>
                    <a href="apply.php?job_id=<?php echo $job['id']; ?>" class="apply-btn">Apply Now</a>
                </section>
            </main>

            <footer>
                <p>&copy; <?php echo date("Y"); ?> Job Bloom. All rights reserved.</p>
            </footer>
        </body>
        </html>
        <?php
    } else {
        echo "Job not found.";
    }
} else {
    echo "No job ID specified.";
}
?>