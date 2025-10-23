<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

// Load employee record by pid or eid (posted from search page)
$employee = [];
$pid = '';
if (isset($_POST['pid']) && $_POST['pid'] !== '') $pid = $_POST['pid'];
if (isset($_POST['eid']) && $_POST['eid'] !== '') $pid = $_POST['eid'];
if ($pid !== '') {
    $employee = getEdit($pdo, 'tb_employees', 'i_EmployeeID', $pid);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
            <div class="card-header">
                <h2 class="text-center">แก้ไขข้อมูลพนักงาน</h2></div>
                <div class="card-body">
                    <form id="editForm" action="../include/action.php" method="post">
                        <input type="hidden" name="tb_name" value="tb_employees">
                        <input type="hidden" name="action" value="update">
                        <?= input_text("i_EmployeeID", "รหัสพนักงาน", "number", ($employee['i_EmployeeID'] ?? ''), "กรุณากรอกรหัสพนักงาน", true); ?>
                        <?= input_text("c_LastName", "นามสกุล", "text", ($employee['c_LastName'] ?? ''), "กรุณากรอกนามสกุล"); ?>
                        <?= input_text("c_FirstName", "ชื่อ", "text", ($employee['c_FirstName'] ?? ''), "กรุณากรอกชื่อ"); ?>
                        <?= input_text("c_BirthDate", "วันเกิด", "date", ($employee['c_BirthDate'] ?? ''), ""); ?>

                    <!-- Array ( [i_EmployeeID] => 1 [c_LastName] => Davolio [c_FirstName] => Nancy [c_BirthDate] => 8/12/1968 [c_Photo] => EmpID1.pic [c_Notes] 
                    => Education includes a BA in psychology from Colorado State University. She also c ) -->

                        <div class="text-center mt-4">
                            <a href="../db_employees_search.php" class="btn btn-secondary me-2">ย้อนกลับ</a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#confirmModal">
                                บันทึกข้อมูล
                            </button>
                            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="confirmModalLabel">ยืนยันการบันทึก</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-2">คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลพนักงานใช่หรือไม่?</p>
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
                    </form>
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