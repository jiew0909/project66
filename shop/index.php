<?php 
   
    require_once('../authen.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>ข้อมูลร้าน</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon1.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <!-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css"> -->
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <!-- Datatables -->
  <!-- <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css"> -->
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
                        <div class="card">
                            <div class="card-header border-0 pt-4">
                                <h4> 
                                    <!-- <i class="fas fa-shopping-cart"></i>  -->
                                    ข้อมูลร้าน
                                </h4>
                                <!-- <a href="form-create.php" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i>
                                    เพิ่มข้อมูล
                                </a> -->
                            </div>
                            <div class="card-body">
                                <table  id="logs" 
                                        class="table table-hover" 
                                        width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../includes/footer.php') ?>
</div>
<!-- scripts -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script> -->
<script src="../../assets/js/adminlte.min.js"></script>
<script src="../../plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="../../plugins/toastr/toastr.min.js"></script>

<!-- datatables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<!-- <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script> -->
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(function() {
        $.ajax({
            type: "GET",
            url: "../../service/shop/"
        }).done(function(data) {
            let tableData = []
            data.response.forEach(function (item, index){
                tableData.push([   
                    // `${item.sh_id}`, 
                    `${item.sh_name}`, 
                    
                    // `<img src="${item.images}" class="img-fluid" width="150px">`,
                    `${item.sh_add}`,
                    `${item.sh_tel}`,
                    // `${item.pro_unit}`,
                    `<div class="btn-group" role="group">
                        <a href="form-edit.php?id=${item.sh_name}" type="button" class="btn btn-warning">
                            <i class="far fa-edit"></i> แก้ไข
                        </a>
                       
                    </div>`
                ])
            })
            initDataTables(tableData)
        }).fail(function() {
            Swal.fire({ 
                text: 'ไม่สามารถเรียกดูข้อมูลได้', 
                icon: 'error', 
                confirmButtonText: 'ตกลง', 
            }).then(function() {
                location.assign('../dashboard')
            })
        })

        function initDataTables(tableData) {
    $('#logs').DataTable( {
        data: tableData,
        columns: [
            { title: "ชื่อร้าน" , className: "align-middle"},
            { title: "ที่อยู่" , className: "align-middle"},
            { title: "เบอร์โทรศัพท์", className: "align-middle"},
            { title: "จัดการ", className: "align-middle"}
        ],
        searching: false, // Disable search input
        lengthChange: false, // Disable "Show X entries" dropdown
        info: false, // Disable showing "Showing X to X of X entries"
        paging: false, // Disable pagination
        initComplete: function() {
            $('.delete-button').on('click', function() {
                // ... (unchanged)
            });
        },
        language: {
            "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
            "infoFiltered": "(filtered from MAX total records)",
        }
    });
}

    })
</script>
</body>
</html>