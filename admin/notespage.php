<?php
session_start();
require '../db/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle note deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Get file name before deleting
    $stmt = $conn->prepare("SELECT pdf FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($pdf_filename);
    $stmt->fetch();
    $stmt->close();

    // Delete file if exists
    if (!empty($pdf_filename)) {
        unlink("../userpannel/uploads/" . $pdf_filename);
    }

    // Delete note from database
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: notespage.php");
    exit();
}

$result = $conn->query("
    SELECT notes.*, users.username 
    FROM notes 
    JOIN users ON notes.user_id = users.id 
    ORDER BY notes.created_at DESC
");


// Fetch all notes
// $result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
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

        /* Recent Activity */
        .recent-activity {
            margin-top: 30px;
        }

        .notes-list {
            margin-top: 30px;
        }

        .notes-list h4 {
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

        <div class="notes-list">
            <h4>Notes List</h4>
            <!-- Search Bars -->
            <div style="text-align: center; margin: 20px;">
                <input type="text" id="searchTitle" placeholder="Search by Title" onkeyup="filterNotes()" style="padding: 10px; width: 250px; border-radius: 5px; border: 1px solid #ccc;">
                <input type="text" id="searchSubject" placeholder="Search by Subject" onkeyup="filterNotes()" style="padding: 10px; width: 250px; margin-right: 10px; border-radius: 5px; border: 1px solid #ccc;">
                <input type="text" id="searchUsername" placeholder="Search by Username" onkeyup="filterNotes()" style="padding: 10px; width: 250px; margin-right: 10px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1; // Serial number counter
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $sno . "</td>";
                        echo "<td>" . htmlspecialchars($row['notes_title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['notes_subject']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>
                <a href='../userpannel/uploads/" . htmlspecialchars($row['pdf']) . "' target='_blank' class='btn btn-primary btn-sm'>View</a>
                <a href='?delete=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this note?\")'>Delete</a>
              </td>";
                        echo "</tr>";
                        $sno++;
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
    <script>
        function filterNotes() {
            let searchTitle = document.getElementById("searchTitle").value.toLowerCase();
            let searchSubject = document.getElementById("searchSubject").value.toLowerCase();
            let searchUsername = document.getElementById("searchUsername").value.toLowerCase();
            let table = document.querySelector("table tbody");
            let rows = table.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let title = rows[i].getElementsByTagName("td")[1].textContent.toLowerCase();
                let subject = rows[i].getElementsByTagName("td")[2].textContent.toLowerCase();
                let username = rows[i].getElementsByTagName("td")[3].textContent.toLowerCase();

                if (title.includes(searchTitle) && subject.includes(searchSubject) && username.includes(searchUsername)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>

</body>

</html>