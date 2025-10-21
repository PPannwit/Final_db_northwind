<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$products = getEdit($pdo, 'tb_employees', 'i_EmployeeID', $_POST['pid']);
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
            console.log("Edit Employee ID : " + pid);
            const form = document.createElement('form');
            form.m
            form.method = 'POST';
            form.action = './crud/db_employees_edit.php';

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
                    <h2 class="text-center">แก้ไขข้อมูลพนักงาน</h2>
                    <form action="../include/action_update.php" method="post">
                        <input type="hidden" name="tb_name" value="tb_employees">
                        <input type="hidden" name="action" value="update">
                        <?= input_text("i_EmployeeID", "รหัสพนักงาน", "number", $products["i_EmployeeID"], "กรุณากรอกรหัสพนักงาน", true); ?>
                        <?= input_text("c_EmployeeName", "ชื่อพนักงาน", "text", $products["c_EmployeeName"], "กรุณากรอกชื่อพนักงาน"); ?>
                        <?= input_text("c_Position", "ตำแหน่ง", "text", $products["c_Position"], "กรุณากรอกตำแหน่ง"); ?>
                        <?= input_text("i_Salary", "เงินเดือน", "text", $products["i_Salary"], "กรุณากรอกเงินเดือน"); ?>
                        <?= input_dropdown($pdo, "i_DepartmentID", "แผนก", "tb_departments", "i_DepartmentID", "c_DepartmentName", $products["i_DepartmentID"]) ?>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">อัปเดตข้อมูล</button>
                        </div>
                    </form>
                    <!-- Button Action -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>