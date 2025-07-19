<?php
require 'db.php';

$result = $conn->query("SELECT student_id, name, gender, department, year_level FROM students");

$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);
?>
