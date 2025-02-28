<?php
include 'includes/header.php';
require 'includes/config.php';

// Check if admin is logged in
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get claims data from database
$query = "SELECT c.*, u.full_name as farmer_name 
          FROM claims c 
          JOIN users u ON c.user_id = u.user_id 
          ORDER BY c.created_at DESC";
$result = $conn->query($query);
$claims = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $claims[] = $row;
    }
}

// Get summary counts
$total_claims = count($claims);
$pending_claims = 0;
$processed_claims = 0;
foreach ($claims as $claim) {
    if ($claim['status'] == 'pending') {
        $pending_claims++;
    } else {
        $processed_claims++; 
    }
}

$farmer_query = "SELECT COUNT(*) as total FROM users";
$farmer_result = $conn->query($farmer_query);
$total_farmers = $farmer_result->fetch_assoc()['total'];
?>
<style>
  body {
    background-image: url('./assets/images/c3.jpg');
    background-size: cover;
    background-position: center;
  }
</style>
<main class="admin-container">
    <!-- Dashboard Summary -->
    <section class="dashboard-summary">
        <h2>Dashboard Overview</h2>
        <div class="summary-cards">
            <div class="summary-card">
                <h3>Total Reports</h3>
                <p class="count">156</p>
            </div>
            <div class="summary-card">
                <h3>Pending Reports</h3>
                <p class="count">23</p>
            </div>
            <div class="summary-card">
                <h3>Processed Claims</h3>
                <p class="count">133</p>
            </div>
            <div class="summary-card">
                <h3>Total Farmers</h3>
                <p class="count">450</p>
            </div>
        </div>
    </section>

    <!-- Recent Reports Table -->
    <section class="reports-section">
        <h2>Recent Incident Reports</h2>
        <div class="table-container">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Farmer Name</th>
                        <th>Date</th>
                        <th>Incident Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#12345</td>
                        <td>John Doe</td>
                        <td>2024-03-15</td>
                        <td>Crop Damage</td>
                        <td>
                            <select class="status-select" onchange="updateStatus('#12345', this.value)">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-view" onclick="viewReport('#12345')">View</button>
                            <button class="btn-edit" onclick="editReport('#12345')">Edit</button>
                            <button class="btn-delete" onclick="deleteReport('#12345')">Delete</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Report Details Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Report Details</h2>
            <div class="report-details">
                <div class="detail-group">
                    <label>Farmer Name:</label>
                    <p id="farmerName"></p>
                </div>
                <div class="detail-group">
                    <label>Contact Information:</label>
                    <p id="contactInfo"></p>
                </div>
                <div class="detail-group">
                    <label>Incident Description:</label>
                    <p id="incidentDesc"></p>
                </div>
                <div class="detail-group">
                    <label>Uploaded Images:</label>
                    <div id="imageGallery" class="image-gallery"></div>
                </div>
                <div class="detail-group">
                    <label>Status Update:</label>
                    <select id="statusUpdate" onchange="updateStatusDetails(this.value)">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="detail-group">
                    <label>Admin Notes:</label>
                    <textarea id="adminNotes" rows="4"></textarea>
                </div>
                <div class="button-group">
                    <button class="btn-save" onclick="saveChanges()">Save Changes</button>
                    <button class="btn-notify" onclick="notifyFarmer()">Notify Farmer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Table for Values -->
    <section class="summary-table">
        <h2>Summary of Values</h2>
        <table class="summary-values">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Reports</td>
                    <td>156</td>
                </tr>
                <tr>
                    <td>Pending Reports</td>
                    <td>23</td>
                </tr>
                <tr>
                    <td>Processed Claims</td>
                    <td>133</td>
                </tr>
                <tr>
                    <td>Total Farmers</td>
                    <td>450</td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
refereing this code make a admin setting page in admin model where he can update mange claims reported be the user generate all the code