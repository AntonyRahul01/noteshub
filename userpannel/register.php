<?php
include "../db/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Secure hashing

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now login.'); window.location='userlogin.php';</script>";
    } else {
        echo "<script>alert('Error: Email already exists!'); window.location='userlogin.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
