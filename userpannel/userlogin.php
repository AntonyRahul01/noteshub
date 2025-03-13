<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotesHub - Login & Register</title>
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


        /* Form Container */
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            color: #2c3e50;
            animation: fadeIn 1s ease-in-out;
        }

        .container h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease-in-out;
        }

        .input-group input:focus {
            border-color: #2c3e50;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .btn:hover {
            background: #ffd700;
            color: #2c3e50;
        }

        .switch {
            margin-top: 15px;
            font-size: 14px;
        }

        .switch a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .switch a:hover {
            color: #c0392b;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

       /* Form Container */
       .form-login {
            margin-top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">NotesHub</div>
        <div>
            <a href="../index.php">Home</a>
            <a href="../allnotes.php">Notes</a>
            <a href="#">About us</a>
            <a href="../contact.php">Contact Us & Feedback</a>
            <a href="../userpannel/userlogin.php">Login/Signup</a>
        </div>
    </div>

    <!-- Login Form -->
    <div class="form-login">
        <div class="container" id="login-form">
            <h2>Login to NotesHub</h2>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p class="switch">Don't have an account? <a href="#" onclick="toggleForm()">Register</a></p>
        </div>

        <!-- Register Form -->
        <div class="container" id="register-form" style="display: none;">
            <h2>Create a NotesHub Account</h2>
            <form action="register.php" method="POST">
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter your full name" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Create a password" required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
            <p class="switch">Already have an account? <a href="#" onclick="toggleForm()">Login</a></p>
        </div>
    </div>
    <script>
        function toggleForm() {
            const loginForm = document.getElementById("login-form");
            const registerForm = document.getElementById("register-form");

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
            }
        }
    </script>

    <!-- Footer -->
    <div class="footer">
        <h2>NotesHub on Android</h2>
        <p>Get notes anywhere, anytime!</p>
        <a href="#">
            <img src="../assets/images/image.png" alt="Google Play">
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