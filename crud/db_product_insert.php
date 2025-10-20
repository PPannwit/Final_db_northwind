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
            console.log("Edit Product ID : " + pid);
            const form = document.createElement('form');
            form.m
            form.method = 'POST';
            form.action = './crud/db_product_edit.php';

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
    <div class="container">
        <div class="card">
            <!-- ชื่อหน้าจอ -->
            <div class="card-header">
                <!-- From Input -->
                <div class="card-body">
                    <form action="../include/action.php" method="post">
                        <input type="hidden" name="tb_name" value="tb_product">
                        <input type="hidden" name="action" value="insert">
                        <?= input_text("i_ProductID", "รหัสสินค้า", "number", $NewID, "กรุณากรอกรหัสสินค้า",true); ?>
                        <?= input_text("c_ProductName", "ชื่อสินค้า", "text", null, "กรุณากรอกชื่อสินค้า"); ?>
                        <?= input_text("c_Unit", "หน่วยนับสินค้า", "text", null, "กรุณากรอกหน่วยนับสินค้า"); ?>
                        <?= input_text("i_Price", "ราคาสินค้า", "text", null, "กรุณากรอกราคาสินค้า"); ?>
                        <?= input_dropdown($pdo, "i_CategoryID", "หมวดหมู่สินค้า", "tb_categories", "i_CategoryID", "c_CategoryName", null) ?>
                        <?= input_dropdown($pdo, "i_SupplierID", "ขนส่งสินค้า", "tb_suppliers", "i_SupplierID", "c_SupplierName", null) ?>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!-- Button Action -->
                    <div class="card-footer">
                    </div>
                </div>
</body>

</html>