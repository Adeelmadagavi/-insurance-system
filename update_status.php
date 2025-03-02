
<?php
require './includes/config.php';

$incidentId = $_GET['id'];
$action = $_GET['action'];

// Validate action
if (!in_array($action, ['approve', 'reject'])) {
    die(json_encode(['success' => false, 'message' => 'Invalid action']));
}

// Update status in the database
$newStatus = ($action === 'approve') ? 'approved' : 'rejected';
$sql = "UPDATE incidents SET status = ? WHERE incident_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $newStatus, $incidentId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
}

$stmt->close();
$conn->close();
?>