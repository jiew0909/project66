<?php
require_once('../authen.php');

// ดึงข้อมูลลูกค้าจากฐานข้อมูล
$query = "SELECT depo_idcus, cus_name FROM customer";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> รายการสั่งผลิต </title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">

  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">

  <!-- Datatables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- jquery.Thailand -->
  <link rel="stylesheet" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include_once('../includes/sidebar_super.php') ?>
    <div class="content-wrapper pt-4">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header border-0 pt-4">
                            <div class="card-header border-0 pt-4">
                            <a href="form-create.php" class="btn btn-info my-3 ">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                            </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success " data-toggle="modal" data-target="#modalAdd">
                                    <i class="fa fa-plus-circle"></i> เลือกสินค้าที่ต้องการ
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">รายการสินค้าทั้งหมด</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive-xl">
                                                    <table class="table table-hover" id="products">
                                                        <thead>
                                                            <tr>
                                                                <th>รายละเอียดสินค้า</th>
                                                                <th>ราคาขาย</th>
                                                                <th>ดำเนินการ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <form id="formData">
                                <div class="card-body">
                                    <div class="table-responsive-xxl">
                                        <table class="table table-hover" id="orders">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 3%;">รหัสสินค้า</th>
                                                    <th style="width: 15%;">รูปภาพ</th>
                                                    <th style="width: 50%;">รายละเอียด</th>
                                                    <th style="width: 5%;">จำนวน</th>
                                                    <th style="width: 8%;">ราคาขาย</th>
                                                    <th style="width: 8%;">ส่วนลด</th>
                                                    <th style="width: 8%;">รวมเป็นเงิน</th>
                                                    <th style="width: 3%;">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="8" class="text-center">ข้อมูลว่าง</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-md-6 col-lg-5 col-xl- text-right">
                                            <div class="table-responsive">
                                                <table class="table">
                                                <tr>
                                                    <th>รวมเป็นเงิน</th>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <th>ส่วนลดทั้งหมด</th>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <th>จำนวนเงินรวมทั้งสิ้น</th>
                                                    <td>0</td>
                                                </tr>
                                                </table>
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

<!-- scripts -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../assets/js/adminlte.min.js"></script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>

<!-- datatables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- jquery.Thailand -->
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
<script>
    function goBack() {
        // JavaScript to navigate back
        window.history.back();
    }
</script>

<script>
    $(function() {
        let products = $('#products tbody')
        let orders = $('#orders tbody')
        let arrOrders = []

        function selectSearch() {
            $('.selectSearch').select2({
                width: '100%'
            })
        }
        
        function renderThailand() {
            $.Thailand({
                $district: $('[name="district"]'),
                $amphoe: $('[name="amphoe"]'),
                $province: $('[name="province"]'),
                $zipcode: $('[name="zipcode"]')
            })
        }

        function getProducts() {
            $.ajax({
                type: "GET",
                url: "../../service/products/"
            }).done(function(data) {
                data.response.forEach(function (item, index){
                    products.append(
                    `<tr>
                        <td> <img src="${item.image}" class="img-fluid" width="100px"> ${item.pro_name} </td>
                        <td> ${item.pro_price} </td>
                        <td> 
                            <button type="button" class="btn btn-outline-success" id="add${item.pro_id}">
                                เลือกสินค้า
                            </button>
                        </td>
                    </tr>`)
                    $(`#add${item.pro_id}`).on("click", function(){
                        addOrder(item)
                    })
                })
            }).fail(function() {
                products.append(`<tr><td colspan="5" class="text-center">ข้อมูลว่าง</td></tr>`)
            })
        }

        function addOrder(item) {
            item['pro_unit'] = 1
            item['p_total'] = item['pro_price']
            arrOrders.push(item)
            $('#modalAdd').modal('hide')
            renderOrder()
        }

        function deleteOrder(index) {
            arrOrders.splice(index, 1);
            renderOrder()
        }
        
        function renderOrder() {
            orders.empty();
            arrOrders.forEach(function (item, index){
                orders.append(`<tr>
                    <td> <a href="../products/" class="btn btn-outline-primary p-1"> ${item.pro_id} </a> </td>
                    <td> <img src="${item.image}" class="w-150p d-block mx-auto"> </td>
                    <td> <p class="detail"> ${item.pro_name}</p> </td>
                    <td> <input type="text" class="form-control rtl w-60p" value="${item.pro_unit}"> </td>
                    <td> <p class="p-2 pl-4 text-right bg-light rounded-lg">${item.p_total}</p> </td>
                    <td> <input type="text" class="form-control rtl w-90p" value="0"> </td>
                    <td> <p class="p-2 pl-4 text-right bg-secondary rounded-lg">${item.price}</p> </td>
                    <td> 
                        <button type="button" class="btn btn-danger" id="delete${index}">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`)
                
                $(`#delete${index}`).on("click", function(){
                    deleteOrder(index)
                })
            })
        }

        $('#formData').on('submit', function (e) {
            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: '../../service/orders/create.php',
                dataType: "json",
                data: { arrOrders }
            }).done(function(resp) {
                Swal.fire({
                    text: 'เพิ่มข้อมูลเรียบร้อย',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                }).then((result) => {
                    location.assign('./')
                })
            })
        })

        selectSearch()
        renderThailand()
        getProducts()

    })
</script>

</body>
</html>
