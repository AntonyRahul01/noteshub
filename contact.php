<?php
include './db/db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO feedbacks (name, email, message, created_at) VALUES ('$name', '$email', '$message', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thank you for your feedback!'); window.location.href='contact.php';</script>";
        exit(); // Prevent further execution
    } else {
        echo "<script>alert('Something went wrong! Please try again.');</script>";
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

        /* Notification Banner */
        .notification {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            animation: fadeIn 1s ease-in-out;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 200px 20px;
            background-image: url('./assets/images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            position: relative;
            animation: slideUp 1s ease-in-out;
            /* animation: fadeIn 1s ease-in-out; */
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero h1,
        .hero p {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 20px;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            text-align: center;
            padding: 15px 10px;
            margin-top: 40px;
            font-family: 'Arial', sans-serif;
            animation: fadeIn 1s ease-in-out;
        }

        .footer h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .footer p {
            margin: 3px 0;
            font-size: 14px;
        }

        .footer img {
            width: 150px;
            /* Reduced size */
            margin: 8px 0;
            transition: transform 0.3s ease-in-out;
        }

        .footer img:hover {
            transform: scale(1.05);
        }

        .footer-links {
            margin: 8px 0;
        }

        .footer-links a {
            color: #f1c40f;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            margin: 0 6px;
            transition: color 0.3s ease-in-out;
        }

        .footer-links a:hover {
            color: #e67e22;
        }

        .footer .version {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 6px;
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

        /* Contact Form */
        /* Contact Form Styling */
        .contact-form {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeIn 1s ease-in-out;
        }

        .contact-form h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .contact-form p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }

        .contact-form textarea {
            resize: none;
            height: 120px;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #34495e;
            outline: none;
            box-shadow: 0px 0px 5px rgba(52, 73, 94, 0.3);
        }

        .contact-form button {
            width: 100%;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease-in-out, transform 0.2s;
        }

        .contact-form button:hover {
            background: linear-gradient(135deg, #1f2a38, #293742);
            transform: translateY(-2px);
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

        /* Contact Section Styling */
        .contact-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin: 40px 0;
            animation: fadeIn 1s ease-in-out;
        }

        /* Contact Information Card */
        .contact-card {
            width: 350px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: Arial, sans-serif;
            transition: transform 0.3s ease-in-out;
            border-top: 5px solid #34495e;
        }

        .contact-card:hover {
            transform: translateY(-5px);
        }

        .contact-card h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        /* Contact Details */
        .contact-item {
            display: flex;
            align-items: center;
            justify-content: start;
            gap: 12px;
            font-size: 16px;
            color: #444;
            margin: 10px 0;
            padding: 8px;
            background: #f7f7f7;
            border-radius: 8px;
            transition: background 0.3s ease-in-out;
        }

        .contact-item:hover {
            background: #eef2f7;
        }

        /* Contact Icons */
        .contact-item i {
            font-size: 20px;
            color: #34495e;
        }

        /* Contact Links */
        .contact-item a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease-in-out;
            font-weight: bold;
        }

        .contact-item a:hover {
            color: #0056b3;
        }

        /* Social Media Icons */
        .social-links {
            margin-top: 15px;
        }

        .social-icon {
            margin: 0 10px;
            font-size: 18px;
            color: #007bff;
            transition: transform 0.3s ease-in-out, color 0.3s;
        }

        .social-icon:hover {
            color: #0056b3;
            transform: scale(1.1);
        }

        .contact-btn {
            padding: 10px 15px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .contact-btn:hover {
            background: #0056b3;
        }
    </style>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">NotesHub</div>
        <div>
            <a href="./index.php">Home</a>
            <a href="./allnotes.php">Notes</a>
            <a href="#">About us</a>
            <a href="./contact.php">Contact Us & Feedback</a>
            <a href="./userpannel/userlogin.php">Login/Signup</a>
        </div>
    </div>

    <!-- Notification Banner -->
    <div class="notification">
        Welcome to NotesHub - Your Personal Note Manager!
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you! Reach out to us for any questions or feedback.</p>
    </div>


    <!-- Contact Form -->
    <!-- Display Success/Error Messages -->
    <?php if (isset($successMsg)) : ?>
        <p style="color: green; text-align: center;"><?php echo $successMsg; ?></p>
    <?php endif; ?>

    <?php if (isset($errorMsg)) : ?>
        <p style="color: red; text-align: center;"><?php echo $errorMsg; ?></p>
    <?php endif; ?>

    <div class="contact-form">
        <h2>We Value Your Feedback</h2>
        <p>Let us know your thoughts! Fill out the form below to share your experience.</p>
        <form action="contact.php" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="message">Your Feedback</label>
                <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>
            </div>

            <button type="submit">Send Message</button>
        </form>
    </div>



    <!-- Contact Information Section -->
    <div class="contact-container">
        <div class="contact-card">
            <h2>Get in Touch</h2>

            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <p>Email: <a href="mailto:support@noteshub.com">support@noteshub.com</a></p>
            </div>

            <div class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <p>Phone: <a href="tel:+1234567890">+1 (234) 567-890</a></p>
            </div>

            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>123 Education Street, Knowledge City, 12345</p>
            </div>

            <!-- Social Media Links -->
            <div class="social-links">
                <p>Follow Us:</p>
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <h2>NotesHub on Android</h2>
        <p>Get notes anywhere, anytime!</p>
        <a href="#">
            <img src="./assets/images/image.png" alt="Google Play">
        </a>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <span>|</span>
            <a href="#">Terms & Conditions</a>
        </div>
        <p class="version">© 2025 NotesHub | Version 1.0</p>
    </div>

</body>

</html>