<?php
session_start();
require '../db/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
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
    <title>Admin Notes | NotesHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Admin Notes</h2>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

        <!-- Add Note Form -->
        <div class="card mb-4">
            <div class="card-header">Add New Note</div>
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

        <!-- Notes List -->
        <div class="card">
            <div class="card-header">Your Notes</div>
            <div class="card-body">
                <?php while ($note = $result->fetch_assoc()) : ?>
                    <div class="border p-3 mb-3">
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
