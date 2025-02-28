<?php include './includes/header.php'; ?>

<style>
  body {
    background-image: url('./assets/images/h1.jpg');
    background-size: cover;
    background-position: center;
  }
</style>

<section class="contact-info">
    <h2>Contact Us</h2>
    <p>Reach out for assistance with crop insurance policies and claims.</p>
    <div class="contact-details">
        <div class="info">
            <h3>Email:</h3>
            <p><a href="mailto:cropinsurance2024@gmail.com">cropinsurance2024@gmail.com</a></p>
        </div>
        <div class="info">
            <h3>Phone:</h3>
            <p><a href="tel:+918888888888">+91 88888 88888</a></p>
        </div>
        <div class="info">
            <h3>Address:</h3>
            <p>Amar Empire Goaves Besides Reliance Digital, Belagavi, 560001 Karnataka, India</p>
        </div>
    </div>
</section>

<section class="contact-form">
    <h2>Get in Touch</h2>
    <form action="contact.php" method="POST">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        
        <label for="message">Message</label>
        <textarea id="message" name="message" required></textarea>
        
        <button type="submit">Send Message</button>
    </form>
</section>

<section class="map-section">
    <h2>Our Location</h2>
    <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d580.0462495164904!2d74.50764777340186!3d15.844199700685719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3bbf677574a25367%3A0xd79748fb7198f920!2sAmar%20Empire%20Goaves%20Besides%20Reliance%20Digital%2C%20Belagavi%2C%20Karnataka%20560001!3m2!1d15.8443016!2d74.5077716!5e0!3m2!1sen!2sin!4v1739698004107!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="100%" height="450" style="border:0;" allowfullscreen></iframe>
</section>

<?php
require './includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include './includes/footer.php'; ?>
</body>
</html>
