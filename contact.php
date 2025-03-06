<?php
// Include the database connection file
require_once 'dbconfig.php';

// Process form submission if POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and sanitize it
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Insert data into the contacts table
    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to success page with a success query parameter
        header("Location: success.php?status=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #000; /* Black background */
            margin: 0;
            padding: 0;
            color: #fff; /* White text for better contrast */
        }

        header {
            color: white;
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.2rem;
        }

        nav a:hover {
            color: #00bcd4;
        }

        #contact-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            background-color: #222; /* Slightly lighter black for contrast */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 700px;
            margin: 30px auto;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            text-align: center;
            color: #fff;
        }

        label {
            font-size: 1.1rem;
            color: #ccc; /* Light gray for labels */
            margin-bottom: 5px;
            display: block;
            width: 100%;
        }

        input, textarea {
            font-size: 1.1rem;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #555; /* Dark gray border */
            border-radius: 6px;
            background-color: #333; /* Dark gray background */
            color: white; /* White text inside inputs */
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        input[type="text"], input[type="email"] {
            height: 45px;
        }

        textarea {
            height: 150px;
        }

        button {
            font-size: 1.2rem;
            padding: 12px 20px;
            background-color: #444; /* Dark gray for buttons */
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #555; /* Slightly lighter gray on hover */
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #ccc; /* Light gray for footer text */
            margin-top: 30px;
        }

        #success-message {
            color: limegreen;
            text-align: center;
            margin-top: 20px;
            font-size: 1.2rem;
            display: none; /* Initially hidden */
        }

        #loading-icon {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        #loading-icon img {
            width: 50px;
        }

        @media (max-width: 600px) {
            #contact-form {
                padding: 15px;
            }

            button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<header>
<nav>
    <!-- Updated Logo -->
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <img src="images/logo.png" alt="Updated Logo" style="height: 80px; width: auto; margin-right: 20px;">
        
        <!-- Navigation Links -->
        <div style="flex-grow: 1; text-align: right;">
            <a href="index.html">Home</a>
            <a href="about.html">About</a>
            <a href="services.html">Services</a>
            <a href="portfolio.html">Portfolio</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>
</nav>
</header>

<section id="contact-form">
    <h1>Get in Touch</h1>

    <form name="submit-to-google-sheet" action="contact.php" method="post">
        <div>
            <input type="text" id="name" name="name" placeholder="Your name" required>
        </div>

        <div>
            <input type="text" id="email" name="email" placeholder="Your email" required>
        </div>

        <div>
            <textarea id="message" name="message" placeholder="Your message" rows="4" style="resize: both;" required></textarea>
        </div>

        <button type="submit">Send Message</button>
        <div id="loading-icon">
            <img src="images/loading-spinner.gif" alt="Loading...">
            <p>Sending your message...</p>
        </div>
        <div id="success-message">Message sent successfully!</div>
    </form>
</section>

<footer>
    <p>&copy; 2024 @adicx ke</p>
</footer>

<script>
    const scriptURL = 'https://script.google.com/macros/s/AKfycbzgVyxcud8XqEokYi68hfxy0Y2XFnlYK54Zrnr8nMjegFaKT9nCC1QKEskoZI3dVfgk/exec';
    const form = document.forms['submit-to-google-sheet'];
    const successMessage = document.getElementById('success-message');
    const loadingIcon = document.getElementById('loading-icon');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // Show loading icon
        loadingIcon.style.display = "block";
        successMessage.style.display = "none"; // Hide success message if it was visible

        fetch(scriptURL, { method: 'POST', body: new FormData(form) })
            .then((response) => {
                console.log('Success!', response);
                // Clear form fields
                form.reset();

                // Hide loading icon and display success message
                loadingIcon.style.display = "none";
                successMessage.style.display = "block";

                // Hide the success message after 5 seconds
                setTimeout(() => {
                    successMessage.style.display = "none";
                }, 5000);
            })
            .catch((error) => {
                console.error('Error!', error.message);

                // Hide loading icon on error
                loadingIcon.style.display = "none";
                alert("An error occurred. Please try again.");
            });
    });
</script>
</body>
</html>
