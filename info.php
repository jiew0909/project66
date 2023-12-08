<?php

header('Content-Type: application/json');
require_once '../connect.php';

/**
 |--------------------------------------------------------------------------
 | ดึงข้อมูล Member Orders
 | 'SELECT * FROM members'
 |--------------------------------------------------------------------------
*/
/** 
 * กำหนดข้อมูลสำหรับการ Response ไปยังฝั่ง Client
 * 
 * @return array 
 */


// เขียนคำสั่ง SQL สำหรับดึงข้อมูลลูกค้า
$sql = "SELECT * FROM customer WHERE depo_idcus = (SELECT depo_idcus FROM orders WHERE or_id = :or_id)";
$stmt = $conn->prepare($sql);

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->bindParam(':or_id', $or_id, PDO::PARAM_INT);
if ($customer) {
    // มีข้อมูลลูกค้า
    $cus_name = $customer['cus_name'];
    $cus_add = $customer['cus_add'];
    $cus_tel = $customer['cus_tel'];
    // ... (ตัวแปรอื่น ๆ ของลูกค้า)

    // สามารถนำตัวแปร $customer_name, $customer_phone, และอื่น ๆ ไปแสดงใน HTML ได้
} else {
    // ไม่พบข้อมูลลูกค้า
    echo "ไม่พบข้อมูลลูกค้า";
}
$response = [
    'status' => true,
    'response' => [
        [
            'or_id' => '',
            'depo_idcus' => '',
            'cun_name' => '',
            'Or_idem' => '1',
            'or_date' => '',
            'status' => 'true',

        ]
    ],
    'message' => 'Get Data Success'
];

http_response_code(200);
echo json_encode($response);

