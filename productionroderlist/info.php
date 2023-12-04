<?php 

    require_once('../authen.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>จัดการสมาชิก | AppzStory</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <!-- Datatables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include_once('../includes/sidebar_super.php') ?>
    <div class="content-wrapper pt-4">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header border-0 pt-4">
                                <h4> 
                                    <i class="fas fa-cart-arrow-down"></i> 
                                    ข้อมูลใบสั่งซื้อ list_id : <?php echo $_GET['list_id'] ?>
                                </h4>
                            </div>
                            <div class="card-body px-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header pt-4">
                                                <h3 class="card-title"> 
                                                    <i class="fas fa-cart-arrow-down"></i> 
                                                    ใบสั่งผลิต
                                                </h3>
                                            </div>
                                          
                                                <div class="row mb-3">
                                                    <p class="col-xl-3 text-muted"> list_id :</p>
                                                    <div class="col-xl-9">
                                                        <p class="btn btn-outline-primary p-1"> <?php echo $_GET['list_id'] ?> </p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <p class="col-xl-3 text-muted">สั่งซื้อเมื่อ :</p>
                                                    <div class="col-xl-9">
                                                        <span class="text-muted small"> 1 ชั่วโมงที่ผ่านมา <br> 10 พ.ค. 64 · 16:56 น.</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <p class="col-xl-3 text-muted">วันหมดอายุ :</p>
                                                    <div class="col-xl-9">
                                                        <p>ไม่มีหมดอายุ</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <p class="col-xl-3 text-muted">รายละเอียดเพิ่มเติม :</p>
                                                    <div class="col-xl-9">
                                                        <p>-</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <p class="col-xl-3 text-muted">บันทึกลับ : <br> (เห็นเฉพาะ Admin)</p>
                                                    <div class="col-xl-9">
                                                        <p>ไม่มี</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header border-0 pt-4">
                                <h3 class="card-title"> 
                                    <i class="fas fa-cart-arrow-down"></i> 
                                    รายการสินค้า
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="logs" class="table table-hover" width="100%"></table>
                                <div class="row justify-content-end">
                                    <div class="col-md-6 col-lg-5 col-xl- text-right">
                                        <div class="table-responsive">
                                            <table class="table">
                                     
                                            <tr>
                                                <th>จำนวนเงินรวมทั้งสิ้น</th>
                                                <td>0</td>
                                            </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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

<!-- datatables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(function() {
        $.ajax({
            type: "GET",
            url: "../../service/products/info.php"
        }).done(function(data) {
            let tableData = []
            data.response.forEach(function (item, index){
                tableData.push([    
                    `<a href="${item.url}" target="_blank" class="btn btn-outline-primary p-1"> ${item.pro_id} </a>`,
                    `<img src="${item.image}" class="img-fluid" width="100px"> ${item.pro_name}`,
                    `${item.pro_price}`
                    `${item.discount}`,
                    `<span class="text-right">${item.pro_price - item.discount}</span>`,
                ])
            })
            $(function() {
        $.ajax({
            type: "GET",
            url: "../../service/stainlesssteeltype/info.php"
        }).done(function(data) {
            let tableData = []
            data.response.forEach(function (item, index){
                tableData.push([    
                    `<a href="${item.url}" target="_blank" class="btn btn-outline-primary p-1"> ${item.List_idtype } </a>`,
                    `<img src="${item.images}" class="img-fluid" width="100px"> ${item.type_name}`,
                    `${item.type_price}`
                    `${item.discount}`,
                    `<span class="text-right">${item.pro_type_priceprice - item.discount}</span>`,
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
                paging:   false,
                ordering: false,
                info:     false,
                searching:     false,
                data: tableData,
                columns: [
                    { title: "รหัสรายการสั่งผลิต", className: "align-middle"},
                    { title: "รหัสสินค้า", className: "align-middle"},
                    { title: "รหัสประเภท", className: "align-middle text-md-right"},
                    { title: "จำนวน", className: "align-middle text-md-right"},
                    { title: "ราคารวม", className: "align-middle text-md-right"},
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                return 'รายการสินค้า'
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table'
                        })
                    }
                },
                language: {
                    "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                    "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                    "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                    "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                    "infoFiltered": "(filtered from _MAX_ total records)",
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

