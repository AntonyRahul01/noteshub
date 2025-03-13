<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'noteshub';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user's uploaded notes count
$stmt = $pdo->prepare("SELECT COUNT(*) as total_notes FROM notes WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$total_notes = $stmt->fetch(PDO::FETCH_ASSOC)['total_notes'];

// Fetch user's uploaded subjects count
$stmt = $pdo->prepare("SELECT COUNT(DISTINCT subject) as total_subjects FROM notes WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$total_subjects = $stmt->fetch(PDO::FETCH_ASSOC)['total_subjects'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .navbar a:hover {
            color: #ffd700;
        }
        .dashboard {
            padding: 20px;
        }
        .welcome-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .stat-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 30%;
        }
        .stat-box h3 {
            margin: 0;
            font-size: 36px;
            color: #333;
        }
        .stat-box p {
            margin: 10px 0 0;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div>ONSS</div>
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="notes.php">Notes</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard">
        <div class="welcome-message">
            Hello, <?php echo $user['username']; ?>! Welcome to your panel.
        </div>

        <!-- Statistics -->
        <div class="stats">
            <div class="stat-box">
                <h3><?php echo $total_subjects; ?></h3>
                <p>Total Uploaded Subject Notes</p>
                <a href="notes.php">View Detail</a>
            </div>
            <div class="stat-box">
                <h3><?php echo $total_notes; ?></h3>
                <p>Total Uploaded Notes File</p>
                <a href="notes.php">View Detail</a>
            </div>
        </div>
    </div>
</body>
</html>