<?php
$pdo = new PDO('mysql:host=localhost;dbname=attendance', 'root', '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = $_POST['class_id'];
    $matric_number = $_POST['matric_number'];

    $stmt = $pdo->prepare("SELECT id FROM students WHERE matric_number = ?");
    $stmt->execute([$matric_number]);
    $student = $stmt->fetch();

    if ($student) {
        $stmt = $pdo->prepare("INSERT INTO attendance (student_id, class_id, is_present) VALUES (?, ?, 1)");
        $stmt->execute([$student['id'], $class_id]);
        echo "Attendance marked for {$matric_number}";
    } else {
        echo "Student not found!";
    }
}
?>
<a href="admin.php">Back to Admin Panel</a>