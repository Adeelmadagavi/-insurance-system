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
            max-width: 80%;
            max-height: 80%;
            overflow: auto;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
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
                                    <span class="icon" onclick="openModal('<?php echo base64_encode($incident['images']); ?>', 'image')">📷</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($incident['videos'])): ?>
                                    <span class="icon" onclick="openModal('<?php echo base64_encode($incident['videos']); ?>', 'video')">🎥</span>
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

    <!-- Modal for Images and Videos -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <script>
        // Function to open modal
        function openModal(data, type) {
            const modal = document.getElementById('modal');
            const modalBody = document.getElementById('modal-body');

            if (type === 'image') {
                modalBody.innerHTML = `<img src="data:image/jpeg;base64,${data}" alt="Incident Image" style="max-width: 100%;">`;
            } else if (type === 'video') {
                modalBody.innerHTML = `<video controls style="max-width: 100%;"><source src="data:video/mp4;base64,${data}" type="video/mp4"></video>`;
            }

            modal.style.display = 'flex';
        }

        // Function to close modal
        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
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

