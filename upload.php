<?php
require 'db.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['excelFile']['tmp_name'];

    $spreadsheet = IOFactory::load($fileTmp);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    $success = 0;
    $failed = 0;

    foreach ($rows as $index => $row) {
        if ($index === 0) continue; // Skip header

        [$student_id, $name, $password, $gender, $department, $year_level] = $row;

        if (!$student_id || !$name || !$password) {
            $failed++;
            continue;
        }

        // Avoid duplicate entries
        $check = $conn->prepare("SELECT 1 FROM students WHERE student_id = ?");
        $check->bind_param("s", $student_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $failed++;
            $check->close();
            continue;
        }
        $check->close();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO students (student_id, name, password, gender, department, year_level)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $student_id, $name, $hashed_password, $gender, $department, $year_level);

        if ($stmt->execute()) {
            $success++;
        } else {
            $failed++;
        }

        $stmt->close();
    }

    echo json_encode(["success" => true, "inserted" => $success, "skipped" => $failed]);
} else {
    echo json_encode([
        "success" => false,
        "error" => "Upload failed: " . $_FILES['excelFile']['error']
    ]);
}
?>
