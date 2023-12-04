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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
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
                                    <h4>
                                        <i class="fas fa-cart-arrow-down"></i>
                                        สั่งผลิต
                                    </h4>
                                </div>
                                <div class="col-md-2">
                                    <label for="transactionDate">วันที่ทำการ:</label>
                                    <input type="date" class="form-control" id="transactionDate" name="transactionDate">
                                </div>

                                <div class="card-body px-1 px-md-3">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <label for="customer">เลือกลูกค้าเก่า:</label>
                                            <select id="customer" class="form-control">
                                                <?php
                                                foreach ($customer as $cus) {
                                                    echo "<option value='{$cus['depo_idcus']}'>{$cus['cus_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Add filter button and input field -->
                    <div class="col-md-6">
                        <label for="customer">เลือกลูกค้าใหม่:</label>
                        <div class="d-flex align-items-end">
                            <input type="text" class="form-control" style="margin-right: 10px;" id="customer" name="newCustomerTextBox">
                            <button type="button" class="btn btn-primary" style="width: 60%;" data-toggle="modal" data-target="#addCustomerModal">
                                +เพิ่มลูกค้า
                            </button>
                        
                        </div>
                    </div>

                                    </div>
                                    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">เพิ่มข้อมูลลูกค้าใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Add input field for filtering in the modal -->
<div class="modal-body">
    <label for="newCustomerName">ชื่อ-สกุล:</label>
    <input type="text" class="form-control" id="newCustomerName">

    <label for="newCustomerAddress">ที่อยู่:</label>
    <input type="text" class="form-control" id="newCustomerAddress">

    <label for="newCustomerPhone">เบอร์โทรศัพท์:</label>
    <input type="text" class="form-control" id="newCustomerPhone">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" onclick="saveNewCustomer()">บันทึก</button>
   
</div>
     </div>
    </div>
</div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                                        <!-- ... (your existing modal code) -->
                                    </div>
                                </div>

                                <script>
    function saveNewCustomer() {
        console.log('saveNewCustomer function called');

        // Get the values entered for the new customer
        var newCustomerName = document.getElementById('newCustomerName').value;
        var newCustomerAddress = document.getElementById('newCustomerAddress').value;
        var newCustomerPhone = document.getElementById('newCustomerPhone').value;

        // Perform logic to save the new customer to the database (using AJAX or form submission)

        // Update the "เลือกลูกค้าใหม่" input field with the new customer name
        document.getElementById('customer').value = newCustomerName;

        // Optionally, close the modal
        $('#addCustomerModal').modal('hide');
    }
</script>

                                <div class="card-footer">
                                    <!-- <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button> -->
                                    <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit" onclick="redirectToCreateProducts()">สั่งสินค้า</button>

                                    <script>
                                        function redirectToCreateProducts() {
                                            // ในที่นี้เราจะให้เด้งไปที่หน้า form-create-products.php
                                            window.location.href = 'form-create-products.php';
                                        }
                                    </script>
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
                    data.response.forEach(function(item, index) {
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
                        $(`#add${item.pro_id}`).on("click", function() {
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
                arrOrders.forEach(function(item, index) {
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

                    $(`#delete${index}`).on("click", function() {
                        deleteOrder(index)
                    })
                })
            }

            $('#formData').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    type: 'POST',
                    url: '../../service/orders/create.php',
                    dataType: "json",
                    data: {
                        arrOrders
                    }
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
