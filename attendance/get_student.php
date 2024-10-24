<?php
$pdo = new PDO('mysql:host=localhost;dbname=attendance', 'root', '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric_number = $_POST['matric_number'];

    // Prepare and execute the statement to find the student by matric number
    $stmt = $pdo->prepare("SELECT * FROM students WHERE matric_number = ?");
    $stmt->execute([$matric_number]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        echo '<h3>' . htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) . '</h3>';
        echo '<img src="' . htmlspecialchars($student['profile_picture']) . '" alt="Profile Picture" width="150" height="150">';
    } else {
        echo '<p>No student found with this matric number.</p>';
    }
}
?>