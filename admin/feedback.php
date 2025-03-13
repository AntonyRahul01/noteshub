<?php
session_start();
require '../db/db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle feedback deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Feedback deleted successfully!'); window.location='feedback.php';</script>";
    } else {
        echo "<script>alert('Error deleting feedback!');</script>";
    }
    $stmt->close();
}

// Fetch all feedbacks
$result = $conn->query("SELECT * FROM feedbacks ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedbacks | NotesHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">User Feedbacks</h2>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">All Feedbacks</div>
            <div class="card-body">
                <?php while ($feedback = $result->fetch_assoc()) : ?>
                    <div class="border rounded p-3 mb-3 bg-light">
                        <h5 class="text-dark fw-bold mb-1">
                            <?php echo htmlspecialchars($feedback['name']); ?>
                            <span class="text-muted small">(<?php echo htmlspecialchars($feedback['email']); ?>)</span>
                        </h5>
                        <p class="text-secondary mb-2"><?php echo nl2br(htmlspecialchars($feedback['message'])); ?></p>
                        <small class="text-muted">Submitted on: <?php echo $feedback['created_at']; ?></small>
                        <div class="text-end mt-2">
                            <a href="feedback.php?delete_id=<?php echo $feedback['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this feedback?');">
                               Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

