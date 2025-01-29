<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Job Bloom</title>
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

    <section class="contact">
        <h1>Contact Us</h1>
        <p>If you have any questions, suggestions, or feedback, we would love to hear from you! Please fill out the form below, and we will get back to you as soon as possible.</p>

        <h2>Send Us a Message</h2>
        <form action="process_contact.php" method="POST">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Your Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="message">Your Message:</label>
            <textarea name="message" id="message" rows="4" required></textarea>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>

        <?php if (isset($_GET['message'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>
    </section>

    <section class="company-info">
        <h2>Contact Information</h2>
        <p><strong>Email:</strong> <a href="mailto:info@jobbloom.com">info@jobbloom.com</a></p>
        <p><strong>Phone:</strong> 0717 000 000</p>
        <p><strong>Location:</strong>My Job Location, 1st floor, Meru County</p>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Job Bloom. All rights reserved.</p>
    </footer>
</body>
</html>