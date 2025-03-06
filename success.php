<?php
// Check if 'status' is set in the URL
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent</title>
    <style>
        /* Internal CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
            text-align: center;
        }

        .message {
            background-color: #e4f9e4;
            color: #4CAF50;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #4CAF50;
            font-size: 1.2rem;
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
        }

        footer {
            margin-top: 30px;
            font-size: 1rem;
            color: #777;
        }
    </style>
</head>
<body>

    <?php if ($status == 'success'): ?>
        <div class="message">
            <h2>Message Sent Successfully!</h2>
            <p>Thank you for getting in touch! We will get back to you as soon as possible.</p>
        </div>
    <?php else: ?>
        <div class="message">
            <h2>There was an error submitting your message. Please try again.</h2>
        </div>
    <?php endif; ?>

    <footer>
        <p>&copy; 2024 My Portfolio</p>
    </footer>

</body>
</html>
