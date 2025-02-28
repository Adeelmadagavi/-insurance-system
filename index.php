<?php include './includes/header.php'; ?>

<style>
  body {
    background-image: url('./assets/images/mama.jpg');
    background-size: cover;
    background-position: center;
  }
</style>
  <!-- Main Content -->
  <section class="main-content">
    <h1>Welcome to Farmer's Insurance Platform</h1>
    <p>For farmers to manage natural disaster-related insurance claims.</p>
  </section>


  <section class="main-content">
    <h1>FARMER ARE THE BACK BONE OF OUR COUNTRY</h1>
    <p>“We must plant the sea and herd its animals using the sea as farmers instead of hunters. That is what civilization is all about - farming replacing hunting.” .</p>
  </section>
  <!-- Registration Form (visible for new users only) -->
  <!-- <section id="registration-form" class="form-section">
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
    </form> -->
  </section>
  <!-- Notifications Section -->
  <section class="notifications">
    <h2>Latest Insurance Updates</h2>
    <div class="notification-slider">
      <ul id="notification-list" class="sliding-notifications">
        <!-- Notifications will be inserted dynamically -->
      </ul>
    </div>
    <style>
      .notification-slider {
        width: 100%;
        overflow: hidden;
      }
      
      .sliding-notifications {
        display: flex;
        animation: slide 20s linear infinite;
        white-space: nowrap;
      }

      @keyframes slide {
        0% {
          transform: translateX(100%);
        }
        100% {
          transform: translateX(-100%);
        }
      }
    </style>
  </section>

  <?php include './includes/footer.php'; ?>

