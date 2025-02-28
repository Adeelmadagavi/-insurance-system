<?php include 'includes/header.php'; ?>

<style>
  body {
    background-image: url('./assets/images/h1.jpg');
    background-size: cover;
    background-position: center;
  }
</style>
<div class="form-section">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="userType">User Type:</label>
            <select name="userType" id="userType" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

<?php
include 'includes/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userType == 'user') {
        $query = "SELECT * FROM users WHERE email = ?";
    } else if ($userType == 'admin') {
        $query = "SELECT * FROM admins WHERE email = ?";
    } else {
        echo "Invalid user type.";
        exit();
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) { // Match password without hash
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $userType;

            if ($userType == 'user') {
                header("Location: farmer_dashboard.php");
            } else if ($userType == 'admin') {
                header("Location: admin.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "<center>No user found with this email.</center>";
    }
}
?>

<?php include 'includes/footer.php'; ?>