<?php 
   
    require_once('../authen.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>ข้อมูลรายการสั่งผลิต</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <!-- Datatables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                                    <i class="fas fa-shopping-cart"></i> 
                                    ข้อมูลรายการสั่งผลิต
                                </h4>
                                <a href="form-create.php" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i>
                                    เพิ่มข้อมูล
                                </a>
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
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../assets/js/adminlte.min.js"></script>
<script src="../../plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="../../plugins/toastr/toastr.min.js"></script>

<!-- datatables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(function() {
        $.ajax({
            type: "GET",
            url: "../../service/productionroderlist/"
        }).done(function(data) {
            let tableData = []
            data.response.forEach(function (item, index){
                tableData.push([   
                    `${item.list_id }`,     
                    `${item.pro_id}`,
                    `${item.List_idtype}`,
                    `${item.list_amount}`,
              
                    `<div class="btn-group" role="group">
                        <a href="form-edit.php?id=${item.list_id}" type="button" class="btn btn-warning">
                            <i class="far fa-edit"></i> แก้ไข
                        </a>
                        <button type="button" class="btn btn-danger delete-button" data-id="${item.list_id}">
                            <i class="far fa-trash-alt"></i> ลบ
                        </button>
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
                    { title: "รหัสรายการสั่งผลิต" , className: "align-middle"},
                    { title: "รหัสสินค้า" , className: "align-middle"},
                    { title: "รหัสประเภทสแตนเลส" , className: "align-middle"},
                    { title: "จำนวน", className: "align-middle"},
                    { title: "จัดการ", className: "align-middle"}
                ],
                initComplete: function() {
                    $('.delete-button').on('click', function() {
                        let list_id = $(this).data('id');
                        Swal.fire({
                            text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'ใช่! ลบเลย',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "DELETE",
                                    url: "../../service/productionroderlist/delete.php",
                                    data: JSON.stringify({
                                        list_id: list_id
                                    }),
                                    contentType: "application/json; charset=utf-8",
                                    dataType: "json"
                                }).done(function(data) {
                                    Swal.fire({
                                        text: 'รายการของคุณถูกลบเรียบร้อย',
                                        icon: 'success',
                                        confirmButtonText: 'ตกลง',
                                    }).then((result) => {
                                        location.reload();
                                    })
                                }).fail(function(jqXHR, textStatus, errorThrown) {
                                    console.log("AJAX Error: " + textStatus + ' - ' + errorThrown);
                                })
                            }
                        })
                    });
                },
                language: {
                    "lengthMenu": "แสดงข้อมูล MENU แถว",
                    "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                    "info": "แสดงหน้า PAGE จาก PAGES",
                    "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                    "infoFiltered": "(filtered from MAX total records)",
                    "search": 'ค้นหา',
                    "paginate": {
                        "previous": "ก่อนหน้านี้",
                        "next": "หน้าต่อไป"
                    }
                }
            })
        }
    })
</script>
</body>
</html>