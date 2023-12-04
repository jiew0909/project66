<?php
    require_once('../authen.php');
    
    $List_idtype = $_POST['List_idtype'];
    $type_name = $_POST['type_name'];
    
    $sql = "UPDATE stainlesssteeltype SET type_name = :type_name WHERE List_idtype = :List_idtype";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':List_idtype', $List_idtype, PDO::PARAM_STR);
    $stmt->bindParam(':type_name', $type_name, PDO::PARAM_STR);
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
