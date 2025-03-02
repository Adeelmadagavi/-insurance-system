<?php include 'includes/header.php'; ?>
<style>
  body {
    background-image: url('./assets/images/d3.jpg');
    background-size: cover;
    background-position: center;
  }
</style>

<!-- Report Incident Form -->
<section class="report-incident">
  <h2>Report an Incident</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter a Name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email"  placeholder="Enter a Email" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone"  placeholder="Enter a Phone Number" required>

    <label for="aadhaar">Aadhaar Card Number:</label>
    <input type="text" id="aadhaar" name="aadhaar"  placeholder="Enter a Adharcard Number" required>

    <label for="pan">PAN Number:</label>
    <input type="text" id="pan" name="pan"  placeholder="Enter a Pancard Number" required>

    <label for="description">Description of Incident:</label>
    <textarea id="description" name="description" rows="5" required></textarea>

    <label for="images">Upload Images:</label>
    <input type="file" id="images" name="images[]" accept="image/*" multiple>

    <label for="videos">Upload Videos:</label>
    <input type="file" id="videos" name="videos[]" accept="video/*">

    <button type="submit" name="submit">Submit Report</button>
  </form>
</section>

<?php
require './includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO incidents (name, email, phone, aadhaar, pan, description, images, videos) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $aadhaar, $pan, $description, $images, $videos);

    // Set parameters
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $aadhaar = $_POST['aadhaar'];
    $pan = $_POST['pan'];
    $description = $_POST['description'];

    // Handle image uploads
    $images = '';
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $tmp_name) {
            $file_data = file_get_contents($tmp_name);
            $images .= base64_encode($file_data) . ';'; // Store multiple images as a concatenated string
        }
    }

    // Handle video uploads
    $videos = '';
    if (!empty($_FILES['videos']['name'][0])) {
        foreach ($_FILES['videos']['tmp_name'] as $tmp_name) {
            $file_data = file_get_contents($tmp_name);
            $videos .= base64_encode($file_data) . ';'; // Store multiple videos as a concatenated string
        }
    }

    // Execute the statement
    $stmt->execute();

    echo "Incident reported successfully!";
    $stmt->close();
    $conn->close();
}
?>

<?php include 'includes/footer.php'; ?>