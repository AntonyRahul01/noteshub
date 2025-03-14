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
            padding: 180px 20px;
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
        .hero p,
        .hero a {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 46px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .hero p {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 20px;
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

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        .footer p {
            margin: 0;
            font-size: 16px;
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

        /* About Us Section */
        .about-us {
            text-align: center;
            padding: 80px 20px;
            background: white;
            margin: 50px auto;
            max-width: 900px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        .about-us h2 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .about-us p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .about-features {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .about-card {
            background: #f0f4f8;
            padding: 20px;
            width: 250px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .about-card:hover {
            background-color: #ffd700;
            transform: translateY(-5px);
        }

        .about-card i {
            font-size: 40px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .about-card h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .about-card p {
            font-size: 16px;
            color: #555;
        }

        /* Hero Button */
        .hero-btn {
            display: inline-block;
            padding: 12px 25px;
            background: #ffd700;
            color: #2c3e50;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
        }

        .hero-btn:hover {
            background: #f1c40f;
            transform: translateY(-3px);
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
            <a href="./aboutus.php">About us</a>
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
        <h1>Stay Organized, Stay Productive</h1>
        <p>Manage your notes effortlessly and access them anytime, anywhere.</p>
        <a href="./allnotes.php" class="hero-btn">Get Started</a>
    </div>

    <!-- About Us Section -->
    <div class="about-us">
        <h2>About Us</h2>
        <p>Welcome to <strong>NotesHub</strong>, your ultimate personal note manager! Our mission is to help you stay organized, productive, and in control of your thoughts, whether you're jotting down quick reminders, detailed study notes, or important work-related tasks.</p>

        <div class="about-features">
            <div class="about-card">
                <i class="fas fa-check-circle"></i>
                <h3>Simple & Intuitive</h3>
                <p>A clean, user-friendly interface to help you focus on your ideas.</p>
            </div>
            <div class="about-card">
                <i class="fas fa-globe"></i>
                <h3>Accessible Anywhere</h3>
                <p>Access your notes from any device, anytime.</p>
            </div>
            <div class="about-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Secure & Reliable</h3>
                <p>Your data is protected with advanced security.</p>
            </div>
        </div>

        <p>At NotesHub, we believe that <strong>great ideas start with a simple note</strong>. Start organizing your thoughts today!</p>
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