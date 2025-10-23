<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$NewID = getNewID($pdo, "tb_employees", "i_EmployeeID");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลพนักงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }

        h2 {
            color: white;
        }
    </style>
</head>

<body>
    <?php require_once '../include/navbar.php'; ?>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="card w-75 shadow-lg">
            <div class="card-body text-center" style="background-color: white;">
                <h2 class="mb-0" style="color: black;">เพิ่มข้อมูลพนักงาน</h2>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="../include/action.php" method="post">
                    <input type="hidden" name="tb_name" value="tb_employees">
                    <input type="hidden" name="action" value="insert">

                    <?= input_text("i_EmployeeID", "รหัสพนักงาน", "number", $NewID, "รหัสพนักงานอัตโนมัติ", true); ?>
                    <?= input_text("c_FirstName", "ชื่อ", "text", null, "กรอกชื่อพนักงาน", false, true); ?>
                    <?= input_text("c_LastName", "นามสกุล", "text", null, "กรอกนามสกุล", false, true); ?>
                    <?= input_text("c_BirthDate", "วันเกิด", "date", null, "", false, false); ?>
                    <div class="text-center mt-4">
                        <a href="../db_employees_search.php" class="btn btn-secondary me-2">ย้อนกลับ</a>
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