<?php
$pdo = new PDO('mysql:host=localhost;dbname=attendance', 'root', '');

$class_id = $_GET['class_id'] ?? null;
if ($class_id) {
    // Fetch class details
    $class_stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
    $class_stmt->execute([$class_id]);
    $class = $class_stmt->fetch();

    // Fetch attendance for the class
    $attendance_stmt = $pdo->prepare("
        SELECT s.first_name, s.last_name, s.matric_number 
        FROM attendance a 
        JOIN students s ON a.student_id = s.id 
        WHERE a.class_id = ? AND a.is_present = 1
    ");
    $attendance_stmt->execute([$class_id]);
    $attendance_list = $attendance_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Class ID is required.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Attendance for <?php echo htmlspecialchars($class['class_name']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Attendance for <?php echo htmlspecialchars($class['class_name']); ?> on <?php echo htmlspecialchars($class['class_date']); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Matric Number</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($attendance_list) > 0): ?>
                <?php foreach ($attendance_list as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['matric_number']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No students present for this class.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <button onclick="window.print()">Print Attendance</button>
    <br><br>
    <a href="view_classes.php">Back to Class List</a>
</body>
</html>