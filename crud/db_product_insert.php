<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$NewID = getNewID($pdo, "tb_products", "i_ProductID");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลสินค้า</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
</head>

<body>
    <?php require_once '../include/navbar.php'; ?>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="card w-75">
            <div class="card-body">
                <h2 class="text-center mb-0">เพิ่มข้อมูลสินค้า</h2>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="../include/action.php" method="post">
                    <input type="hidden" name="tb_name" value="tb_products">
                    <input type="hidden" name="action" value="insert">
                    <?= input_text("i_ProductID", "รหัสสินค้า", "number", $NewID, "รหัสสินค้าอัตโนมัติ", true); // true = readonly ?>
                    <?= input_text("c_ProductName", "ชื่อสินค้า", "text", null, "กรุณากรอกชื่อสินค้า", false, true); ?>
                    <?= input_text("i_Price", "ราคา", "number", null, "กรุณากรอกราคา (ตัวเลข)", false, true); ?>

                    <div class="text-center mt-4">
                        <a href="../db_product_search.php" class="btn btn-secondary me-2">ย้อนกลับ</a>
                        <button type="submit" class="btn btn-success">เพิ่มข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>