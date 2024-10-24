<?php
$pdo = new PDO('mysql:host=localhost;dbname=attendance', 'root', '');

$classes = $pdo->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Classes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>List of Classes</h1>
    <table>
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Class Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $class): ?>
                <tr>
                    <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($class['class_date']); ?></td>
                    <td>
                        <a href="print_attendance.php?class_id=<?php echo $class['id']; ?>">Print Attendance</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>