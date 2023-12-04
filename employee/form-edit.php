<?php
    require_once('../authen.php');
    $Or_idem = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM employee WHERE Or_idem = :Or_idem";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Or_idem', $Or_idem, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($result);
    // return;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลพนักงาน</title>
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
                                        แก้ไขข้อมูลพนักงาน
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
                                                    <label for="Or_idem">ชื่อผู้ใช้</label>
                                                    <input type="text" class="form-control" name="Or_idem" id="Or_idem" placeholder="ชื่อผู้ใช้" value="<?= $result['Or_idem']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Em_name">ชื่อ-นามสกุล</label>
                                                    <input type="text" class="form-control" name="Em_name" id="Em_name" placeholder="ชื่อ-นามสกุล" value="<?= $result['Em_name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Em_pass">รหัสผ่าน</label>
                                                    <input type="number" class="form-control" name="Em_pass" id="Em_pass" placeholder="password" value="<?= $result['Em_pass']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Em_add">ที่อยู่</label>
                                                    <input type="text" class="form-control" name="Em_add" id="Em_add" placeholder="ที่อยู่" value="<?= $result['Em_add']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">
                                                    <div class="form-group">
                                                        <label for="Em_tel">เบอร์โทร</label>
                                                        <input type="text" class="form-control" name="Em_tel" id="Em_tel" placeholder="เบอร์โทร" pattern="\d{10}" title="กรุณากรอกเบอร์โทร 10 ตัวเลข" value="<?= $result['Em_tel']; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mb_status">สิทธิ์การใช้งาน</label>
                                                    <select class="form-control" name="status" id="status" required>
                                                        <option value="" disabled>กำหนดสิทธิ์</option>
                                                        <option value="superAdmin" <?= ($result['status'] === 'superAdmin') ? 'selected' : ''; ?>>Super Admin</option>
                                                        <option value="admin" <?= ($result['status'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        
                                                    </select>
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
        $(function() {
            $('#formData').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'PUT',
                    url: '../../service/employee/update.php',
                    contentType: 'application/json', // เพิ่ม content type เป็น JSON
                    data: JSON.stringify({
                        Em_name: $('#Em_name').val(),
                        Em_add: $('#Em_add').val(),
                        Em_tel: $('#Em_tel').val(),
                        status: $('#status').val(),
                        Or_idem: $('#Or_idem').val()
                    })
                }).done(function(resp) {
                    Swal.fire({
                        text: 'อัพเดทข้อมูลเรียบร้อย',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        location.assign('./');
                    });
                });
            });
        });
    </script>

</body>

</html>