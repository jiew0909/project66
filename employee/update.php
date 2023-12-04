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

$Em_name = $data['Em_name'];
$Em_add = $data['Em_add'];
$Em_tel = $data['Em_tel'];
$status = $data['status'];
$Or_idem = $data['Or_idem'];

$stmt = $conn->prepare("UPDATE employee SET Em_name = :Em_name, Em_add = :Em_add, Em_tel = :Em_tel, status = :status
            WHERE Or_idem = :Or_idem");

$stmt->bindParam(":Em_name", $Em_name, PDO::PARAM_STR);
$stmt->bindParam(":Em_add", $Em_add, PDO::PARAM_STR);
$stmt->bindParam(":Em_tel", $Em_tel, PDO::PARAM_STR);
$stmt->bindParam(":status", $status, PDO::PARAM_STR);
$stmt->bindParam(":Or_idem", $Or_idem, PDO::PARAM_STR);

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
