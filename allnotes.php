<?php
include './db/db.php'; // Database connection

$uploadBasePath = "http://localhost/noteshub/userpannel/uploads/";

$sql = "SELECT * FROM notes ORDER BY created_at DESC";
// Fetch notes along with user details
$sql = "SELECT notes.*, users.username 
        FROM notes 
        JOIN users ON notes.user_id = users.id 
        ORDER BY notes.created_at DESC";

$result = mysqli_query($conn, $sql);
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            align-items: stretch;
            /* Ensures uniform height */
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
            flex-direction: column;
            justify-content: space-between;
            /* height: 100%; */
            min-height: 180px; /* Ensures uniform height */
            /* Ensures all cards have the same height */
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
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .note-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        .note-subtitle {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }

        .note-description {
            font-size: 12px;
            color: #777;
            text-align: justify;
            /* overflow: hidden; */
        }

        .note-meta {
            font-size: 14px;
            color: #777;
            margin-top: 10px;
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

        /* Modal Styles */
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Modal Content */
        .modal-content {
            background: white;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            border-radius: 10px;
            position: relative;
        }

        /* Close Button Outside with Round Style */
        .close-btn {
            position: absolute;
            top: -20px;
            /* Position outside the modal */
            right: -20px;
            /* Move slightly outside */
            width: 40px;
            height: 40px;
            background: white;
            color: red;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out, background 0.3s;
        }

        .close-btn:hover {
            background: red;
            color: white;
            transform: scale(1.1);
        }

        /* PDF iframe */
        iframe {
            width: 100%;
            height: 500px;
            border: none;
        }


        .note-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .icon-btn {
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .icon-btn:hover {
            background: rgba(0, 0, 0, 0.1);
        }

        .pdf-icon {
            font-size: 40px;
            color: #e74c3c;
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
        <h1>My Notes</h1>
        <p>Access and organize all your important notes in one place.</p>
    </div>

    <!-- Notes Section -->
    <div class="notes-title">
        <h1>All Notes</h1>
    </div>

    <!-- Notes Section -->
    <div class="notes-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $filePath = $uploadBasePath . basename($row['pdf']);
                echo '<div class="note-card">
                <div class="note-details">
                    <div class="note-title">' . htmlspecialchars($row['notes_title']) . '</div>
                    <div class="note-subtitle">' . htmlspecialchars($row['notes_subject']) . '</div>
                     <div class="note-description">' . htmlspecialchars($row['description']) . '</div>
                     <div class="note-description"><strong>Author:</strong> ' . htmlspecialchars($row['username']) . ' </div>
                </div>
               
                <div class="note-meta">Uploaded: ' . date('F j, Y', strtotime($row['created_at'])) . '</div>
                <div class="note-actions">
                    <!-- Eye Icon for Viewing PDF -->
                    <i class="fas fa-eye icon-btn" style="color: #3498db;" onclick="openPdfModal(\'' . $filePath . '\')"></i>
                    
                    <!-- Download Icon for Downloading -->
                    <a href="update_download_count.php?id=' . $row['id'] . '">
                        <i class="fas fa-download icon-btn" style="color: #27ae60;"></i>
                    </a>
                </div>
              </div>';
            }
        } else {
            echo "<p>No notes available.</p>";
        }
        ?>
    </div>


    <!-- PDF Preview Modal -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closePdfModal()">&times;</span>
            <iframe id="pdfViewer" src="" allowfullscreen></iframe>
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

    <script>
        function openPdfModal(pdfUrl) {
            var pdfViewer = document.getElementById("pdfViewer");
            var modal = document.getElementById("pdfModal");

            if (pdfViewer && modal) {
                pdfViewer.src = pdfUrl;
                modal.style.display = "flex"; // Make sure it appears properly
            } else {
                console.error("PDF modal or viewer not found in the DOM.");
            }
        }

        function closePdfModal() {
            var pdfViewer = document.getElementById("pdfViewer");
            var modal = document.getElementById("pdfModal");

            if (modal) {
                modal.style.display = "none";
                if (pdfViewer) {
                    pdfViewer.src = ""; // Clear iframe to stop loading
                }
            }
        }

        // Ensure modal is hidden when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("pdfModal").style.display = "none";
        });
    </script>


</body>

</html>