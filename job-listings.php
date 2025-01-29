<?php
session_start(); // Start the session to check if the user is logged in
include('db.php');

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if ($isLoggedIn) {
    if ($searchTerm) {
        $sql = "SELECT * FROM jobs WHERE title LIKE :searchTerm OR location LIKE :searchTerm LIMIT 3"; // Limit the search results
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    } else {
        $sql = "SELECT * FROM jobs LIMIT 3";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $jobs = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-jobs">
            <h2>Search for Jobs</h2>
            
            <!-- If not logged in, show a prompt to log in -->
            <?php if (!$isLoggedIn): ?>
                <p>You need to <a href="login.php">log in</a> or <a href="sign-up.php">sign up</a> to search for jobs.</p>
            <?php else: ?>
                <script>
                    const suggestions = [
                        <?php foreach ($jobs as $job): ?>
                            "<?php echo htmlspecialchars($job['title']); ?>",
                        <?php endforeach; ?>
                    ];

                    const searchInput = document.querySelector('input[name="search"]');
                    searchInput.addEventListener('input', function() {
                        const value = this.value.toLowerCase();
                        const filtered = suggestions.filter(s => s.toLowerCase().includes(value));
                        console.log(filtered); // For demonstration, replace with actual UI update
                    });
                </script>
                <form action="job-listings.php" method="get">
                    <input type="text" name="search" placeholder="Search for a job...">
                    <button type="submit">Search</button>
                </form>
            <?php endif; ?>
        </section>

        <section class="job-listings">
            <h2>Available Jobs</h2>
            <?php if ($isLoggedIn): ?>
                <?php if ($jobs): ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="jobitem" title="<?php echo htmlspecialchars($job['description']); ?>">
                            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                            <a href="job-details.php?id=<?php echo $job['id']; ?>">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No jobs found matching your search. Try broadening your search terms or check back later.</p>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Job Bloom. All rights reserved.</p>
    </footer>
</body>
</html>