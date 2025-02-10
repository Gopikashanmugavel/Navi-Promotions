<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Change to your DB username
$password = ""; // Change to your DB password
$database = "job_portal"; // Change to your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve Basic Information
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    
    // Insert into applicants table
    $sql = "INSERT INTO applicants (name, email, phone, gender, dob, address, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $phone, $gender, $dob, $address, $description);
    $stmt->execute();
    $applicant_id = $stmt->insert_id;
    
    // Insert Education Details
    foreach ($_POST['degree'] as $index => $degree) {
        $institution = $_POST['institution'][$index];
        $year = $_POST['year'][$index];
        
        $sql = "INSERT INTO education (applicant_id, degree, institution, year) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $applicant_id, $degree, $institution, $year);
        $stmt->execute();
    }
    
    // Insert Skills
    foreach ($_POST['skills'] as $index => $skill) {
        $proficiency = $_POST['proficiency'][$index];
        
        $sql = "INSERT INTO skills (applicant_id, skill, proficiency) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $applicant_id, $skill, $proficiency);
        $stmt->execute();
    }
    
    echo "<script>alert('Application submitted successfully!'); window.location.href='index.html';</script>";
}

$conn->close();
?>
