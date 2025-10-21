<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$products = getEdit($pdo, 'tb_customers', 'i_CustomerID', $_POST['pid']);
// print_r($products);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BS5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- GG Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #2A7B9B;
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }

        h1 {
            color: white;
        }
    </style>
    <script>
        function EditData(pid) {
            console.log("Edit Customer ID : " + pid);
            const form = document.createElement('form');
            form.m
            form.method = 'POST';
            form.action = './crud/db_customers_edit.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'pid';
            input.value = pid;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();

            // form.remove();


            // Example of what the form looks like
            // <form action="./crud/db_product_edit.php" method="POST">
            //      <input type="hidden" name="pid" value="pid">
            // </form>
        }
    </script>
</head>

<body>
    <?php require_once '../include/navbar.php'; ?>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="card w-75">
            <!-- ชื่อหน้าจอ -->
            <div class="card-header">
                <!-- From Input -->
                <div class="card-body">
                    <h2 class="text-center">แก้ไขข้อมูลลูกค้า</h2>
                    <form action="../include/action.php" method="post">
                        <input type="hidden" name="tb_name" value="tb_customers">
                        <input type="hidden" name="action" value="update">
                        <?= input_text("i_CustomerID", "รหัสลูกค้า", "number", $products["i_CustomerID"], "กรุณากรอกรหัสลูกค้า", true); ?>
                        <?= input_text("c_CustomerName", "ชื่อลูกค้า", "text", $products["c_CustomerName"], "กรุณากรอกชื่อลูกค้า"); ?>
                        <?= input_text("c_Unit", "หน่วยนับสินค้า", "text", $products["c_Unit"], "กรุณากรอกหน่วยนับสินค้า"); ?>
                        <?= input_text("i_Price", "ราคาสินค้า", "text", $products["i_Price"], "กรุณากรอกราคาสินค้า"); ?>
                        <?= input_dropdown($pdo, "i_CategoryID", "หมวดหมู่สินค้า", "tb_categories", "i_CategoryID", "c_CategoryName", $products["i_CategoryID"]) ?>
                        <?= input_dropdown($pdo, "i_SupplierID", "ผู้จัดจำหน่าย", "tb_suppliers", "i_SupplierID", "c_SupplierName", $products["i_SupplierID"]) ?>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#confirmModal">
                                บันทึกข้อมูล
                            </button>
                        </div>
                    </form>
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="confirmModalLabel">ยืนยันการบันทึก</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-2">คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลหมวดหมู่ใช่หรือไม่?</p>
                                    <div class="small text-muted">ตรวจสอบข้อมูลให้ถูกต้องก่อนกด "ยืนยัน"</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ยกเลิก</button>
                                    <button id="confirmSaveBtn" type="button"
                                        class="btn btn-primary">ยืนยันและบันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
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