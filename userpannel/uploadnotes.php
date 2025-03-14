<?php
session_start();
require '../db/db.php';

// Ensure user is logged in
if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    echo "<script>alert('You must log in first.'); window.location='userlogin.php';</script>";
    exit();
}

$user_id = $_SESSION["user_id"]; // Get logged-in user ID

// Handle adding or updating notes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $note_id = isset($_POST["note_id"]) ? intval($_POST["note_id"]) : 0;
    $notes_title = trim($_POST["notes_title"]);
    $notes_subject = trim($_POST["notes_subject"]);
    $description = trim($_POST["description"]);
    $pdf_filename = null;

    // Fetch old file name if updating
    if ($note_id > 0) {
        $stmt = $conn->prepare("SELECT pdf FROM notes WHERE id = ?");
        $stmt->bind_param("i", $note_id);
        $stmt->execute();
        $stmt->bind_result($old_pdf);
        $stmt->fetch();
        $stmt->close();
    }

    // Handle file upload
    if (!empty($_FILES['pdf_file']['name'])) {
        $target_dir = "uploads/";
        $pdf_filename = time() . "_" . basename($_FILES["pdf_file"]["name"]);
        $target_file = $target_dir . $pdf_filename;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file_type !== "pdf") {
            echo "<script>alert('Only PDF files are allowed!');</script>";
            exit();
        } elseif (!move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            echo "<script>alert('Error uploading file!');</script>";
            exit();
        } else {
            // Delete old file if new file is uploaded
            if ($note_id > 0 && !empty($old_pdf)) {
                unlink("uploads/" . $old_pdf);
            }
        }
    } else {
        // Keep old file if no new file is uploaded
        $pdf_filename = $note_id > 0 ? $old_pdf : null;
    }

    if ($note_id > 0) {
        // Update existing note
        $stmt = $conn->prepare("UPDATE notes SET notes_title = ?, notes_subject = ?, description = ?, pdf = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $notes_title, $notes_subject, $description, $pdf_filename, $note_id);
        $stmt->execute();
        echo "<script>alert('Note updated successfully!'); window.location='uploadnotes.php';</script>";
    } else {
        // Insert new note
        $stmt = $conn->prepare("INSERT INTO notes (user_id, notes_title, notes_subject, description, pdf, view_count, download_count) VALUES (?, ?, ?, ?, ?, 0, 0)");
        $stmt->bind_param("issss", $user_id, $notes_title, $notes_subject, $description, $pdf_filename);
        $stmt->execute();
        echo "<script>alert('Note added successfully!'); window.location='uploadnotes.php';</script>";
    }
    $stmt->close();
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
        unlink("uploads/" . $pdf_filename);
    }

    // Delete note from database
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: uploadnotes.php");
    exit();
}

// Fetch all notes for the logged-in user
$stmt = $conn->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
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
    </style>
    <script>
        function editNote(id, title, subject, description, pdf) {
            document.getElementById("note_id").value = id;
            document.getElementById("notes_title").value = title;
            document.getElementById("notes_subject").value = subject;
            document.getElementById("description").value = description;

            // Change button text to "Update Note"
            document.getElementById("submit_button").innerText = "Update Note";

            // Optional: Scroll to the form for better UX
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>

    <script>
        function editNote(id, title, subject, description, pdf) {
            document.getElementById("note_id").value = id;
            document.getElementById("notes_title").value = title;
            document.getElementById("notes_subject").value = subject;
            document.getElementById("description").value = description;

            document.getElementById("submit_button").innerText = "Update Note";
            document.getElementById("cancel_button").style.display = "inline-block"; // Show Cancel button
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function resetForm() {
            document.getElementById("noteForm").reset(); // Reset all input fields
            document.getElementById("note_id").value = ""; // Clear hidden note_id
            document.getElementById("submit_button").innerText = "Add Note"; // Change button text back to default
            // document.getElementById("cancel_button").style.display = "none"; // Hide Cancel button
        }
    </script>
    
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="navbar">
        <div class="logo">NotesHub</div>
        <div>
            <a href="./dashboard.php">Home</a>
            <a href="./uploadnotes.php">Upload & Manage Notes</a>
            <a href="./profile.php">View & Edit Profile</a>
            <a href="./logout.php">Logout</a>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Add / Edit Note Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #2c3e50, #34495e); font-weight: bold;">
                Add / Edit Note
            </div>
            <div class="card-body" style="background-color: #f8f9fa; border-radius: 0 0 8px 8px;">
                <form id="noteForm" method="POST" action="uploadnotes.php" enctype="multipart/form-data">
                    <input type="hidden" name="note_id" id="note_id">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="notes_title" id="notes_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="notes_subject" id="notes_subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload PDF (optional)</label>
                        <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                    </div>
                    <button type="button" id="cancel_button" class="btn btn-secondary" onclick="resetForm()">Cancel</button>

                    <button type="submit" name="add_note" id="submit_button" class="btn btn-primary">
                        Add Note
                    </button>

                </form>
            </div>
        </div>

        <!-- Display Notes -->
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #2c3e50, #34495e); font-weight: bold;">
                Your Notes
            </div>
            <div class="card-body" style="background-color: #f8f9fa; border-radius: 0 0 8px 8px;">
                <?php while ($note = $result->fetch_assoc()) : ?>
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm p-3" style="border-radius: 8px; background: white;">
                        <h5 class="mb-1 text-dark"><?php echo htmlspecialchars($note['notes_title']); ?></h5>
                        <p class="mb-1 text-secondary"><strong>Subject:</strong> <?php echo htmlspecialchars($note['notes_subject']); ?></p>
                        <p class="mb-1 text-secondary"><strong>Description:</strong> <?php echo htmlspecialchars($note['description']); ?></p>
                        <p class="small text-muted">Created on: <?php echo $note['created_at']; ?></p>

                        <!-- View PDF Button -->
                        <!-- View PDF Button -->
                        <?php if (!empty($note['pdf'])) : ?>
                            <a href="uploads/<?php echo $note['pdf']; ?>"
                                class="btn btn-info btn-sm"
                                target="_blank"
                                rel="noopener noreferrer">
                                View PDF
                            </a>
                        <?php endif; ?>


                        <!-- Edit and Delete Buttons -->
                        <button class="btn btn-warning btn-sm" onclick="editNote(
                        '<?php echo $note['id']; ?>',
                        '<?php echo addslashes($note['notes_title']); ?>',
                        '<?php echo addslashes($note['notes_subject']); ?>',
                        '<?php echo addslashes($note['description']); ?>',
                        '<?php echo addslashes($note['pdf']); ?>'
                    )">Edit</button>

                        <a href="uploadnotes.php?delete=<?php echo $note['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

</body>

</html>