<?php
include './db/db.php'; // Include database connection

if (isset($_GET['id'])) {
    $noteId = intval($_GET['id']); // Ensure ID is an integer

    // Update the download count
    $sql = "UPDATE notes SET dwnld_count = dwnld_count + 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $noteId);
    mysqli_stmt_execute($stmt);

    // Fetch the PDF file path from the database
    $query = "SELECT pdf FROM notes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $noteId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $filePath = "C:/xampp/htdocs/noteshub/userpannel/uploads/" . basename($row['pdf']);

        if (file_exists($filePath)) {
            // Force download
            header("Content-Description: File Transfer");
            header("Content-Type: application/pdf");
            header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . filesize($filePath));
            readfile($filePath);
            exit();
        } else {
            echo "Error: File not found!";
        }
    } else {
        echo "Error: Invalid file ID!";
    }
}
