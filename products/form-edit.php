<?php
    require_once('../authen.php');
    $pro_id  = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM products WHERE pro_id = :pro_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pro_id', $pro_id, PDO::PARAM_STR);
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
                                        แก้ไขข้อมูลสินค้า
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
                                                    <label for="pro_id">รหัสสินค้า</label>
                                                    <input type="text" class="form-control" name="pro_id" id="pro_id" placeholder="รหัสสินค้า" value="<?= $result['pro_id']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pro_name">ชื่อสินค้า</label>
                                                    <select class="form-control" name="pro_name" id="pro_name" required>
                                                        <?php
                                                            // ดึงข้อมูลชื่อสินค้าจากฐานข้อมูล
                                                            $sql = "SELECT pro_name FROM products"; // แทนที่ your_table_name ด้วยชื่อตารางจริง
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();

                                                            // สร้าง options จากข้อมูล
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                $productName = $row['pro_name'];
                                                                $selected = ($productName == $result['pro_name']) ? 'selected' : ''; // ตรวจสอบว่าชื่อสินค้าในฐานข้อมูลตรงกับที่ถูกเลือกหรือไม่
                                                                echo "<option value=\"$productName\" $selected>$productName</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="List_idtype">ชื่อเกรดสแตนเลส</label>
                                                    <select class="form-control" name="List_idtype" id="List_idtype" required>
                                                        <?php
                                                            // ดึงข้อมูลเกรดสแตนเลสจากรหัสในฐานข้อมูล
                                                            $sql = "SELECT DISTINCT List_idtype, type_name FROM stainlesssteeltype"; // แทนที่ your_table_name ด้วยชื่อตารางจริง
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();

                                                            // สร้าง options จากรหัสและชื่อเกรด
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                $id = $row['List_idtype'];
                                                                $grade = $row['type_name'];
                                                                echo "<option value=\"$id\">$grade</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="pro_price">ราคา</label>
                                                    <input type="text" class="form-control" name="pro_price" id="pro_price" placeholder="ราคา" value="<?= $result['pro_price']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                        <label for="pro_unit">หน่วยนับ</label>
                                                        <select class="form-control" name="pro_unit" id="pro_unit" required>
                                                            <option value="" disabled selected>กรุณาเลือกหน่วยนับ</option>
                                                            <option value="ชิ้น" <?php if ($result['pro_unit'] === 'ชิ้น') echo 'selected'; ?>>ชิ้น</option>
                                                            <option value="บาน" <?php if ($result['pro_unit'] === 'บาน') echo 'selected'; ?>>บาน</option>
                                                            <option value="เมตร" <?php if ($result['pro_unit'] === 'เมตร') echo 'selected'; ?>>เมตร</option>
                                                            <!-- เพิ่มตัวเลือกเพิ่มเติมตามความต้องการ -->
                                                        </select>
                                                    </div>
                                                        <!-- Inside the form tag
                                                        <div class="form-group">
                                                            <label for="pro_image">รูปภาพสินค้า</label>
                                                            <input type="file" class="form-control-file" name="pro_image" id="pro_image" accept="image/*">
                                                        </div> -->

                                                <div class="col-md-4">
                                                    <img src="assets/images/<?=$row['image']?>" width="350px" class="mt-5 p-2 my-2 border" />
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
                    url: '../../service/products/update.php',
                    contentType: 'application/json', // เพิ่ม content type เป็น JSON
                    data: JSON.stringify({
                        pro_name:$('#pro_name').val(),
                        List_idtype:$('#List_idtype').val(),
                        pro_price:$('#pro_price').val(),
                        pro_unit:$('#pro_unit').val(),
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