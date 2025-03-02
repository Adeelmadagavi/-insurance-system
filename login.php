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
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
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
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userType == 'user') {
        $query = "SELECT * FROM users WHERE email = ?";
    } else if ($userType == 'admin') {
        $query = "SELECT * FROM admins WHERE email = ?";
    } else {
        echo "<script>showToast('Invalid user type', 'error');</script>";
        exit();
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['password']) { // If password matches
            $_SESSION['user_id'] = $row['user_id'];
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
        echo "<script>showToast('Invalid email or user type', 'error');</script>";
    }
}
?>
