<?php
require_once('../authen.php');

// แก้ไข SQL Query ทั้งคู่
$sql_max_id = "SELECT MAX(CAST(SUBSTRING(pro_id, 2) AS SIGNED)) as max_id FROM products";
$stmt_max_id = $conn->prepare($sql_max_id);
$stmt_max_id->execute();
$max_id_result = $stmt_max_id->fetch(PDO::FETCH_ASSOC);

// กำหนดค่าเริ่มต้นถ้าไม่มีข้อมูล
$max_id = ($max_id_result['max_id']) ? intval($max_id_result['max_id']) + 1 : 1;

// กำหนดรหัสสินค้าที่เพิ่มขึ้น
$new_pro_id = 'P' . sprintf('%04d', $max_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลสินค้า</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon1.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar_super.php') ?>
        <div class="content-wrapper pt-3">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="fas fa-user-cog"></i>
                                        เพิ่มข้อมูลสินค้า
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="pro_id">รหัสสินค้า</label>
                                                    <input type="text" class="form-control" name="pro_id" id="pro_id" value="<?php echo $new_pro_id; ?>" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label for="pro_name">ชื่อสินค้า</label>
                                                    <input type="text" class="form-control" name="pro_name" id="pro_name" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="List_idtype">ประเภทสแตนเลส</label>
                                                    <select class="form-control" name="List_idtype" id="List_idtype" required>
                                                        <?php
                                                        $sql = "SELECT DISTINCT List_idtype, type_name FROM stainlesssteeltype";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();

                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $id = $row['List_idtype'];
                                                            $typeName = $row['type_name'];
                                                            echo "<option value=\"$id\">$typeName</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="pro_price">ราคา</label>
                                                    <input type="number" class="form-control" name="pro_price" id="pro_price" placeholder="ราคา" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="pro_unit">หน่วยนับ</label>
                                                    <select class="form-control" name="pro_unit" id="pro_unit" required>
                                                        <option value="" disabled selected>กรุณาเลือกหน่วยนับ</option>
                                                        <option value="ชิ้น">ชิ้น</option>
                                                        <option value="บาน">บาน</option>
                                                        <option value="เมตร">เมตร</option>
                                                        <!-- เพิ่มตัวเลือกเพิ่มเติมตามความต้องการ -->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="images">รูปภาพสินค้า</label>
                                                    <input type="file" class="form-control-file" name="images" id="images">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    <!-- SCRIPTS -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script>
       $(function () {
    $('#formData').on('submit', function (e) {
        e.preventDefault();

            var fileInput = document.getElementById('images');
        console.log(fileInput.files); // ตรวจสอบว่ามีไฟล์ที่ถูกเลือกหรือไม่

        if (fileInput.files.length === 0) {
            Swal.fire({
                text: 'กรุณาเลือกรูปภาพ',
                icon: 'warning',
                confirmButtonText: 'ตกลง',
            });
            return;
        }

                $.ajax({
                    type: 'POST',
                    url: '../../service/products/create.php',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done(function (resp) {
                    if (resp.status) {
                        Swal.fire({
                            text: 'เพิ่มข้อมูลเรียบร้อย',
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            text: resp.message,
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    }
                }).fail(function (xhr, status, error) {
                    Swal.fire({
                        text: 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                });
            });
        });
    </script>
</body>
</html>
