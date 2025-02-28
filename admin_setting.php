<?php include 'includes/header.php'; ?>
<style>
  body {
    background-image: url('./assets/images/c3.jpg');
    background-size: cover;
    background-position: center;
  }
</style>
<main class="admin-container">
    <!-- Admin Settings -->
    <section class="admin-settings">
        <h2>Admin Settings</h2>
        <div class="settings-container">
            <h3>Manage Claims</h3>
            <table class="claims-table">
                <thead>
                    <tr>
                        <th>Claim ID</th>
                        <th>Farmer Name</th>
                        <th>Date</th>
                        <th>Claim Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#67890</td>
                        <td>Jane Smith</td>
                        <td>2024-04-10</td>
                        <td>Livestock Loss</td>
                        <td>
                            <select class="status-select" onchange="updateClaimStatus('#67890', this.value)">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-view" onclick="viewClaim('#67890')">View</button>
                            <button class="btn-edit" onclick="editClaim('#67890')">Edit</button>
                            <button class="btn-delete" onclick="deleteClaim('#67890')">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Claim ID</th>
                        <th>Farmer Name</th>
                        <th>Date</th>
                        <th>Claim Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#85263</td>
                        <td>Smith</td>
                        <td>2024-04-10</td>
                        <td>sugarcane</td>
                        <td>
                            <select class="status-select" onchange="updateClaimStatus('#67890', this.value)">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-view" onclick="viewClaim('#67890')">View</button>
                            <button class="btn-edit" onclick="editClaim('#67890')">Edit</button>
                            <button class="btn-delete" onclick="deleteClaim('#67890')">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Claim ID</th>
                        <th>Farmer Name</th>
                        <th>Date</th>
                        <th>Claim Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#98741</td>
                        <td>suhas</td>
                        <td>2024-04-10</td>
                        <td>soya bean</td>
                        <td>
                            <select class="status-select" onchange="updateClaimStatus('#67890', this.value)">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-view" onclick="viewClaim('#67890')">View</button>
                            <button class="btn-edit" onclick="editClaim('#67890')">Edit</button>
                            <button class="btn-delete" onclick="deleteClaim('#67890')">Delete</button>
                        </td>
                    </tr>

                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Claim Details Modal -->
    <div id="claimModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeClaimModal()">&times;</span>
            <h2>Claim Details</h2>
            <div class="claim-details">
                <div class="detail-group">
                    <label>Farmer Name:</label>
                    <p id="claimFarmerName"></p>
                </div>
                <div class="detail-group">
                    <label>Contact Information:</label>
                    <p id="claimContactInfo"></p>
                </div>
                <div class="detail-group">
                    <label>Claim Description:</label>
                    <p id="claimDesc"></p>
                </div>
                <div class="detail-group">
                    <label>Uploaded Documents:</label>
                    <div id="documentGallery" class="document-gallery"></div>
                </div>
                <div class="detail-group">
                    <label>Status Update:</label>
                    <select id="claimStatusUpdate" onchange="updateClaimStatusDetails(this.value)">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="detail-group">
                    <label>Admin Notes:</label>
                    <textarea id="claimAdminNotes" rows="4"></textarea>
                </div>
                <div class="button-group">
                    <button class="btn-save" onclick="saveClaimChanges()">Save Changes</button>
                    <button class="btn-notify" onclick="notifyClaimant()">Notify Claimant</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>