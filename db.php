<?php
// ================= DATABASE CONNECTION =================
$servername = "localhost";
$username   = "root";       // default for XAMPP
$password   = "";           // default for XAMPP
$dbname     = "portfolio_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ================= FORM SUBMIT =================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data safely
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('All fields are required');</script>";
        exit;
    }

    // Insert data using prepared statement (SECURE)
    $stmt = $conn->prepare(
        "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>
            alert('Message Sent Successfully!');
            window.location.href = 'index.html';
        </script>";
    } else {
        echo "<script>alert('Something went wrong!');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
