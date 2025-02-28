<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmer's Insurance Platform</title>
  <link rel="stylesheet" href="./assets/css/cc.css">
  <link rel="stylesheet" href="./assets/css/admin.css">
  <link rel="stylesheet" href="./assets/css/user.css">
  <link rel="stylesheet" href="./assets/css/fram.css">
  <link rel="stylesheet" href="./assets/css/aboout.css">
  <link rel="stylesheet" href="./assets/css/contact.css">
  <link rel="stylesheet" href="./assets/css/footer.css">
  <link rel="stylesheet" href="./assets/css/admin_s.css">
  <script src="./assets/js/cc.js" defer></script>
  <script src="./assets/js/language.js" defer></script>
  <script src="./assets/js/voice.js" defer></script>
  <script src="./assets/js/notification.js" defer></script>

</head>
<body>

  <!-- Navbar -->
  <header>
    <nav class="navbar">
      <div class="logo">
        <img src="./assets/images/logo1.png" alt="Farmer's Insurance Platform">
      </div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="admin_setting.php">Settings</a></li>
        <?php if (isset($_SESSION['user_type'])): ?>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
      <div class="language-selector">
        <label for="language">Select Language:</label>
        <select id="language">
          <option value="en">English</option>
          <option value="hi">हिन्दी</option>
          <option value="kn">ಕನ್ನಡ</option>
          <option value="mr">मराठी</option>
        </select>
      </div>
      <div class="voice-assistant">
        <button id="start-voice">🎤 Speak to Translate</button>
      </div>
    </nav>
  </header>
  <div id="google_translate_element"></div>
  <script src="./assets/js/language.js"></script>
  <script src="./assets/js/voice.js"></script>
