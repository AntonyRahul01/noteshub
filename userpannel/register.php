<?php 
include "../db/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Secure password hashing

    // Set profile picture as NULL initially
    $profile_picture = NULL;

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $profile_picture);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now login.'); window.location='userlogin.php';</script>";
    } else {
        echo "<script>alert('Error: Username or Email already exists!'); window.location='userlogin.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
