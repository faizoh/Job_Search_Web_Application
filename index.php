<?php
// Existing PHP code to check login and fetch user data
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include('db.php');

$user = null;
if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Bloom</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
</head>
<body>
  <header>
    <h1>Job Bloom - Find Your Next Job</h1>
    <p>Your journey to a new opportunity begins here.</p>
    <div class="login-btn">
      <?php if (!$isLoggedIn): ?>
        <a href="login.php" class="login-link">Login/Register</a>
      <?php else: ?>
        <a href="#" id="hamburger" class="menu-link">☰</a>
      <?php endif; ?>
    </div>
  </header>

  <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="job-listings.php">Job Listings</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>

  <div id="sidebar" class="sidebar">
    <?php if ($isLoggedIn): ?>
      <section class="user-dashboard">
          <h2>Your Dashboard</h2>
          <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
          <h3>Your Applications</h3>
          <?php
          $sql = "SELECT * FROM applications WHERE user_id = :user_id";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
          $stmt->execute();
          $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          if ($applications): ?>
              <ul>
                  <?php foreach ($applications as $application): ?>
                      <li>
                          <strong>Job Title:</strong> <?php echo htmlspecialchars($application['job_title']); ?><br>
                          <strong>Status:</strong> <?php echo htmlspecialchars($application['status']); ?><br>
                          <a href="job-details.php?id=<?php echo $application['job_id']; ?>">View Details</a>
                      </li>
                  <?php endforeach; ?>
              </ul>
          <?php else: ?>
              <p>You have not applied for any jobs yet.</p>
          <?php endif; ?>
          <a href="edit-profile.php" class="edit-profile-link">Edit Profile</a> <!-- Link to edit profile -->
      </section>
    <?php endif; ?>
  </div>

  <main>
    <section class="intro">
        <div class="intro-content">
            <h2>Welcome to Job Bloom!</h2>
            <p>
                At Job Bloom, we aim to connect job seekers with opportunities that match their skills and ambitions. 
                Browse through our diverse job listings, and take the first step towards your dream job today. 
                Click on the 'See Available Jobs' button below to browse through our various job opportunities.
            </p>
        </div>
        <div class="image-placeholder">
            <img src="images/homepage.jpg" alt="Job Opportunities" />
        </div>
    </section>

    <div class="see-jobs-btn">
        <a href="job-listings.php">
            <button>See Available Jobs</button>
        </a>
    </div>
  </main>
  
  <footer>
    <p>&copy; 2024 Job Bloom - All rights reserved.</p>
  </footer>

  <script>
      const hamburger = document.getElementById('hamburger');
      const sidebar = document.getElementById('sidebar');

      hamburger.addEventListener('click', () => {
          sidebar.classList.toggle('active');
      });
  </script>
</body>
</html>