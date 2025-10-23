<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$customer = getEdit($pdo, 'tb_customers', 'i_CustomerID', $_POST['custid']);
//print_r($customer);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลลูกค้า</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body>
    <?php require_once '../include/navbar.php'; ?>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="card w-75 shadow-lg border-0">
            <div class="card-header text-center" style="background-color: white;">
                <h2 class="mb-0" style="color: black;">แก้ไขข้อมูลลูกค้า</h2>
            </div>
            <div class="card-body">
                <form id="editForm" action="../include/action.php" method="post">
                    <input type="hidden" name="tb_name" value="tb_customers">
                    <input type="hidden" name="action" value="update">
                    <?= input_text("i_customerid", "รหัสลูกค้า", "number", $customer["i_customerid"], "กรุณากรอกรหัสลูกค้า", true); ?>
                    <?= input_text("c_customername", "ชื่อลูกค้า", "text", $customer["c_customername"], "กรุณากรอกชื่อลูกค้า"); ?>
                    <?= input_text("c_contactname", "ชื่อผู้ติดต่อ", "text", $customer["c_contactname"], "กรุณากรอกชื่อผู้ติดต่อ"); ?>
                    <?= input_text("c_address", "ที่อยู่", "text", $customer["c_address"], "กรุณากรอกที่อยู่"); ?>
                    <?= input_text("c_city", "เมือง", "text", $customer["c_city"], "กรุณากรอกเมือง"); ?>
                    <?= input_text("c_country", "ประเทศ", "text", $customer["c_country"], "กรุณากรอกประเทศ"); ?>

                    <!-- Array ( [i_customerid] => 7 [c_customername] => Blondel père et fils [c_contactname] => Frédérique Citeaux [c_address] 
                     => 24, place Kléber [c_city] => Strasbourg [c_postalcode] => 67000 [c_country] => France ) -->

                    <div class="text-center mt-4">
                        <a href="../db_customers_search.php" class="btn btn-secondary me-2">ย้อนกลับ</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal ยืนยันการบันทึก -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg border-0">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="confirmModalLabel">ยืนยันการบันทึก</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-2">คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลลูกค้าหรือไม่?</p>
                            <div class="small text-muted">ตรวจสอบข้อมูลให้ถูกต้องก่อนกด "ยืนยัน"</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button id="confirmSaveBtn" type="button" class="btn btn-primary">ยืนยันและบันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const confirmBtn = document.getElementById('confirmSaveBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function () {
                    const form = document.getElementById('editForm');
                    if (form) form.submit();
                });
            }
        });
    </script>
</body>

</html>
