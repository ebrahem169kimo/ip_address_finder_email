<?php
// Database configuration
$servername = "localhost"; // Change this to your database server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "ip_finder_db"; // Change this to your database name

// Email configuration
$to_email = "sniper42444@gmail.com"; // Change this to the recipient's email address
$subject = "New IP Address Detected";

// Get the IP address of the visitor
function getIPAddress() {
    // Whether IP is from the share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    // Whether IP is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Whether IP is from the remote address
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Save the IP address into the database
function saveIPAddress($ip, $servername, $username, $password, $dbname) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO ip_addresses (ip_address) VALUES (?)");
    $stmt->bind_param("s", $ip);

    // Execute SQL statement
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Send email function
function sendEmail($to_email, $subject, $message) {
    // Use the PHP mail() function to send email
    $headers = "From: Your Website <noreply@example.com>\r\n";
    $headers .= "Reply-To: noreply@example.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($to_email, $subject, $message, $headers);
}

// Usage
$visitor_ip = getIPAddress();
echo "Your IP Address is: " . $visitor_ip;

// Save IP address into the database
saveIPAddress($visitor_ip, $servername, $username, $password, $dbname);

// Send email with the IP address
$message = "New IP Address Detected: " . $visitor_ip;
sendEmail($to_email, $subject, $message);

// Display success message
echo "<br>Email sent with IP address to: " . $to_email;
?>
