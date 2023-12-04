<?php
header('Content-Type: application/json');
require_once '../connect.php';


// ดึงรหัสสินค้าที่มีค่าสูงสุดจากฐานข้อมูล
$sql_max_id = "SELECT MAX(SUBSTRING(Or_idem, 2)) as max_id FROM employee";
$stmt_max_id = $conn->prepare($sql_max_id);
$stmt_max_id->execute();
$max_id_result = $stmt_max_id->fetch(PDO::FETCH_ASSOC);

// กำหนดค่าเริ่มต้นถ้าไม่มีข้อมูล
$max_id = ($max_id_result['max_id']) ? intval($max_id_result['max_id']) + 1 : 1;

// กำหนดรหัสสินค้าที่เพิ่มขึ้น
$new_emp_id = '0' . sprintf('%04d', $max_id);


$Or_idem = $_POST['Or_idem'];
$Em_name = $_POST['Em_name'];
$Em_pass = $_POST['Em_pass'];
$Em_add = $_POST['Em_add'];
$status = $_POST['status'];
$Em_tel = $_POST['Em_tel'];

// Check if Or_idem already exists
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM employee WHERE Or_idem  = :Or_idem");
$checkStmt->bindParam(":Or_idem", $Or_idem, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    // Or_idem already exists
    $response = [
        'status' => false,
        'message' => 'Error: Or_idem already exists'
    ];
    http_response_code(400);
    echo json_encode($response);
} else {
    // Or_idem does not exist, proceed with insertion

    $sql = "INSERT INTO employee (Or_idem,Em_name, Em_pass, Em_add, status, created_at, updated_at, Em_tel ) 
            VALUES (:Or_idem, :Em_name, :Em_pass, :Em_add, :status, NOW(), NOW(), :Em_tel )";

    $stmt = $conn->prepare($sql);

    // Fix the typo here, use $Em_pass instead of $emp_pass
    $hashed_password = password_hash($Em_pass, PASSWORD_DEFAULT);

    $stmt->bindParam(":Or_idem", $Or_idem, PDO::PARAM_STR);
    $stmt->bindParam(":Em_name", $Em_name, PDO::PARAM_STR);
    $stmt->bindParam(":Em_pass", $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(":Em_add", $Em_add, PDO::PARAM_STR);
    $stmt->bindParam(":status", $status, PDO::PARAM_STR);
    $stmt->bindParam(":Em_tel", $Em_tel, PDO::PARAM_STR);

    try {
        if ($stmt->execute()) {
            // Successful insertion
            $response = [
                'status' => true,
                'message' => 'Create Success'
            ];
            http_response_code(200);
            echo json_encode($response);
        } else {
            // Insertion failed
            $response = [
                'status' => false,
                'message' => 'Create failed'
            ];
            http_response_code(500);
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Handle PDOException, including duplicate entry error
        $response = [
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
        http_response_code(500);
        echo json_encode($response);
    }
}
?>