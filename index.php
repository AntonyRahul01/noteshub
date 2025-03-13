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

        .navbar .logo a {
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

        /* Footer */
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

        /* Content Section */
        .content-section {
            background: #ffffff;
            padding: 60px 20px;
            text-align: center;
            cursor: context-menu;
            animation: fadeIn 1s ease-in-out;
        }

        .content-section h2 {
            font-size: 36px;
            color: #2c3e50;
        }

        .content {
            max-width: 900px;
            margin: auto;
            text-align: justify;
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }

        .content p {
            margin-bottom: 20px;
        }

        /* Statistics Section */
        .statistics {
            cursor: context-menu;
            padding: 90px 20px;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            /* Gradient dark blue */
            color: white;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .statistics h2 {
            font-size: 40px;
            color: #ffd700;
            margin-bottom: 40px;
            transition: color 0.3s ease-in-out;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            max-width: 800px;
            margin: auto;
        }

        .stat {
            text-align: center;
        }

        .stat h3 {
            font-size: 48px;
            margin: 0;
            color: #ffd700;
            /* Gold color for numbers */
            transition: color 0.3s ease-in-out;
        }

        .stat p {
            font-size: 18px;
            color: #ddd;
            transition: color 0.3s ease-in-out;
        }

        .stat:hover p {
            color: white;
            /* White text on hover */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo"><a href="./admin/login.php">NotesHub</a></div>
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
        <h1>Organize Your Thoughts</h1>
        <p>Keep your notes safe and accessible from anywhere.</p>
    </div>

    <!-- Features Section -->
    <div class="features">
        <div class="feature-card">
            <h3>Easy Note-Taking</h3>
            <p>Write and save your thoughts instantly.</p>
        </div>
        <div class="feature-card">
            <h3>Cloud Sync</h3>
            <p>Access your notes from any device.</p>
        </div>
        <div class="feature-card">
            <h3>Secure Storage</h3>
            <p>All your notes are encrypted for safety.</p>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="statistics">
        <h2>Our Impact</h2>
        <div class="stats-container">
            <div class="stat">
                <h3>10K+</h3>
                <p>Happy Students</p>
            </div>
            <div class="stat">
                <h3>5K+</h3>
                <p>Uploaded Notes</p>
            </div>
            <div class="stat">
                <h3>100+</h3>
                <p>Subjects Covered</p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <h2>Why Choose NotesHub?</h2>
        <div class="content">
            <p>NotesHub is an online platform that enables students to share and access high-quality study materials with ease. Whether you are looking for class notes, exam preparation materials, or reference guides, NotesHub is here to help.</p>
            <p>Our platform is designed to make learning more accessible and efficient. Students can browse various subjects, find notes curated by peers, and contribute by uploading their own materials to help others.</p>
            <p>Join thousands of learners who rely on NotesHub to stay ahead in their studies. No matter your subject or level, our diverse collection of notes ensures that you always have the right resources at your fingertips.</p>
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