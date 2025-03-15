<?php
session_start();
require '../db/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// Fetch all feedbacks
$result = $conn->query("SELECT * FROM feedbacks ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notes | NotesHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            background-color: #f0f4f8;
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

        .feedback-list {
            margin-top: 30px;
        }

        .feedback-list h4 {
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
            text-align: center;
            /* Center-align text */
            vertical-align: middle;
            /* Align vertically */
        }

        table th {
            background: #2c3e50;
            color: white;
        }

        table tbody tr:hover {
            background-color: #f9f9f9;
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

        <div class="feedback-list">
            <h4>User Feedbacks</h4>
            <table>
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Feedback</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    while ($row = $result->fetch_assoc()) {
                        $email = htmlspecialchars($row['email']);
                        $subject = "Response to your Feedback";
                        echo "<tr>";
                        echo "<td>" . $sno . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                        echo "<td>" . date("d M Y", strtotime($row['created_at'])) . "</td>";
                        echo "<td>
                        <a href='https://mail.google.com/mail/?view=cm&fs=1&to=$email&su=" . urlencode($subject) . "' target='_blank' class='btn btn-primary'>
                            Reply
                        </a>
                      </td>";
                        echo "</tr>";
                        $sno++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>