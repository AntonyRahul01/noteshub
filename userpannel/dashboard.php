<?php
session_start();
require '../db/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: userlogin.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch total notes count
$total_notes_query = "SELECT COUNT(*) FROM notes WHERE user_id = ?";
$stmt = $conn->prepare($total_notes_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_notes);
$stmt->fetch();
$stmt->close();

// Fetch total views count
$total_views_query = "SELECT SUM(view_count) FROM notes WHERE user_id = ?";
$stmt = $conn->prepare($total_views_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_views);
$stmt->fetch();
$stmt->close();

// Fetch notes data for table
$notes_query = "SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($notes_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Fetch total downloads count
$total_downloads_query = "SELECT SUM(dwnld_count) FROM notes WHERE user_id = ?";
$stmt = $conn->prepare($total_downloads_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_downloads);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotesHub - Organize Your Thoughts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
            transition: color 0.3s, transform 0.3s;
        }

        .navbar a:hover {
            color: #ffd700;
            transform: translateY(-3px);
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ffd700;
        }

        /* Features Section */
        .features {
            margin: 90px;
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 50px 20px;
            flex-wrap: wrap;
        }

        .feature-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            transition: color 0.3s, transform 0.3s;
            animation: fadeIn 1s ease-in-out;
        }

        .feature-card:hover {
            cursor: context-menu;
            background-color: #ffd700;
            transform: translateY(-5px);
        }

        .feature-card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .feature-card p {
            font-size: 16px;
            color: #555;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Styling */
        .card {
            border-radius: 12px;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            width: 350px;
            margin: auto;
        }

        .card h4 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: normal;
        }

        .card h2 {
            font-size: 32px;
            font-weight: bold;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }

        /* Table Styling */
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background: #2c3e50;
            color: white;
            font-size: 18px;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tbody tr:hover {
            background: #f0f4f8;
            transition: 0.3s;
        }
    </style>
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">NotesHub</div>
        <div>
            <a href="./dashboard.php">Home</a>
            <a href="./uploadnotes.php">Upload & Manage Notes</a>
            <a href="./profile.php">View & Edit Profile</a>
            <a href="./logout.php">Logout</a>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row text-center mb-4">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h4>Total Notes</h4>
                    <h2><?php echo $total_notes; ?></h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h4>Over All Downloads</h4>
                    <h2><?php echo $total_downloads ? $total_downloads : 0; ?></h2>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Total Number of Downloads</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sno = 1;
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td><?php echo htmlspecialchars($row['notes_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['notes_subject']); ?></td>
                        <td><?php echo $row['dwnld_count']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>