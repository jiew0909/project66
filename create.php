<?php
header('Content-Type: application/json');
require_once '../connect.php';

// ดึงรหัสสินค้าที่มีค่าสูงสุดจากฐานข้อมูล
$sql_max_id = "SELECT MAX(SUBSTRING(depo_idcus, 2)) as max_id FROM customer";
$stmt_max_id = $conn->prepare($sql_max_id);
$stmt_max_id->execute();
$max_id_result = $stmt_max_id->fetch(PDO::FETCH_ASSOC);

// กำหนดค่าเริ่มต้นถ้าไม่มีข้อมูล
$max_id = ($max_id_result['max_id']) ? intval($max_id_result['max_id']) + 1 : 1;

// กำหนดรหัสสินค้าที่เพิ่มขึ้น
$new_cus_id = 'C' . sprintf('%04d', $max_id);

$depo_idcus = $_POST['depo_idcus'];
$cus_name = $_POST['cus_name'];
$cus_add = $_POST['cus_add'];
$cus_tel = $_POST['cus_tel']; 

// Check if Or_idem already exists
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer WHERE depo_idcus  = :depo_idcus");
$checkStmt->bindParam(":depo_idcus", $depo_idcus, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    // Or_idem already exists
    $response = [
        'status' => false,
        'message' => 'Error: depo_idcus already exists'
    ];
    http_response_code(400);
    echo json_encode($response);
} else {
    // Or_idem does not exist, proceed with insertion

    $sql = "INSERT INTO customer (depo_idcus,cus_name, cus_add, cus_tel) 
            VALUES (:depo_idcus, :cus_name, :cus_add, :cus_tel)";

    $stmt = $conn->prepare($sql);

    // // Fix the typo here, use $Em_pass instead of $emp_pass
    // $hashed_password = password_hash($Em_pass, PASSWORD_DEFAULT);

    $stmt->bindParam(":depo_idcus", $depo_idcus, PDO::PARAM_STR);
    $stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
    $stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);
    $stmt->bindParam(":cus_tel", $cus_tel, PDO::PARAM_STR);
  

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