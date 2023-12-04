<?php
require_once('../authen.php');

$sql_max_id = "SELECT MAX(SUBSTRING(Or_idem, 2)) as max_id FROM employee";
$stmt_max_id = $conn->prepare($sql_max_id);
$stmt_max_id->execute();
$max_id_result = $stmt_max_id->fetch(PDO::FETCH_ASSOC);

// กำหนดค่าเริ่มต้นถ้าไม่มีข้อมูล
$max_id = ($max_id_result['max_id']) ? intval($max_id_result['max_id']) + 1 : 1;

// กำหนดรหัสสินค้าที่เพิ่มขึ้น
$new_emp_id = '0' . sprintf('%04d', $max_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลสมาชิก</title>
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
                                        เพิ่มข้อมูลสมาชิก
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="Or_idem">รหัสพนักงาน</label>
                                                    <input type="text" class="form-control" name="Or_idem" id="Or_idem" value="<?php echo $new_emp_id; ?>" readonly>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="Em_name">ชื่อ-นามสกุล</label>
                                                    <input type="text" class="form-control" name="Em_name" id="Em_name" placeholder="ชื่อ-นามสกุล" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Em_pass">รหัสผ่าน</label>
                                                    <input type="password" class="form-control" name="Em_pass" id="Em_pass" placeholder="รหัสผ่าน" required>
                                                </div>
                                           
                                                <div class="form-group">
                                                    <label for="Em_add">ที่อยู่</label>
                                                    <input type="text" class="form-control" name="Em_add" id="Em_add" placeholder="ที่อยู่" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="Em_tel">เบอร์โทร</label>
                                                    <input type="text" class="form-control" name="Em_tel" id="Em_tel" placeholder="เบอร์โทร" pattern="\d{10}" title="กรุณากรอกเบอร์โทร 10 ตัวเลข" required>
                                                </div>



                                                <div class="form-group">
                                                    <label for="status">สิทธิ์การใช้งาน</label>
                                                    <select class="form-control" name="status" id="status" required>
                                                        <option value disabled selected>ตำแหน่ง</option>
                                                        <option value="superAdmin">Super Admin</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button>
                                        </div>
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
        $(function() {
            $('#formData').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../../service/employee/create.php',
                    data: $('#formData').serialize()
                }).done(function(resp) {
                    if (resp.status) {
                        // Success: Show success message and redirect
                        Swal.fire({
                            text: 'เพิ่มข้อมูลเรียบร้อย',
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).
                        then((result) => {
                            location.assign('./');
                        });
                    } else {
                        // Error: Show error message
                        Swal.fire({
                            text: resp.message,
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    }
                }).fail(function(xhr, status, error) {
                    // AJAX request failed: Show error message
                    Swal.fire({
                        text: 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                });
            })
        });
    </script>

</body>

</html>