<?php
header('Content-Type: application/json');
require_once '../connect.php';

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => false, 'message' => 'Method Not Allowed']);
    exit();
}

// Retrieve data from the input stream
$data = json_decode(file_get_contents("php://input"), true);

$cus_name = $data['cus_name'];
$cus_add = $data['cus_add'];
$cus_tel = $data['cus_tel'];
$depo_idcus = $data['depo_idcus'];

$stmt = $conn->prepare("UPDATE customer SET cus_name = :cus_name, cus_add = :cus_add, cus_tel = :cus_tel
            WHERE depo_idcus = :depo_idcus");

$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
$stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);
$stmt->bindParam(":cus_tel", $cus_tel, PDO::PARAM_STR);
$stmt->bindParam(":depo_idcus", $depo_idcus, PDO::PARAM_STR);

if ($stmt->execute()) {
    $response = [
        'status' => true,
        'message' => 'Update Success'
    ];
    http_response_code(200);
    echo json_encode($response);
} else {
    $response = [
        'status' => false,
        'message' => 'Update Failed'
    ];
    http_response_code(500); // Internal Server Error
    echo json_encode($response);
}
