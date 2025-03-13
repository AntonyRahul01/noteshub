<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: userlogin.php");
    exit();
}

include("../db/db.php"); // Database connection

$user_id = $_SESSION["user_id"];
$success_message = "";
$error_message = "";

// Fetch user details
$query = "SELECT full_name, email, profile_picture, username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $profile_picture = $user['profile_picture'];

    // Handle profile picture upload
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
        } else {
            $error_message = "Error uploading profile picture.";
        }
    }

    if (!empty($full_name) && !empty($email)) {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET full_name = ?, email = ?, password = ?, profile_picture = ?, username = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssssi", $full_name, $email, $hashed_password, $profile_picture, $username, $user_id);
        } else {
            $update_query = "UPDATE users SET full_name = ?, email = ?, profile_picture = ?, username = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssssi", $full_name, $email, $profile_picture, $username, $user_id);
        }

        if ($stmt->execute()) {
            $success_message = "Profile updated successfully!";
        } else {
            $error_message = "Error updating profile.";
        }
    } else {
        $error_message = "Full Name and Email cannot be empty.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotesHub - Organize Your Thoughts</title>
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

        .profile-container {
    width: 40%;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.profile-container h2 {
    margin-bottom: 20px;
    color: #2c3e50;
}

.profile-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.profile-pic {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #2c3e50;
    margin-bottom: 15px;
}

input[type="file"] {
    margin-bottom: 15px;
}

label {
    align-self: flex-start;
    font-weight: bold;
    margin-top: 10px;
    color: #34495e;
}

input,
button {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border-radius: 5px;
    font-size: 16px;
    border: 1px solid #ccc;
    outline: none;
}

input:focus {
    border-color: #2c3e50;
}

button {
    background-color: #2c3e50;
    color: white;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
    margin-top: 20px;
}

button:hover {
    background-color: #1a252f;
}

    </style>
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">NotesHub</div>
        <div>
            <a href="./dashboard.php">Home</a>
            <a href="#">Upload Notes</a>
            <a href="./profile.php">View & Edit Profile</a>
            <a href="./logout.php">Logout</a>
        </div>
    </div>
    <!-- Profile Container -->
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <?php if (!empty($success_message)) {
            echo "<p class='message'>$success_message</p>";
        } ?>
        <?php if (!empty($error_message)) {
            echo "<p class='error'>$error_message</p>";
        } ?>

        <form method="POST" enctype="multipart/form-data">
            <img src="<?php echo $user['profile_picture'] ?: 'default.png'; ?>" class="profile-pic" alt="">
            <input type="file" name="profile_picture" accept="image/*">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            <label>User Name:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>New Password (optional):</label>
            <input type="password" name="password">
            <button type="submit">Update Profile</button>
        </form>
    </div>

</body>

</html>