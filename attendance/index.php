<?php
$pdo = new PDO('mysql:host=localhost;dbname=attendance', 'root', '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $matric_number = $_POST['matric_number'];

    // Handle file upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $uploads_dir = 'uploads/';
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $name = basename($_FILES['profile_picture']['name']);
        
        // Make sure uploads directory exists
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0755, true);
        }
        
        $profile_picture = $uploads_dir . $name;

        // Move the uploaded file to its final destination
        move_uploaded_file($tmp_name, $profile_picture);
    }

    $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, matric_number, profile_picture) VALUES (?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $matric_number, $profile_picture]);
    echo "Student registered successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <center><h1>Register Student</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="text" name="matric_number" placeholder="Matric Number" required><br>
        <input type="file" name="profile_picture" accept="image/*" required><br>
        <button type="submit">Register</button>
    </form></center>
</body>
</html>