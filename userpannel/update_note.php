<?php
session_start();
require '../db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["note_id"])) {
    $note_id = intval($_POST["note_id"]);
    $updates = [];
    $params = [];
    $types = "";

    // Fetch existing values
    $stmt = $conn->prepare("SELECT notes_title, notes_subject, description, pdf FROM notes WHERE id = ?");
    $stmt->bind_param("i", $note_id);
    $stmt->execute();
    $stmt->bind_result($old_title, $old_subject, $old_description, $old_pdf);
    $stmt->fetch();
    $stmt->close();

    // Update only the fields that have changed
    if (!empty($_POST["notes_title"]) && $_POST["notes_title"] !== $old_title) {
        $updates[] = "notes_title = ?";
        $params[] = trim($_POST["notes_title"]);
        $types .= "s";
    }

    if (!empty($_POST["notes_subject"]) && $_POST["notes_subject"] !== $old_subject) {
        $updates[] = "notes_subject = ?";
        $params[] = trim($_POST["notes_subject"]);
        $types .= "s";
    }

    if (!empty($_POST["description"]) && $_POST["description"] !== $old_description) {
        $updates[] = "description = ?";
        $params[] = trim($_POST["description"]);
        $types .= "s";
    }

    // Handle file upload only if a new file is provided
    if (!empty($_FILES['pdf_file']['name'])) {
        $target_dir = "uploads/";
        $pdf_filename = time() . "_" . basename($_FILES["pdf_file"]["name"]);
        $target_file = $target_dir . $pdf_filename;

        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            if (!empty($old_pdf)) unlink("uploads/" . $old_pdf); // Delete old file
            $updates[] = "pdf = ?";
            $params[] = $pdf_filename;
            $types .= "s";
        }
    }

    // Only update if there are changes
    if (!empty($updates)) {
        $query = "UPDATE notes SET " . implode(", ", $updates) . " WHERE id = ?";
        $params[] = $note_id;
        $types .= "i";

        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script>alert('Note updated successfully!'); window.location='notes.php';</script>";
}
