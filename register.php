<?php include 'includes/header.php'; ?>
<style>
  body {
    background-image: url('./assets/images/h1.jpg');
    background-size: cover;
    background-position: center;
  }
</style>

  <!-- Main Content -->
  <section class="main-content">
    <h1>Welcome to Farmer's Insurance Platform</h1>
    <p>For farmers to manage natural disaster-related insurance claims.</p>
  </section>

  <!-- Registration Form (visible for new users only) -->
  <section id="registration-form" class="form-section">
    <h2>Register as a New Farmer</h2>
    <form id="registerForm" action="register.php" method="POST">
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="phone">Phone Number:</label>
      <input type="text" id="phone" name="phone" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Register</button>
    </form>
  </section>

<?php
require './includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (full_name, phone_number, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $phone, $email, $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include 'includes/footer.php'; ?>
