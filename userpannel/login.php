<?php
session_start();
include "../db/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username; // Store username instead of full_name

            echo "<script>alert('Login successful!'); window.location='dashboard.php';</script>";
            exit();
        }
    }

    // If login fails
    echo "<script>alert('Invalid email or password.'); window.location='userlogin.php';</script>";

    $stmt->close();
    $conn->close();
}
