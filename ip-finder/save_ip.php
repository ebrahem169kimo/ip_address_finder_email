<?php
// Get the IP address of the visitor
function getIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Save the IP address into a variable
$visitor_ip = getIPAddress();

// Email configuration
$to_email = "sniper42444@gmail.com";
$subject = "New IP Address Detected";
$message = "The IP address of the visitor is: " . $visitor_ip;
$headers = "From: your_email@example.com"; // Replace with your email address

// Send email
if (mail($to_email, $subject, $message, $headers)) {
    echo "Email sent successfully to " . $to_email;
} else {
    echo "Email sending failed";
}
?>

