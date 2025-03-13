<?php
session_start();
require '../db/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: userlogin.php");
    exit();
}


// Handle new note submission with file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_note'])) {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $pdf_filename = null;

    // Check if a file is uploaded
    if (!empty($_FILES['pdf_file']['name'])) {
        $target_dir = "uploads/";
        $pdf_filename = basename($_FILES["pdf_file"]["name"]);
        $target_file = $target_dir . $pdf_filename;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        if ($file_type != "pdf") {
            echo "<script>alert('Only PDF files are allowed!');</script>";
        } else {
            if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
                // File uploaded successfully
            } else {
                echo "<script>alert('Error uploading file!');</script>";
            }
        }
    }

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO notes (title, content, pdf_filename) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $pdf_filename);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle note deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Get file name before deleting
    $stmt = $conn->prepare("SELECT pdf_filename FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($pdf_filename);
    $stmt->fetch();
    $stmt->close();

    // Delete file if exists
    if (!empty($pdf_filename)) {
        unlink("uploads/" . $pdf_filename);
    }

    // Delete note from database
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: notes.php");
    exit();
}

// Fetch all notes
$result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
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
            <a href="./uploadnotes.php">Upload Notes</a>
            <a href="./profile.php">View & Edit Profile</a>
            <a href="./logout.php">Logout</a>
        </div>
    </div>

    <!-- Add Note Form -->
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-white">Add New Note</div>
            <div class="card-body">
                <form method="POST" action="notes.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload PDF (optional)</label>
                        <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                    </div>
                    <button type="submit" name="add_note" class="btn btn-primary">Add Note</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">Your Notes</div>
            <div class="card-body">
                <?php while ($note = $result->fetch_assoc()) : ?>
                    <div class="note-card mb-3">
                        <h5><?php echo htmlspecialchars($note['title']); ?></h5>
                        <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
                        <small class="text-muted">Created on: <?php echo $note['created_at']; ?></small>
                        <?php if (!empty($note['pdf_filename'])) : ?>
                            <br><a href="uploads/<?php echo $note['pdf_filename']; ?>" class="btn btn-info btn-sm mt-2" target="_blank">View PDF</a>
                        <?php endif; ?>
                        <a href="notes.php?delete=<?php echo $note['id']; ?>" class="btn btn-danger btn-sm float-end" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

</body>

</html>