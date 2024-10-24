<?php
$pdo = new PDO('mysql:host=localhost;dbname=attendance', 'root', '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_class'])) {
        $class_name = $_POST['class_name'];
        $class_date = $_POST['class_date'];

        $stmt = $pdo->prepare("INSERT INTO classes (class_name, class_date) VALUES (?, ?)");
        $stmt->execute([$class_name, $class_date]);
    }
}

$students = $pdo->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
$classes = $pdo->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#matric_number').on('input', function() {
                let matricNumber = $(this).val();

                // If matric number is not empty
                if (matricNumber.length > 0) {
                    $.ajax({
                        url: 'get_student.php',
                        type: 'POST',
                        data: { matric_number: matricNumber },
                        success: function(response) {
                            $('#student-picture').html(response);
                        },
                        error: function() {
                            $('#student-picture').html('<p>Student not found.</p>');
                        }
                    });
                } else {
                    $('#student-picture').html(''); // Clear when input is empty
                }
            });
        });
    </script>
</head>
<body>
    <h1>Admin Panel</h1>
    <h2><a href="view_classes.php">View All Classes and Attendance</a></h2><br>
    
    <h2>Add Class</h2>
    <form method="post">
        <input type="text" name="class_name" placeholder="Class Name" required>
        <input type="date" name="class_date" required>
        <button type="submit" name="add_class">Add Class</button>
    </form>
    
    <h2>Mark Attendance</h2>
    <form method="post" action="mark_attendance.php">
        <select name="class_id">
            <option value="">Select Class</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?php echo $class['id']; ?>"><?php echo htmlspecialchars($class['class_name'] . ' on ' . $class['class_date']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" id="matric_number" name="matric_number" placeholder="Matric Number" required>
        <button type="submit">Mark Attendance</button>
    </form>
    
    <div id="student-picture"></div>
    
    <h2>List of Students</h2>
    <ul>
    <?php foreach ($students as $student): ?>
        <li>
            <img src="<?php echo htmlspecialchars($student['profile_picture']); ?>" alt="Profile Picture" width="50" height="50">
            <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name'] . ' (' . $student['matric_number'] . ')'); ?>
        </li>
    <?php endforeach; ?>
    </ul>
    
    <br><br><br><br>
</body>
</html>