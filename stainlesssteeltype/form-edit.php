<?php
    require_once('../authen.php');
    $List_idtype  = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM stainlesssteeltype WHERE List_idtype = :List_idtype";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':List_idtype', $List_idtype, PDO::PARAM_STR);
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
    <title>จัดการข้อมูลประเภทสแตนเลส</title>
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
                                        แก้ไขข้อมูลประเภทสแตนเลส
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
                                                    <label for="List_idtype">รหัสประเภทสแตนเลส</label>
                                                    <input type="text" class="form-control" name="List_idtype" id="List_idtype" placeholder="รหัสประเภทสแตนเลส" value="<?= $result['List_idtype']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                <label for="type_name">ชื่อเกรด</label>
                                                <input type="text" class="form-control" name="type_name" id="type_name" required>

                                            </div>     
                                            </div>
                                             <!-- <div class="form-group">
                                            <label for="images">รูปภาพประเภทสแตนเลส</label>
                                            <input type="file" class="form-control-file" name="images" id="images">
                                        </div> -->

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

        // สร้าง FormData เพื่อเก็บข้อมูลจากฟอร์ม
        var formData = new FormData(this);
        
        $.ajax({
    type: 'POST',  // หรือใช้ 'PUT' ตามที่ได้ลองเปลี่ยน
    url: '../../service/stainlesssteeltype/update.php',
    contentType: false,
    processData: false,
    data: formData
}).done(function(resp) {
    console.log(resp);
    Swal.fire({
        text: 'อัพเดทข้อมูลเรียบร้อย',
        icon: 'success',
        confirmButtonText: 'ตกลง',
    }).then((result) => {
        location.assign('./');
    });
}).fail(function(xhr, status, error) {
    console.log(xhr.responseText);  // ดูข้อความผิดพลาดที่ได้จากเซิร์ฟเวอร์
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