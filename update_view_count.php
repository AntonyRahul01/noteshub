<?php
include './db/db.php'; // Include database connection

if (isset($_POST['id'])) {
    $noteId = mysqli_real_escape_string($conn, $_POST['id']);

    // Update view count
    $sql = "UPDATE notes SET view_count = view_count + 1 WHERE id = '$noteId'";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
