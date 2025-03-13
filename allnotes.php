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

        .notes-title {
            max-width: 1200px;
            margin: 10px auto;
            animation: fadeIn 1s ease-in-out;
        }

        /* Notes Section */
        .notes-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* 4 cards per row */
            gap: 10px;
        }

        @media (max-width: 1024px) {
            .notes-container {
                grid-template-columns: repeat(3, 1fr);
                /* 3 cards per row */
            }
        }

        @media (max-width: 768px) {
            .notes-container {
                grid-template-columns: repeat(2, 1fr);
                /* 2 cards per row */
            }
        }

        @media (max-width: 480px) {
            .notes-container {
                grid-template-columns: repeat(1, 1fr);
                /* 1 card per row */
            }
        }

        .note-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s ease-in-out;
            animation: fadeIn 1s ease-in-out;
        }

        .note-card:hover {
            transform: translateY(-5px);
        }

        .pdf-icon {
            font-size: 40px;
            color: #e74c3c;
        }

        .note-details {
            flex-grow: 1;
        }

        .note-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        .note-meta {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
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
    </style>
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
        <h1>My Notes</h1>
        <p>Access and organize all your important notes in one place.</p>
    </div>

    <!-- Notes Section -->
    <div class="notes-title">
        <h1>All Notes</h1>
    </div>
    <div class="notes-container">
        <!-- Note Cards -->
        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">JavaScript Basics</div>
                <div class="note-meta">Uploaded: March 10, 2025 | Size: 1.2MB</div>
            </div>
        </div>

        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">React Components Guide</div>
                <div class="note-meta">Uploaded: March 8, 2025 | Size: 900KB</div>
            </div>
        </div>

        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">Node.js API Development</div>
                <div class="note-meta">Uploaded: March 5, 2025 | Size: 2.1MB</div>
            </div>
        </div>

        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">MongoDB CRUD Operations</div>
                <div class="note-meta">Uploaded: March 3, 2025 | Size: 1.5MB</div>
            </div>
        </div>

        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">AWS Lambda & API Gateway</div>
                <div class="note-meta">Uploaded: March 1, 2025 | Size: 1.8MB</div>
            </div>
        </div>

        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">MySQL Database Design</div>
                <div class="note-meta">Uploaded: Feb 25, 2025 | Size: 2.4MB</div>
            </div>
        </div>

        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">Python Data Science</div>
                <div class="note-meta">Uploaded: Feb 20, 2025 | Size: 3.1MB</div>
            </div>
        </div>

        <div class="note-card">
            <i class="fas fa-file-pdf pdf-icon"></i>
            <div class="note-details">
                <div class="note-title">Docker & Kubernetes</div>
                <div class="note-meta">Uploaded: Feb 15, 2025 | Size: 1.9MB</div>
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