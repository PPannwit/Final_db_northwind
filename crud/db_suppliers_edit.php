<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$supplier = getEdit($pdo, 'tb_suppliers', 'i_SupplierID', $_REQUEST['pid']);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลผู้จัดจำหน่าย</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Icon & Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(90deg, rgba(42,123,155,1) 7%, rgb(3,72,193) 50%, rgb(2,151,192) 100%);
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body>
<?php require_once '../include/navbar.php'; ?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="card w-75 shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">แก้ไขข้อมูลผู้จัดจำหน่าย</h3>
        </div>
        <div class="card-body">
            <form id="editForm" action="../include/action.php" method="post">
                <input type="hidden" name="tb_name" value="tb_suppliers">
                <input type="hidden" name="action" value="update">

                <?= input_text("i_SupplierID", "รหัสผู้จัดจำหน่าย", "number", $supplier["i_SupplierID"], "รหัสผู้จัดจำหน่าย", true); ?>
                <?= input_text("c_SupplierName", "ชื่อผู้จัดจำหน่าย", "text", $supplier["c_SupplierName"], "กรุณากรอกชื่อผู้จัดจำหน่าย"); ?>
                <?= input_text("c_ContactName", "ชื่อผู้ติดต่อ", "text", $supplier["c_ContactName"], "กรุณากรอกชื่อผู้ติดต่อ"); ?>
                <?= input_text("c_Address", "ที่อยู่", "text", $supplier["c_Address"], "กรุณากรอกที่อยู่"); ?>
                <?= input_text("c_City", "เมือง", "text", $supplier["c_City"], "กรุณากรอกชื่อเมือง"); ?>
                <?= input_text("c_Phone", "เบอร์โทรศัพท์", "text", $supplier["c_Phone"], "กรุณากรอกเบอร์โทรศัพท์"); ?>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        บันทึกข้อมูล
                    </button>
                </div>

                <!-- Modal ยืนยันการบันทึก -->
                <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="confirmModalLabel">ยืนยันการบันทึก</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลผู้จัดจำหน่ายหรือไม่?</p>
                                <small class="text-muted">กรุณาตรวจสอบข้อมูลให้ถูกต้องก่อนกดยืนยัน</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button id="confirmSaveBtn" type="button" class="btn btn-primary">ยืนยันและบันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const confirmBtn = document.getElementById('confirmSaveBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function () {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '⏳ กำลังบันทึก...';
            const form = document.getElementById('editForm');
            if (form) form.submit();
        });
    }
});
</script>
</body>
</html>
