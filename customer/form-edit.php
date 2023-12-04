<?php
    require_once('../authen.php');
    $depo_idcus = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM customer WHERE depo_idcus = :depo_idcus";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':depo_idcus', $depo_idcus, PDO::PARAM_STR);
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
    <title>จัดการข้อมูลูกค้า</title>
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
                                        แก้ไขข้อมูลลูกค้า
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
                                                    <label for="depo_idcus">ชื่อผู้ใช้</label>
                                                    <input type="text" class="form-control" name="depo_idcus" id="depo_idcus" placeholder="รหัสลูกค้า" value="<?= $result['depo_idcus']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cus_name">ชื่อ-นามสกุล</label>
                                                    <input type="text" class="form-control" name="cus_name" id="cus_name" placeholder="ชื่อ-นามสกุล" value="<?= $result['cus_name']; ?>" required>
                                                </div>
                                
                                                <div class="form-group">
                                                    <label for="cus_add">ที่อยู่</label>
                                                    <input type="text" class="form-control" name="cus_add" id="cus_add" placeholder="ที่อยู่" value="<?= $result['cus_add']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">
                                                    <div class="form-group">
                                                        <label for="cus_tel">เบอร์โทร</label>
                                                        <input type="text" class="form-control" name="cus_tel" id="cus_tel" placeholder="เบอร์โทร" pattern="\d{10}" title="กรุณากรอกเบอร์โทร 10 ตัวเลข" value="<?= $result['cus_tel']; ?>" required>
                                                    </div>
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
                    url: '../../service/customer/update.php',
                    contentType: 'application/json', // เพิ่ม content type เป็น JSON
                    data: JSON.stringify({
                        cus_name: $('#cus_name').val(),
                        cus_add: $('#cus_add').val(),
                        cus_tel: $('#cus_tel').val(),
                        depo_idcus: $('#depo_idcus').val()
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