<?php
session_start();
include "../db/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $full_name, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["full_name"] = $full_name;
        echo "<script>alert('Login successful!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid email or password.'); window.location='userlogin.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
