<?php include 'includes/header.php'; ?>

<style>
  body {
    background-image: url('./assets/images/h1.jpg');
    background-size: cover;
    background-position: center;
  }
</style>

<script>
function showToast(message, type) {
    Toastify({
        text: message,
        duration: 3000,
        gravity: "top", 
        position: "right",
        backgroundColor: type === "success" ? "green" : "red",
        stopOnFocus: true
    }).showToast();
}
</script>

<div class="form-section">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <div class="input-group">
            <label for="userType">User Type</label>
            <select name="userType" id="userType" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        
        <div class="input-group">
            <label for="loginId">Email or Phone Number</label>
            <input type="text" id="loginId" name="loginId" placeholder="Enter your email or phone number" required>
        </div>
        
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        
        <button type="submit">Log In</button>
    </form>
    <div class="form-footer">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>
<?php
include 'includes/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userType = $_POST['userType'];
    $loginId = $_POST['loginId']; // This can be either email or phone number
    $password = $_POST['password'];

    // Determine the table based on user type
    if ($userType == 'user') {
        $table = 'users';
    } else if ($userType == 'admin') {
        $table = 'admins';
    } else {
        echo "<script>showToast('Invalid user type', 'error');</script>";
        exit();
    }

    // Check if the input is an email or phone number
    if (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
        // If it's an email
        $query = "SELECT * FROM $table WHERE email = ?";
    } else if (preg_match('/^[0-9]{10,15}$/', $loginId)) {
        // If it's a phone number
        $query = "SELECT * FROM $table WHERE phone_number = ?";
    } else {
        echo "<script>showToast('Invalid email or phone number format', 'error');</script>";
        exit();
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $loginId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the password (plain text comparison for demonstration; use password_verify() for hashed passwords)
        if ($password === $row['password']) { // Replace with password_verify() if using hashed passwords
            $_SESSION['user_id'] = $row['user_id'] ?? $row['admin_id']; // Use appropriate ID field
            $_SESSION['user_type'] = $userType;

            echo "<script>
                showToast('Login successful! Redirecting...', 'success');
                setTimeout(() => { 
                    window.location.href = '". ($userType == 'user' ? 'farmer_dashboard.php' : 'admin.php') ."';
                }, 1500);
            </script>";
        } else {
            echo "<script>showToast('Invalid password', 'error');</script>";
        }
    } else {
        echo "<script>showToast('Invalid email, phone number, or user type', 'error');</script>";
    }
}
?>