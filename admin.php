<?php include 'includes/header.php'; ?>
<style>
  body {
    background-image: url('./assets/images/c3.jpg');
    background-size: cover;
    background-position: center;
  }
</style>
  <!-- Admin Dashboard -->
  <section class="dashboard">
    <h1>Welcome, Admin!</h1>
    <div class="dashboard-grid">
      <!-- Total Users -->
      <div class="card">
        <h3>Total Users</h3>
        <p>452</p>
      </div>
      <!-- Total Claims -->
      <div class="card">
        <h3>Total Claims</h3>
        <p>128</p>
      </div>
      <!-- Reports Received -->
      <div class="card">
        <h3>Reports Received</h3>
        <p>34</p>
      </div>
      <!-- System Alerts -->
      <div class="card">
        <h3>System Alerts</h3>
        <p>5</p>
      </div>
    </div>
  </section>

  <!-- User Management -->
  <section class="user-management">
    <h2>Manage Users</h2>
    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      <tr>
        <td>John Doe</td>
        <td>john@example.com</td>
        <td>Farmer</td>
        <td>Active</td>
        <td><button>Block</button></td>
      </tr>
      <tr>
        <td>Jane Smith</td>
        <td>jane@example.com</td>
        <td>Admin</td>
        <td>Active</td>
        <td><button>Revoke</button></td>
      </tr>
    </table>
  </section>

  <!-- Reports Section -->
  <section class="reports">
    <h2>Recent Reports</h2>
    <ul>
      <li>Report #112: Crop Damage - Pending Review</li>
      <li>Report #113: Insurance Fraud - In Progress</li>
      <li>Report #114: System Issue - Resolved</li>
    </ul>
  </section>

<?php include 'includes/footer.php'; ?>