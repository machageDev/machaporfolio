<?php
  // 1. Your Email Address
  $receiving_email_address = 'machagefranklyn@gmail.com';

  // 2. Process the POST request
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Collect and sanitize inputs
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Simple validation
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
        // Bootstrap templates usually look for "OK" to trigger the success message
        echo "OK"; 
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

  } else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
  }
?>