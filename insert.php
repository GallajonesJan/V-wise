<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['studentId'] ?? '';
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $department = $_POST['department'] ?? '';
    $year_level = $_POST['yearLevel'] ?? '';

    if ($student_id && $name && $password) {
        // You should hash passwords before storing!
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO students (student_id, name, password, gender, department, year_level) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $student_id, $name, $hashed_password, $gender, $department, $year_level);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => "Missing required fields"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>
