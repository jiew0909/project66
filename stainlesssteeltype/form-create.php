<?php
require_once('../authen.php');

$sql_max_id = "SELECT MAX(CAST(SUBSTRING(List_idtype, 2) AS SIGNED)) as max_id FROM stainlesssteeltype";
$stmt_max_id = $conn->prepare($sql_max_id);
$stmt_max_id->execute();
$max_id_result = $stmt_max_id->fetch(PDO::FETCH_ASSOC);

$max_id = ($max_id_result['max_id']) ? intval($max_id_result['max_id']) + 1 : 1;

$new_type_id = 'L' . sprintf('%04d', $max_id);
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
                                        เพิ่มข้อมูลประเภทสแตนเลส
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
                                                    <label for="List_idtype">รหัสประเภท</label>
                                                    <input type="text" class="form-control" name="List_idtype" id="List_idtype" value="<?php echo $new_type_id; ?>" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label for="type_name">ประเภทสแตนเลส</label>
                                                    <input type="text" class="form-control" name="type_name" id="type_name" required>
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

        $.ajax({
            type: 'POST',
            url: '../../service/stainlesssteeltype/create.php',
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
        }).done(function (resp) {
            if (resp.success) {
                Swal.fire({
                    text: 'บันทึกข้อมูลเรียบร้อย',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                }).then((result) => {
                    location.assign('./');
                });
            } else {
                Swal.fire({
                    text: 'เกิดข้อผิดพลาด: ' + resp.error,
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                });
            }
        }).fail(function (xhr, status, error) {
            // Log the detailed error information to the console
            console.error('AJAX Error:', xhr, status, error);

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
