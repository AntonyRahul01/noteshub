<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
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

        .recent-activity h2 {
            font-weight: bold;
            font-size: 18px;
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

        /* Recent Activity */
        .recent-activity {
            margin-top: 30px;
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
            text-align: left;
        }

        table th {
            background: #2c3e50;
            color: white;
        }

        table tbody tr:hover {
            background-color: #f9f9f9;
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
        <a href="#">Users</a>
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
                <p>1,245</p>
            </div>
            <div class="card">
                <h4>Notes Created</h4>
                <p>4,832</p>
            </div>
            <div class="card">
                <h4>Active Users</h4>
                <p>678</p>
            </div>
        </div>

        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>Created a new note</td>
                        <td>2025-03-10</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>Edited a note</td>
                        <td>2025-03-10</td>
                    </tr>
                    <tr>
                        <td>John Doe</td>
                        <td>Created a new note</td>
                        <td>2025-03-10</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>Edited a note</td>
                        <td>2025-03-10</td>
                    </tr>
                    <tr>
                        <td>John Doe</td>
                        <td>Created a new note</td>
                        <td>2025-03-10</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>Edited a note</td>
                        <td>2025-03-10</td>
                    </tr>
                    <tr>
                        <td>John Doe</td>
                        <td>Created a new note</td>
                        <td>2025-03-10</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>