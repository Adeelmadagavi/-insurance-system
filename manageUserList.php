
<?php

require './includes/config.php';


$sql = "SELECT user_id, full_name, phone_number, email, password, registration_date FROM users";
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) {
        $users[] = array(
            'id' => $row['user_id'],
            'Name' => $row['full_name'],
            'Phone Number' => $row['phone_number'],
            'email' => $row['email'],
            'password' => $row['password'],
            'date' => $row['registration_date']
        );
    }
} else {
    echo "0 results";
}


$conn->close();
?>
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
        .user-management {
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
    </style>
</head>
<body>
  
    <section class="user-management">
        <h2>Manage Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['Name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['Phone Number']); ?></td>
                            <td><?php echo htmlspecialchars($user['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
