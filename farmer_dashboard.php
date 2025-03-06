<?php include 'includes/header.php'; ?>
<style>
  body {
    background-image: url('./assets/images/d3.jpg');
    background-size: cover;
    background-position: center;
  }
  
  .success-message {
    background-color: #dff0d8;
    color: #3c763d;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #d6e9c6;
    border-radius: 4px;
  }
  
  .error-message {
    background-color: #f2dede;
    color: #a94442;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #ebccd1;
    border-radius: 4px;
  }
</style>

<?php
require './includes/config.php';

// Verify database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create upload directories if they don't exist
$upload_dir = 'uploads/';
$image_dir = $upload_dir . 'images/';
$video_dir = $upload_dir . 'videos/';

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}
if (!file_exists($image_dir)) {
    mkdir($image_dir, 0777, true);
}
if (!file_exists($video_dir)) {
    mkdir($video_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    try {
        // Set parameters
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $aadhaar = $_POST['aadhaar'];
        $pan = $_POST['pan'];
        $description = $_POST['description'];
        
        // Handle image uploads
        $image_paths = [];
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] == 0) {
                    $image_name = time() . '_' . $_FILES['images']['name'][$key];
                    $image_path = $image_dir . $image_name;
                    
                    if (move_uploaded_file($tmp_name, $image_path)) {
                        $image_paths[] = $image_path;
                    }
                }
            }
        }
        $images = implode(';', $image_paths);
        
        // Handle video upload
        $video_path = '';
        if (!empty($_FILES['videos']['name']) && $_FILES['videos']['error'] == 0) {
            $video_name = time() . '_' . $_FILES['videos']['name'];
            $video_path = $video_dir . $video_name;
            
            move_uploaded_file($_FILES['videos']['tmp_name'], $video_path);
        }
        
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO incidents (name, email, phone, aadhaar, pan, description, images, videos) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("ssssssss", $name, $email, $phone, $aadhaar, $pan, $description, $images, $video_path);
        
        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        echo "<div class='success-message'>Incident reported successfully!</div>";
        $stmt->close();
    } catch (Exception $e) {
        echo "<div class='error-message'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!-- Report Incident Form -->
<section class="report-incident">
  <h2>Report an Incident</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter a Name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter a Email" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" placeholder="Enter a Phone Number" required>

    <label for="aadhaar">Aadhaar Card Number:</label>
    <input type="text" id="aadhaar" name="aadhaar" placeholder="Enter a Adharcard Number" required>

    <label for="pan">PAN Number:</label>
    <input type="text" id="pan" name="pan" placeholder="Enter a Pancard Number" required>

    <label for="description">Description of Incident:</label>
    <textarea id="description" name="description" rows="5" required></textarea>

    <label for="images">Upload Images:</label>
    <input type="file" id="images" name="images[]" accept="image/*" multiple>

    <label for="videos">Upload Video:</label>
    <input type="file" id="videos" name="videos" accept="video/*">

    <button type="submit" name="submit">Submit Report</button>
  </form>
</section>

<?php include 'includes/footer.php'; ?>