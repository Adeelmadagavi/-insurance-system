<?php include 'includes/header.php'; ?>

  <!-- Profile Details -->
  <section class="profile">
    <h2>Your Profile</h2>
    <form action="update_profile.php" method="POST">
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="name" value="John Doe" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="john.doe@example.com" required>

      <label for="phone">Phone:</label>
      <input type="text" id="phone" name="phone" value="+1 234 567 890" required>

      <button type="submit">Update Profile</button>
    </form>
  </section>


<?php include 'includes/footer.php'; ?>
