<?php
    header('Content-Type: application/json');
    require_once '../connect.php';
    ?>

    <?php
    $data = json_decode(file_get_contents("php://input"), true);
    $Or_idem = $data['Or_idem'];

    $sql = "DELETE FROM employee WHERE Or_idem = :Or_idem";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":Or_idem", $Or_idem, PDO::PARAM_STR);

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
        // Handle errors if the deletion fails
        $response = [
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
        http_response_code(500);
        echo json_encode($response);
        echo 'Error: ' . $e->getMessage();
    }
?>