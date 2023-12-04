<?php
header('Content-Type: application/json');
require_once '../connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$List_idtype = $data['List_idtype'];

$sql = "DELETE FROM stainlesssteeltype WHERE List_idtype = :List_idtype";
$stmt = $conn->prepare($sql);

$stmt->bindParam(":List_idtype", $List_idtype, PDO::PARAM_STR);

// Execute the statement to perform the deletion
try {
    $stmt->execute();

    $response = [
        'status' => true,
        'message' => 'Delete Success'
    ];
    http_response_code(204);
    echo json_encode($response);
} catch (PDOException $e) {
    $response = [
        'status' => false,
        'message' => 'Error: ' . $e->getMessage()
    ];
    http_response_code(500);
    echo json_encode($response);
}
?>
