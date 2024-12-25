<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "kaluwesteven50@gmail.com";
    $subject = "New Application Received";

    // Collect form data
    $full_name = htmlspecialchars($_POST['full_name']);
    $nrc = htmlspecialchars($_POST['nrc']);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $mode_of_study = htmlspecialchars($_POST['mode_of_study']);
    $program = htmlspecialchars($_POST['program']);
    $fulltime_intake = htmlspecialchars($_POST['fulltime_intake'] ?? '');
    $distance_intake = htmlspecialchars($_POST['distance_intake'] ?? '');
    $subjects = htmlspecialchars($_POST['subjects'] ?? '');

    // Handle file uploads
    $upload_dir = "uploads/";
    $uploaded_files = [];

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Create the directory if it doesn't exist
    }

    if (isset($_FILES['results'])) {
        $files = $_FILES['results'];
        for ($i = 0; $i < count($files['name']); $i++) {
            $file_name = basename($files['name'][$i]);
            $target_path = $upload_dir . uniqid() . "_" . $file_name;

            // Validate and move uploaded file
            if (move_uploaded_file($files['tmp_name'][$i], $target_path)) {
                $uploaded_files[] = $target_path;
            }
        }
    }

    // Construct email body
    $message = "
    Full Name: $full_name\n
    NRC Number: $nrc\n
    Date of Birth: $dob\n
    Gender: $gender\n
    Email: $email\n
    Phone: $phone\n
    Address: $address\n
    Mode of Study: $mode_of_study\n
    Program: $program\n
    Intake (Full-time): $fulltime_intake\n
    Intake (Distance): $distance_intake\n
    Subject Combinations: $subjects\n
    Uploaded Files: " . implode(", ", $uploaded_files) . "\n
    ";

    // Email headers
    $headers = "From: $email";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Application submitted successfully.";
    } else {
        echo "Failed to send the application.";
    }
}
?>

