<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../db/db.php'; // Database connection

// Fetch Users
$sql = "SELECT * FROM users ORDER BY id DESC";

// Count total users
$userCountQuery = "SELECT COUNT(*) AS total_users FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$totalUsers = $userCountRow['total_users'];

// Count total notes
$notesCountQuery = "SELECT COUNT(*) AS total_notes FROM notes";
$notesCountResult = mysqli_query($conn, $notesCountQuery);
$notesCountRow = mysqli_fetch_assoc($notesCountResult);
$totalNotes = $notesCountRow['total_notes'];

// Count total feedbacks
$fbCountQuery = "SELECT COUNT(*) AS total_feedbacks FROM feedbacks";
$fbCountResult = mysqli_query($conn, $fbCountQuery);
$fbCountRow = mysqli_fetch_assoc($fbCountResult);
$totalfb = $fbCountRow['total_feedbacks'];

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NotesHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            background-color: #f0f4f8;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffd700;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 12px 15px;
            display: block;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #ffd700;
            color: black;
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
            padding: 10px;
            flex-grow: 1;
            min-height: 100vh;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .dashboard-header h2 {
            font-size: 25px;
            font-weight: bold;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 280px;
            text-align: center;
            justify-content: center;
            transition: 0.3s;
        }

        .card:hover {
            background: #ffd700;
            transform: translateY(-4px);
        }

        .card h4 {
            color: #2c3e50;
            font-size: 18px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #e74c3c;
        }

        /* Users List */
        .users-list {
            margin-top: 30px;
        }

        .users-list h4{
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center; /* Center-align text */
            vertical-align: middle; /* Align vertically */
        }

        table th {
            background: #2c3e50;
            color: white;
        }

        table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Profile Picture */
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #2c3e50;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 230px;
            }

            .cards {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                width: 200px;
                padding: 15px;
            }

            .main-content {
                margin-left: 210px;
                padding: 15px;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: center;
            }

            table th,
            table td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>NotesHub Admin</h2>
        <a href="./dashboard.php">Dashboard</a>
        <a href="./feedback.php">Feedbacks</a>
        <a href="./notespage.php">Notes</a>
        <a href="./logout.php">Logout</a>
    </div>

    <div class="main-content">
        <div class="dashboard-header">
            <h2>Dashboard</h2>
        </div>

        <div class="cards">
            <div class="card">
                <h4>Total Users</h4>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="card">
                <h4>Notes Created</h4>
                <p><?php echo $totalNotes; ?></p>
            </div>
            <div class="card">
                <h4>Total Feedbacks</h4>
                <p><?php echo $totalfb; ?></p>
            </div>
        </div>

        <div class="users-list">
            <h4>Users List</h4>
            <table>
                <thead>
                <tr>
                        <th>S.no</th>
                        <th>Profile Picture</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $serial = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $serial++ . "</td>"; // Serial Number
                            echo "<td><img src='../userpannel/" . htmlspecialchars($row['profile_picture']) . "' class='profile-img' alt='Profile'></td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>