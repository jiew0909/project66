<?php
header('Content-Type: application/json');
require_once '../connect.php';

// ดึงรหัสสินค้าที่มีค่าสูงสุดจากฐานข้อมูล
$sql_max_id = "SELECT MAX(SUBSTRING(List_idtype, 2)) as max_id FROM stainlesssteeltype";
$stmt_max_id = $conn->prepare($sql_max_id);
$stmt_max_id->execute();
$max_id_result = $stmt_max_id->fetch(PDO::FETCH_ASSOC);

// กำหนดค่าเริ่มต้นถ้าไม่มีข้อมูล
$max_id = ($max_id_result['max_id']) ? intval($max_id_result['max_id']) + 1 : 1;

// กำหนดรหัสสินค้าที่เพิ่มขึ้น
$new_type_id = 'L' . sprintf('%04d', $max_id);

$List_idtype  = $_POST['List_idtype'];
$type_name = $_POST['type_name'];

$sql = "INSERT INTO stainlesssteeltype (List_idtype, type_name) 
        VALUES (:List_idtype, :type_name)";
$stmt = $conn->prepare($sql);

$stmt->bindParam(":List_idtype", $List_idtype, PDO::PARAM_STR);
$stmt->bindParam(":type_name", $type_name, PDO::PARAM_STR);

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

?>