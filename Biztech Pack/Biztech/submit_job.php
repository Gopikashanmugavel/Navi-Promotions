<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $position = htmlspecialchars($_POST['position']);

    // File Upload
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $resumePath = $uploadDir . basename($_FILES["resume"]["name"]);
    
    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $resumePath)) {
        echo "<h2>Application Submitted Successfully!</h2>";
        echo "<p>Name: $name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Phone: $phone</p>";
        echo "<p>Position: $position</p>";
        echo "<p>Resume: <a href='$resumePath' target='_blank'>View Resume</a></p>";
    } else {
        echo "<h2>File Upload Failed.</h2>";
    }
} else {
    echo "<h2>Invalid Request</h2>";
}
?>
