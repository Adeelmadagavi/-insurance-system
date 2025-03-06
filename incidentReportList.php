<?php
// Include the config file for database connection
require './includes/config.php';

// Fetch all incidents from the database
$sql = "SELECT incident_id, name, email, phone, aadhaar, pan, description, images, videos, status, submission_date FROM incidents";
$result = $conn->query($sql);

$incidents = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $incidents[] = array(
            'id' => $row['incident_id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'aadhaar' => $row['aadhaar'],
            'pan' => $row['pan'],
            'description' => $row['description'],
            'images' => $row['images'],
            'videos' => $row['videos'],
            'status' => $row['status'],
            'date' => $row['submission_date']
        );
    }
} else {
    echo "0 results";
}

// Close the connection (optional, as PHP will automatically close it at the end of the script)
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Management</title>
    <style>
        body {
            background-image: url('./assets/images/c3.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .dashboard {
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            margin: 20px;
            border-radius: 10px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .incident-management {
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            margin: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .icon {
            cursor: pointer;
            font-size: 20px;
            margin: 0 5px;
        }
        .icon.disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            height: 90%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
        }
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }
        .image-container img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 30px;
            color: #fff;
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
            user-select: none;
        }
        .nav-arrow.left {
            left: 10px;
        }
        .nav-arrow.right {
            right: 10px;
        }
    </style>
</head>
<body>
    <!-- Admin Dashboard -->
    <section class="dashboard">
        <h1>Welcome, Admin!</h1>
        <div class="dashboard-grid">
            <!-- Total Incidents -->
            <div class="card">
                <h3>Total Incidents</h3>
                <p><?php echo count($incidents); ?></p>
            </div>
            <!-- Other Cards -->
            <div class="card">
                <h3>Pending Incidents</h3>
                <p><?php echo count(array_filter($incidents, function($incident) { return $incident['status'] === 'pending'; })); ?></p>
            </div>
            <div class="card">
                <h3>Approved Incidents</h3>
                <p><?php echo count(array_filter($incidents, function($incident) { return $incident['status'] === 'approved'; })); ?></p>
            </div>
            <div class="card">
                <h3>Rejected Incidents</h3>
                <p><?php echo count(array_filter($incidents, function($incident) { return $incident['status'] === 'rejected'; })); ?></p>
            </div>
        </div>
    </section>

    <!-- Incident Management -->
    <section class="incident-management">
        <h2>Manage Incidents</h2>
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Aadhaar</th>
                    <th>PAN</th>
                    <th>Description</th>
                    <th>Images</th>
                    <th>Videos</th>
                    <th>Status</th>
                    <th>Submission Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($incidents)): ?>
                    <?php foreach ($incidents as $incident): ?>
                        <tr>
                            <td>
                                <!-- Approve and Reject Icons -->
                                <span class="icon <?php echo ($incident['status'] !== 'pending') ? 'disabled' : ''; ?>" 
                                      onclick="updateStatus(<?php echo $incident['id']; ?>, 'approve')">✅</span>
                                <span class="icon <?php echo ($incident['status'] !== 'pending') ? 'disabled' : ''; ?>" 
                                      onclick="updateStatus(<?php echo $incident['id']; ?>, 'reject')">❌</span>
                            </td>
                            <td><?php echo htmlspecialchars($incident['id']); ?></td>
                            <td><?php echo htmlspecialchars($incident['name']); ?></td>
                            <td><?php echo htmlspecialchars($incident['email']); ?></td>
                            <td><?php echo htmlspecialchars($incident['phone']); ?></td>
                            <td><?php echo htmlspecialchars($incident['aadhaar']); ?></td>
                            <td><?php echo htmlspecialchars($incident['pan']); ?></td>
                            <td><?php echo htmlspecialchars($incident['description']); ?></td>
                            <td>
                                <?php if (!empty($incident['images'])): ?>
                                    <span class="icon" onclick="openImageModal('<?php echo $incident['id']; ?>')">📷</span>
                                    <div id="imageData-<?php echo $incident['id']; ?>" style="display: none;"><?php echo $incident['images']; ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($incident['videos'])): ?>
                                    <span class="icon" onclick="openVideoModal('<?php echo $incident['id']; ?>')">🎥</span>
                                    <div id="videoData-<?php echo $incident['id']; ?>" style="display: none;"><?php echo $incident['videos']; ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($incident['status']); ?></td>
                            <td><?php echo htmlspecialchars($incident['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12">No incidents found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- Modal for Images -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="image-container">
                <img id="modalImage" src="" alt="Incident Image">
            </div>
            <span class="nav-arrow left" onclick="changeImage(-1)">&#10094;</span>
            <span class="nav-arrow right" onclick="changeImage(1)">&#10095;</span>
        </div>
    </div>

    <!-- Modal for Videos -->
    <div id="videoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="image-container">
                <video id="modalVideo" controls style="max-width: 100%; max-height: 100%;">
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <script>
        let currentImageIndex = 0;
        let imagesArray = [];

        // Function to open image modal
        function openImageModal(incidentId) {
            const modal = document.getElementById('imageModal');
            const imageDataElement = document.getElementById(`imageData-${incidentId}`);
            
            if (imageDataElement) {
                const imagesData = imageDataElement.innerHTML;
                imagesArray = imagesData.split(';').filter(Boolean); // Split by semicolon and remove empty strings
                
                if (imagesArray.length > 0) {
                    currentImageIndex = 0;
                    document.getElementById('modalImage').src = imagesArray[currentImageIndex];
                    modal.style.display = 'flex';

                    // Show/hide arrows based on the number of images
                    document.querySelector('.nav-arrow.left').style.display = imagesArray.length > 1 ? 'block' : 'none';
                    document.querySelector('.nav-arrow.right').style.display = imagesArray.length > 1 ? 'block' : 'none';
                }
            }
        }

        // Function to change image in the modal
        function changeImage(direction) {
            currentImageIndex += direction;
            if (currentImageIndex >= imagesArray.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = imagesArray.length - 1;
            }
            document.getElementById('modalImage').src = imagesArray[currentImageIndex];
        }

        // Function to open video modal
        function openVideoModal(incidentId) {
            const modal = document.getElementById('videoModal');
            const videoDataElement = document.getElementById(`videoData-${incidentId}`);
            
            if (videoDataElement) {
                const videosData = videoDataElement.innerHTML;
                const videosArray = videosData.split(';').filter(Boolean); // Split by semicolon and remove empty strings
                
                if (videosArray.length > 0) {
                    document.getElementById('modalVideo').src = videosArray[0];
                    modal.style.display = 'flex';
                }
            }
        }

        // Function to close modal
        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
            document.getElementById('videoModal').style.display = 'none';
        }

        // Function to update incident status
        function updateStatus(incidentId, action) {
            if (confirm(`Are you sure you want to ${action} this incident?`)) {
                fetch(`update_status.php?id=${incidentId}&action=${action}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`Incident ${action}d successfully!`);
                            location.reload(); // Refresh the page to reflect changes
                        } else {
                            alert('Failed to update status.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>